/* Table of Contents
--------------------------------------------------------------------------------------
*/
(function($) {
"use strict";
var WITHEMES = WITHEMES || {};
    
// cache element to hold reusable elements
WITHEMES.cache = {
    $document : {},
    $window   : {}
}

// Create cross browser requestAnimationFrame method:
window.requestAnimationFrame = window.requestAnimationFrame
|| window.mozRequestAnimationFrame
|| window.webkitRequestAnimationFrame
|| window.msRequestAnimationFrame
|| function(f){setTimeout(f, 1000/60)}

/**
 * Init functions
 *
 * @since 1.0
 */
WITHEMES.init = function() {

    /**
     * cache elements for faster access
     *
     * @since 1.3
     */
    WITHEMES.cache.$document = $(document);
    WITHEMES.cache.$window = $(window);

    WITHEMES.cache.$document.ready(function() {

        WITHEMES.reInit();

    });

}

/* reInit
--------------------------------------------------------------------------------------------- */
WITHEMES.reInit = function() {
    
    WITHEMES.fitvids();
    WITHEMES.sticky();
    WITHEMES.tipsy();
    WITHEMES.flexslider();
    WITHEMES.topbar_search();
    // WITHEMES.mobilenav();
    WITHEMES.superfish();
    WITHEMES.mega();
    WITHEMES.offcanvas();
    WITHEMES.waypoint();
    WITHEMES.lightbox();
    WITHEMES.woocommerce_quantity();
}

/* Mobile Check
--------------------------------------------------------------------------------------------- */
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

/* Fitvids
--------------------------------------------------------------------------------------------- */
WITHEMES.fitvids = function(){
	if ( !$().fitVids ) {
        return;
    }

    $('.entry-content, .media-container').fitVids();
    
}; // fitvids
    
/* Flexslider
--------------------------------------------------------------------------------------------- */
WITHEMES.flexslider = function(){
    if ( ! $().flexslider ) {
        return;
    }
    
    WITHEMES.cache.$window.load(function(){
        $('.wi-flexslider').each(function(){
            var $this = $(this),
                slider = $this.find( '.flexslider' ),
                defaultOptions = {
                    animation: 'fade',
                    direction: 'horizontal',
                    slideshow: false,                //Boolean: Animate slider automatically
                    slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: 900,
                    
                    prevText : '<i class="fa fa-angle-left"></i>',
                    nextText : '<i class="fa fa-angle-right"></i>',
                    
                    controlNav : false,
                    directionNav : true,
                    
                    multipleKeyboard : true,
                    smoothHeight : true,
                },
                args = $this.data( 'options' ),
                options = $.extend( defaultOptions, args );
            
            slider.flexslider( options );
            
        });
    }); // window load
}

/* Topbar Search
--------------------------------------------------------------------------------------------- */
WITHEMES.topbar_search = function() {
    $('#topbar_search .mobile_submit').on('click', function(){
        $('#mobile_search').slideToggle('fast',function(){ $('#mobile_search').find('.s').focus(); });
        return false;
    });
}

/* Tipsy
--------------------------------------------------------------------------------------------- */
WITHEMES.tipsy = function() {
    if ( !$().tipsy ) {
        return;
    }
    
    $('.has-tip').tipsy({
        fade	:	true,
		gravity	: 	's',
		opacity	:	'.9',
    });
    
    $('#wi-topbar .social-list ul a').tipsy({
        fade	:	false,
		gravity	: 	'n',
		opacity	:	'.9',
    });
    
}

/* Mobile Nav
--------------------------------------------------------------------------------------------- */
WITHEMES.mobilenav = function() {
    if ( !$().slicknav ) {
        return;
    }
    
    $('#wi-mainnav div.menu').slicknav({
        allowParentLinks : true,
        prependTo : '#mobilemenu',
    });
    
}

/* Sticky
--------------------------------------------------------------------------------------------- */
WITHEMES.sticky = function() {
    
    var init = debounce( function() {
        
        if ( ! window.matchMedia( '(min-width:940px)' ).matches ) {
            return;
        }
    
        var header = $('#wi-mainnav'),
            header_top = header.length ? header.offset().top : 0,
            header_h = header.outerHeight(),
            delay_distance = 120;

        function sticky() {

            if ( !header.length ) {
                return;
            }

            if ( WITHEMES.cache.$window.scrollTop() > header_top + header_h + delay_distance ) {
                header.addClass('before-sticky is-sticky');
            } else if ( WITHEMES.cache.$window.scrollTop() > header_top + header_h ) {
                header.removeClass('is-sticky');
                header.addClass('before-sticky');
            } else {
                header.removeClass('is-sticky before-sticky');
            }

        }

        sticky();
        WITHEMES.cache.$window.scroll(sticky);
        
    }, 100 );
    
    init();
    
    WITHEMES.cache.$window.resize( init );
    
}

/* Superfish
--------------------------------------------------------------------------------------------- */
WITHEMES.superfish = function(){
    if ( !$().superfish ) {
        return;
    }
    $( '#wi-mainnav div.menu, #menu-topbar' ).superfish({
        delay : 500,
        speed : 0,
    });
}

/* Mega Menu Column
--------------------------------------------------------------------------------------------- */
WITHEMES.mega = function() {

    $( '#wi-mainnav div.menu' ).find( '>ul >li.mega' ).each(function() {
        var col = $( this ).find( '>ul>li' ).length;
        $( this ).addClass( 'column-' + col );
    });
    
}

/* Off Canvas Menu
--------------------------------------------------------------------------------------------- */
WITHEMES.offcanvas = function() {
    
    var hamburger = $( '#hamburger' ),
        offcanvas = $( '#offcanvas' );
    
    var offcanvas_dismiss = debounce(function( e ) {
        
        e.preventDefault();
        $( 'html' ).removeClass( 'offcanvas-open' );
        
    }, 100 );
    
    WITHEMES.cache.$document.on( 'click touchstart', '#hamburger', function( e ) {
    
        e.preventDefault();
        $( 'html' ).toggleClass( 'offcanvas-open' );
    
    });
    
    $( '#offcanvas-overlay' ).on( 'click touchstart', offcanvas_dismiss );
    
    WITHEMES.cache.$window.resize(offcanvas_dismiss);
    
    // Submenu Click
    $( '#mobilenav li, #mobile-topbarnav li' ).click(function( e ) {
    
        var li = $( this ),
            a = li.find( '> a ' ),
            href = a.attr( 'href' ),
            target = $( e.target ),
            ul = li.find( '> ul' ),
            
            condition1 = ( ! target.is( ul ) && ! target.closest( ul ).length ),
            condition2 = ( ( ! target.is( a ) && ! target.closest( a ).length ) || ( ! href || '#' == href ) );
        
        if (  condition1 && condition2 ) {
            
            e.preventDefault();
            ul.slideToggle( 300, 'easeOutCubic' );
            
        }
    
    });

}

/* Waypoint
--------------------------------------------------------------------------------------------- */
WITHEMES.waypoint = function() {
    if ( ! $().withemes_waypoint )
        return;
    
    $( '.animation_element' ).each(function() {
        
        var $this = $( this ),
            delay = parseInt( $this.data( 'delay' ) );
        
        $this.withemes_waypoint(function(){
            
            setTimeout(function(){
                
                $this.addClass( 'running' );
            
            }, 100 + delay );
        
        }, { offset: '85%' });
    
    });
}

/* ilightbox
 * @since 1.3
 * @depricated since 2.0
--------------------------------------------------------------------------------------------- */
WITHEMES.ilightbox = function() {
    
    // iLightbox required
    if ( ! $().iLightBox ) return;

    $( '.wi-lightbox-gallery, .woocommerce div.product div.images' ).each(function(){

        var $this = $( this ),
            items = $this.is( '.woocommerce div.product div.images' ) ? 'a' : 'a.lightbox-link';
        $this.find( items ).iLightBox({

            path: 'horizontal',
            controls : {
                arrows : false,
            },
            overlay : {
                opacity : .95,
            },
            styles : {
                nextOffsetX: 150,
                nextScale: 0.94,
                prevOffsetX: 150,
                prevScale: 0.94,
            },
            effects : {
                repositionSpeed : 600,
                switchSpeed : 600,
            },
            skin: 'metro-white-skin',
            infinite: true,
            social: {
              buttons: {
                facebook: true,
                twitter: true,
                googleplus: true,
              }
            }

        });

    });
    
}

/**
 * Magnific Popup
 */
WITHEMES.lightbox = function() {

    if ( ! $().magnificPopup ) {
        return;
    }

    $( '.open-lightbox' ).magnificPopup({
        type: 'image',
    });

    $( '.wi-lightbox-gallery, .woocommerce div.product div.images' ).each(function() {

        var gallery = $( this ),
            delegate = gallery.is( '.woocommerce div.product div.images' ) ? 'a' : 'a.lightbox-link';;

        var defaultOptions = {
                type : 'image',
                delegate : delegate,
                removalDelay : 400,
                gallery: {
                    enabled:true,
                    arrowMarkup : '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir%"></i></button>',
                },
                closeBtnInside : true,
                closeMarkup : '<button title="%title%" type="button" class="mfp-close"><i class="fa fa-close"></i></button>',

                callbacks: {

                    open: function() {

                        $.magnificPopup.instance.next = function() {
                            var self = this;
                            self.wrap.removeClass( 'mfp-image-loaded' );
                            setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
                        }
                        $.magnificPopup.instance.prev = function() {
                            var self = this;
                            self.wrap.removeClass( 'mfp-image-loaded' );
                            setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
                        }

                    },

                    imageLoadComplete: function() {	
                        var self = this;
                        setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
                    },

                }

            },
            args = gallery.data( 'options' ),
            options = $.extend( defaultOptions, args );

        gallery.magnificPopup( options );

    });

}

/* WooCommerce Quantity Buttons
 * @since 1.3
--------------------------------------------------------------------------------------------- */
WITHEMES.woocommerce_quantity = function() {

    // Quantity buttons
    $( 'div.quantity:not(.buttons-added), td.quantity:not(.buttons-added)' )
    .addClass( 'buttons-added' )
    .append( '<input type="button" value="+" class="plus" />' )
    .prepend( '<input type="button" value="-" class="minus" />' );

    // Set min value
    $( 'input.qty:not(.product-quantity input.qty)' ).each ( function() {
        var qty = $( this ),
            min = parseFloat( qty.attr( 'min' ) );
        if ( min && min > 0 && parseFloat( qty.val() ) < min ) {
            qty.val( min );
        }
    });

    // Handle click event
    WITHEMES.cache.$document.on( 'click', '.plus, .minus', function() {

            // Get values
        var qty = $( this ).closest( '.quantity' ).find( '.qty' ),
            currentQty = parseFloat( qty.val() ),
            max = parseFloat( qty.attr( 'max' ) ),
            min = parseFloat( qty.attr( 'min' ) ),
            step = qty.attr( 'step' );

        // Format values
        if ( !currentQty || currentQty === '' || currentQty === 'NaN' ) currentQty = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

        // Change the value
        if ( $( this ).is( '.plus' ) ) {

            if ( max && ( max == currentQty || currentQty > max ) ) {
                qty.val( max );
            } else {
                qty.val( currentQty + parseFloat( step ) );
            }

        } else {

            if ( min && ( min == currentQty || currentQty < min ) ) {
                qty.val( min );
            } else if ( currentQty > 0 ) {
                qty.val( currentQty - parseFloat( step ) );
            }

        }

        // Trigger change event
        qty.trigger( 'change' );

    });

}
 
/**
 * Finally, call the init
 */
WITHEMES.init();
    
})( jQuery );	// EOF