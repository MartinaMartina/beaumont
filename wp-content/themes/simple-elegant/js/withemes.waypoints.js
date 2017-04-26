/*!
withemesWaypoints - 4.0.0
Copyright © 2011-2015 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/withemes_waypoints/blob/master/licenses.txt
*/
(function() {
  'use strict'

  var keyCounter = 0
  var allwithemesWaypoints = {}

  /* http://imakewebthings.com/withemes_waypoints/api/withemes_waypoint */
  function withemesWaypoint(options) {
    if (!options) {
      throw new Error('No options passed to withemesWaypoint constructor')
    }
    if (!options.element) {
      throw new Error('No element option passed to withemesWaypoint constructor')
    }
    if (!options.handler) {
      throw new Error('No handler option passed to withemesWaypoint constructor')
    }

    this.key = 'withemes_waypoint-' + keyCounter
    this.options = withemesWaypoint.Adapter.extend({}, withemesWaypoint.defaults, options)
    this.element = this.options.element
    this.adapter = new withemesWaypoint.Adapter(this.element)
    this.callback = options.handler
    this.axis = this.options.horizontal ? 'horizontal' : 'vertical'
    this.enabled = this.options.enabled
    this.triggerPoint = null
    this.group = withemesWaypoint.Group.findOrCreate({
      name: this.options.group,
      axis: this.axis
    })
    this.context = withemesWaypoint.Context.findOrCreateByElement(this.options.context)

    if (withemesWaypoint.offsetAliases[this.options.offset]) {
      this.options.offset = withemesWaypoint.offsetAliases[this.options.offset]
    }
    this.group.add(this)
    this.context.add(this)
    allwithemesWaypoints[this.key] = this
    keyCounter += 1
  }

  /* Private */
  withemesWaypoint.prototype.queueTrigger = function(direction) {
    this.group.queueTrigger(this, direction)
  }

  /* Private */
  withemesWaypoint.prototype.trigger = function(args) {
    if (!this.enabled) {
      return
    }
    if (this.callback) {
      this.callback.apply(this, args)
    }
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/destroy */
  withemesWaypoint.prototype.destroy = function() {
    this.context.remove(this)
    this.group.remove(this)
    delete allwithemesWaypoints[this.key]
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/disable */
  withemesWaypoint.prototype.disable = function() {
    this.enabled = false
    return this
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/enable */
  withemesWaypoint.prototype.enable = function() {
    this.context.refresh()
    this.enabled = true
    return this
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/next */
  withemesWaypoint.prototype.next = function() {
    return this.group.next(this)
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/previous */
  withemesWaypoint.prototype.previous = function() {
    return this.group.previous(this)
  }

  /* Private */
  withemesWaypoint.invokeAll = function(method) {
    var allwithemesWaypointsArray = []
    for (var withemes_waypointKey in allwithemesWaypoints) {
      allwithemesWaypointsArray.push(allwithemesWaypoints[withemes_waypointKey])
    }
    for (var i = 0, end = allwithemesWaypointsArray.length; i < end; i++) {
      allwithemesWaypointsArray[i][method]()
    }
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/destroy-all */
  withemesWaypoint.destroyAll = function() {
    withemesWaypoint.invokeAll('destroy')
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/disable-all */
  withemesWaypoint.disableAll = function() {
    withemesWaypoint.invokeAll('disable')
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/enable-all */
  withemesWaypoint.enableAll = function() {
    withemesWaypoint.invokeAll('enable')
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/refresh-all */
  withemesWaypoint.refreshAll = function() {
    withemesWaypoint.Context.refreshAll()
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/viewport-height */
  withemesWaypoint.viewportHeight = function() {
    return window.innerHeight || document.documentElement.clientHeight
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/viewport-width */
  withemesWaypoint.viewportWidth = function() {
    return document.documentElement.clientWidth
  }

  withemesWaypoint.adapters = []

  withemesWaypoint.defaults = {
    context: window,
    continuous: true,
    enabled: true,
    group: 'default',
    horizontal: false,
    offset: 0
  }

  withemesWaypoint.offsetAliases = {
    'bottom-in-view': function() {
      return this.context.innerHeight() - this.adapter.outerHeight()
    },
    'right-in-view': function() {
      return this.context.innerWidth() - this.adapter.outerWidth()
    }
  }

  window.withemesWaypoint = withemesWaypoint
}())
;(function() {
  'use strict'

  function requestAnimationFrameShim(callback) {
    window.setTimeout(callback, 1000 / 60)
  }

  var keyCounter = 0
  var contexts = {}
  var withemesWaypoint = window.withemesWaypoint
  var oldWindowLoad = window.onload

  /* http://imakewebthings.com/withemes_waypoints/api/context */
  function Context(element) {
    this.element = element
    this.Adapter = withemesWaypoint.Adapter
    this.adapter = new this.Adapter(element)
    this.key = 'withemes_waypoint-context-' + keyCounter
    this.didScroll = false
    this.didResize = false
    this.oldScroll = {
      x: this.adapter.scrollLeft(),
      y: this.adapter.scrollTop()
    }
    this.withemes_waypoints = {
      vertical: {},
      horizontal: {}
    }

    element.withemes_waypointContextKey = this.key
    contexts[element.withemes_waypointContextKey] = this
    keyCounter += 1

    this.createThrottledScrollHandler()
    this.createThrottledResizeHandler()
  }

  /* Private */
  Context.prototype.add = function(withemes_waypoint) {
    var axis = withemes_waypoint.options.horizontal ? 'horizontal' : 'vertical'
    this.withemes_waypoints[axis][withemes_waypoint.key] = withemes_waypoint
    this.refresh()
  }

  /* Private */
  Context.prototype.checkEmpty = function() {
    var horizontalEmpty = this.Adapter.isEmptyObject(this.withemes_waypoints.horizontal)
    var verticalEmpty = this.Adapter.isEmptyObject(this.withemes_waypoints.vertical)
    if (horizontalEmpty && verticalEmpty) {
      this.adapter.off('.withemes_waypoints')
      delete contexts[this.key]
    }
  }

  /* Private */
  Context.prototype.createThrottledResizeHandler = function() {
    var self = this

    function resizeHandler() {
      self.handleResize()
      self.didResize = false
    }

    this.adapter.on('resize.withemes_waypoints', function() {
      if (!self.didResize) {
        self.didResize = true
        withemesWaypoint.requestAnimationFrame(resizeHandler)
      }
    })
  }

  /* Private */
  Context.prototype.createThrottledScrollHandler = function() {
    var self = this
    function scrollHandler() {
      self.handleScroll()
      self.didScroll = false
    }

    this.adapter.on('scroll.withemes_waypoints', function() {
      if (!self.didScroll || withemesWaypoint.isTouch) {
        self.didScroll = true
        withemesWaypoint.requestAnimationFrame(scrollHandler)
      }
    })
  }

  /* Private */
  Context.prototype.handleResize = function() {
    withemesWaypoint.Context.refreshAll()
  }

  /* Private */
  Context.prototype.handleScroll = function() {
    var triggeredGroups = {}
    var axes = {
      horizontal: {
        newScroll: this.adapter.scrollLeft(),
        oldScroll: this.oldScroll.x,
        forward: 'right',
        backward: 'left'
      },
      vertical: {
        newScroll: this.adapter.scrollTop(),
        oldScroll: this.oldScroll.y,
        forward: 'down',
        backward: 'up'
      }
    }

    for (var axisKey in axes) {
      var axis = axes[axisKey]
      var isForward = axis.newScroll > axis.oldScroll
      var direction = isForward ? axis.forward : axis.backward

      for (var withemes_waypointKey in this.withemes_waypoints[axisKey]) {
        var withemes_waypoint = this.withemes_waypoints[axisKey][withemes_waypointKey]
        var wasBeforeTriggerPoint = axis.oldScroll < withemes_waypoint.triggerPoint
        var nowAfterTriggerPoint = axis.newScroll >= withemes_waypoint.triggerPoint
        var crossedForward = wasBeforeTriggerPoint && nowAfterTriggerPoint
        var crossedBackward = !wasBeforeTriggerPoint && !nowAfterTriggerPoint
        if (crossedForward || crossedBackward) {
          withemes_waypoint.queueTrigger(direction)
          triggeredGroups[withemes_waypoint.group.id] = withemes_waypoint.group
        }
      }
    }

    for (var groupKey in triggeredGroups) {
      triggeredGroups[groupKey].flushTriggers()
    }

    this.oldScroll = {
      x: axes.horizontal.newScroll,
      y: axes.vertical.newScroll
    }
  }

  /* Private */
  Context.prototype.innerHeight = function() {
    /*eslint-disable eqeqeq */
    if (this.element == this.element.window) {
      return withemesWaypoint.viewportHeight()
    }
    /*eslint-enable eqeqeq */
    return this.adapter.innerHeight()
  }

  /* Private */
  Context.prototype.remove = function(withemes_waypoint) {
    delete this.withemes_waypoints[withemes_waypoint.axis][withemes_waypoint.key]
    this.checkEmpty()
  }

  /* Private */
  Context.prototype.innerWidth = function() {
    /*eslint-disable eqeqeq */
    if (this.element == this.element.window) {
      return withemesWaypoint.viewportWidth()
    }
    /*eslint-enable eqeqeq */
    return this.adapter.innerWidth()
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/context-destroy */
  Context.prototype.destroy = function() {
    var allwithemesWaypoints = []
    for (var axis in this.withemes_waypoints) {
      for (var withemes_waypointKey in this.withemes_waypoints[axis]) {
        allwithemesWaypoints.push(this.withemes_waypoints[axis][withemes_waypointKey])
      }
    }
    for (var i = 0, end = allwithemesWaypoints.length; i < end; i++) {
      allwithemesWaypoints[i].destroy()
    }
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/context-refresh */
  Context.prototype.refresh = function() {
    /*eslint-disable eqeqeq */
    var isWindow = this.element == this.element.window
    /*eslint-enable eqeqeq */
    var contextOffset = isWindow ? undefined : this.adapter.offset()
    var triggeredGroups = {}
    var axes

    this.handleScroll()
    axes = {
      horizontal: {
        contextOffset: isWindow ? 0 : contextOffset.left,
        contextScroll: isWindow ? 0 : this.oldScroll.x,
        contextDimension: this.innerWidth(),
        oldScroll: this.oldScroll.x,
        forward: 'right',
        backward: 'left',
        offsetProp: 'left'
      },
      vertical: {
        contextOffset: isWindow ? 0 : contextOffset.top,
        contextScroll: isWindow ? 0 : this.oldScroll.y,
        contextDimension: this.innerHeight(),
        oldScroll: this.oldScroll.y,
        forward: 'down',
        backward: 'up',
        offsetProp: 'top'
      }
    }

    for (var axisKey in axes) {
      var axis = axes[axisKey]
      for (var withemes_waypointKey in this.withemes_waypoints[axisKey]) {
        var withemes_waypoint = this.withemes_waypoints[axisKey][withemes_waypointKey]
        var adjustment = withemes_waypoint.options.offset
        var oldTriggerPoint = withemes_waypoint.triggerPoint
        var elementOffset = 0
        var freshwithemesWaypoint = oldTriggerPoint == null
        var contextModifier, wasBeforeScroll, nowAfterScroll
        var triggeredBackward, triggeredForward

        if (withemes_waypoint.element !== withemes_waypoint.element.window) {
          elementOffset = withemes_waypoint.adapter.offset()[axis.offsetProp]
        }

        if (typeof adjustment === 'function') {
          adjustment = adjustment.apply(withemes_waypoint)
        }
        else if (typeof adjustment === 'string') {
          adjustment = parseFloat(adjustment)
          if (withemes_waypoint.options.offset.indexOf('%') > - 1) {
            adjustment = Math.ceil(axis.contextDimension * adjustment / 100)
          }
        }

        contextModifier = axis.contextScroll - axis.contextOffset
        withemes_waypoint.triggerPoint = elementOffset + contextModifier - adjustment
        wasBeforeScroll = oldTriggerPoint < axis.oldScroll
        nowAfterScroll = withemes_waypoint.triggerPoint >= axis.oldScroll
        triggeredBackward = wasBeforeScroll && nowAfterScroll
        triggeredForward = !wasBeforeScroll && !nowAfterScroll

        if (!freshwithemesWaypoint && triggeredBackward) {
          withemes_waypoint.queueTrigger(axis.backward)
          triggeredGroups[withemes_waypoint.group.id] = withemes_waypoint.group
        }
        else if (!freshwithemesWaypoint && triggeredForward) {
          withemes_waypoint.queueTrigger(axis.forward)
          triggeredGroups[withemes_waypoint.group.id] = withemes_waypoint.group
        }
        else if (freshwithemesWaypoint && axis.oldScroll >= withemes_waypoint.triggerPoint) {
          withemes_waypoint.queueTrigger(axis.forward)
          triggeredGroups[withemes_waypoint.group.id] = withemes_waypoint.group
        }
      }
    }

    withemesWaypoint.requestAnimationFrame(function() {
      for (var groupKey in triggeredGroups) {
        triggeredGroups[groupKey].flushTriggers()
      }
    })

    return this
  }

  /* Private */
  Context.findOrCreateByElement = function(element) {
    return Context.findByElement(element) || new Context(element)
  }

  /* Private */
  Context.refreshAll = function() {
    for (var contextId in contexts) {
      contexts[contextId].refresh()
    }
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/context-find-by-element */
  Context.findByElement = function(element) {
    return contexts[element.withemes_waypointContextKey]
  }

  window.onload = function() {
    if (oldWindowLoad) {
      oldWindowLoad()
    }
    Context.refreshAll()
  }

  withemesWaypoint.requestAnimationFrame = function(callback) {
    var requestFn = window.requestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      requestAnimationFrameShim
    requestFn.call(window, callback)
  }
  withemesWaypoint.Context = Context
}())
;(function() {
  'use strict'

  function byTriggerPoint(a, b) {
    return a.triggerPoint - b.triggerPoint
  }

  function byReverseTriggerPoint(a, b) {
    return b.triggerPoint - a.triggerPoint
  }

  var groups = {
    vertical: {},
    horizontal: {}
  }
  var withemesWaypoint = window.withemesWaypoint

  /* http://imakewebthings.com/withemes_waypoints/api/group */
  function Group(options) {
    this.name = options.name
    this.axis = options.axis
    this.id = this.name + '-' + this.axis
    this.withemes_waypoints = []
    this.clearTriggerQueues()
    groups[this.axis][this.name] = this
  }

  /* Private */
  Group.prototype.add = function(withemes_waypoint) {
    this.withemes_waypoints.push(withemes_waypoint)
  }

  /* Private */
  Group.prototype.clearTriggerQueues = function() {
    this.triggerQueues = {
      up: [],
      down: [],
      left: [],
      right: []
    }
  }

  /* Private */
  Group.prototype.flushTriggers = function() {
    for (var direction in this.triggerQueues) {
      var withemes_waypoints = this.triggerQueues[direction]
      var reverse = direction === 'up' || direction === 'left'
      withemes_waypoints.sort(reverse ? byReverseTriggerPoint : byTriggerPoint)
      for (var i = 0, end = withemes_waypoints.length; i < end; i += 1) {
        var withemes_waypoint = withemes_waypoints[i]
        if (withemes_waypoint.options.continuous || i === withemes_waypoints.length - 1) {
          withemes_waypoint.trigger([direction])
        }
      }
    }
    this.clearTriggerQueues()
  }

  /* Private */
  Group.prototype.next = function(withemes_waypoint) {
    this.withemes_waypoints.sort(byTriggerPoint)
    var index = withemesWaypoint.Adapter.inArray(withemes_waypoint, this.withemes_waypoints)
    var isLast = index === this.withemes_waypoints.length - 1
    return isLast ? null : this.withemes_waypoints[index + 1]
  }

  /* Private */
  Group.prototype.previous = function(withemes_waypoint) {
    this.withemes_waypoints.sort(byTriggerPoint)
    var index = withemesWaypoint.Adapter.inArray(withemes_waypoint, this.withemes_waypoints)
    return index ? this.withemes_waypoints[index - 1] : null
  }

  /* Private */
  Group.prototype.queueTrigger = function(withemes_waypoint, direction) {
    this.triggerQueues[direction].push(withemes_waypoint)
  }

  /* Private */
  Group.prototype.remove = function(withemes_waypoint) {
    var index = withemesWaypoint.Adapter.inArray(withemes_waypoint, this.withemes_waypoints)
    if (index > -1) {
      this.withemes_waypoints.splice(index, 1)
    }
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/first */
  Group.prototype.first = function() {
    return this.withemes_waypoints[0]
  }

  /* Public */
  /* http://imakewebthings.com/withemes_waypoints/api/last */
  Group.prototype.last = function() {
    return this.withemes_waypoints[this.withemes_waypoints.length - 1]
  }

  /* Private */
  Group.findOrCreate = function(options) {
    return groups[options.axis][options.name] || new Group(options)
  }

  withemesWaypoint.Group = Group
}())
;(function() {
  'use strict'

  var $ = window.jQuery
  var withemesWaypoint = window.withemesWaypoint

  function JQueryAdapter(element) {
    this.$element = $(element)
  }

  $.each([
    'innerHeight',
    'innerWidth',
    'off',
    'offset',
    'on',
    'outerHeight',
    'outerWidth',
    'scrollLeft',
    'scrollTop'
  ], function(i, method) {
    JQueryAdapter.prototype[method] = function() {
      var args = Array.prototype.slice.call(arguments)
      return this.$element[method].apply(this.$element, args)
    }
  })

  $.each([
    'extend',
    'inArray',
    'isEmptyObject'
  ], function(i, method) {
    JQueryAdapter[method] = $[method]
  })

  withemesWaypoint.adapters.push({
    name: 'jquery',
    Adapter: JQueryAdapter
  })
  withemesWaypoint.Adapter = JQueryAdapter
}())
;(function() {
  'use strict'

  var withemesWaypoint = window.withemesWaypoint

  function createExtension(framework) {
    return function() {
      var withemes_waypoints = []
      var overrides = arguments[0]

      if (framework.isFunction(arguments[0])) {
        overrides = framework.extend({}, arguments[1])
        overrides.handler = arguments[0]
      }

      this.each(function() {
        var options = framework.extend({}, overrides, {
          element: this
        })
        if (typeof options.context === 'string') {
          options.context = framework(this).closest(options.context)[0]
        }
        withemes_waypoints.push(new withemesWaypoint(options))
      })

      return withemes_waypoints
    }
  }

  if (window.jQuery) {
    window.jQuery.fn.extend({
        withemes_waypoint : createExtension(window.jQuery)
    });
  }
  if (window.Zepto) {
    window.Zepto.fn.withemes_waypoint = createExtension(window.Zepto)
  }
}())
;