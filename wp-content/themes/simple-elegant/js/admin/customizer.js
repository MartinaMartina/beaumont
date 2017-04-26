/**
 * @since 2.0
 */
( function( $ , WITHEMES_CUSTOMIZER, api ) {
    
    window.loadconcept = function() {
        
        /**
         * Load Settings from a particular file
         *
         * @param file is the file path
         */
        var load_settings = function( options ) {
        
            $.each( options, function( id, value ){

                var instance = api.instance( id );
                if ( ! instance ) {
                    console.log( id );
                } else {
                    instance.set( value );
                }

            });
            
        }
        
        // LOAD THE KIT
        // ===========================
        $( '.loadconcept' ).on( 'click', function( e ) {
        
            e.preventDefault();
            var currentSelection = api.instance( 'withemes_concept' ).get(),
                options = WITHEMES_CUSTOMIZER.concepts[ currentSelection ];
            
            if ( confirm( 'Some current settings will be replaced by predefined settings from concept. Are you sure?' ) ) {
                load_settings( options );
            }
        
        });

    }
    
    // MULTICHECKBOX
    // ========================
	api.controlConstructor.multicheckbox = api.Control.extend({
		ready: function() {
            var control = this,
                hidden = this.container.find( '.checkbox-result' ),
				inputs = this.container.find( 'input[type="checkbox"]' ),
                values = control.setting();
            
            if ( 'string' === typeof values ) values = values.split( ',' );
            
            inputs.each(function(){
                var checked = values.indexOf( $(this).attr( 'value' ) ) > -1;
                $( this ).prop( 'checked', checked );
            });
            
            // set deafult
            if ( 'string' !== typeof values ) values = values.join( ',' );
            hidden.val( values );
            
            // input changes
            inputs.change(function(){
                
                var checkbox_values = control.container.find( 'input[type="checkbox"]:checked' ).map(
                    function(){
                        return this.value;
                    }
                ).get().join( ',' );
                
                control.setting.set( checkbox_values );
                
            });
            
		}
	});
    
    // IMAGE RADIO
    // ========================
    api.controlConstructor.image_radio = api.Control.extend( {
        
        ready: function() {
            var control = this,
                container = this.container,
                params = this.params,
                type = params.type,
                input;
            
            input = container.find( 'input[type="radio"]' );
            input.filter('[value=\'' + control.setting() + '\']').prop( 'checked', true );

            input.on( 'change', function() {
                var value = container.find( 'input[type="radio"]:checked' ).val();
                control.setting.set( value );
            });

            // when setting changes
            this.setting.bind( function ( value ) {

                input.filter('[value=\'' + value + '\']').prop( 'checked', true );

            });
		}
        
    });
    
    /**
	 * Handmade colorpicker to support RGBA
     *
     * @since 2.0
	 */
	api.controlConstructor.withemes_color = api.Control.extend({
		ready: function() {
            var control = this,
				picker = this.container.find( '.withemes-colorpicker' ),
                args = {
                    showAlpha: true,
                    showInput: true,
                    preferredFormat: "hex",
                    allowEmpty:true,
                    showPalette: true,
                    showSelectionPalette : false,
                    palette: palette,
                    move: function( color ) {
                        if ( color ) {
                            if ( color._a && color._a < 1 ) color = color.toRgbString();
                            else color = color.toHexString();
                        } else
                            color = '';
                        
                        control.setting.set( color );
                    },
                };
            
            args.change = args.move;

            // set default & when input changes
            picker
            .val( control.setting() )
            .spectrum( args );
            
            // Update the palette
            $( window ).on( 'palette_update', picker, function( e, data ) {
                
                palette = data.palette;
                
                picker.spectrum( 'option', 'palette', palette );
            
            });

            // setting changes
			this.setting.bind( function ( value ) {
				picker.val( value );
				picker.spectrum( 'set', value );
			});
            
		}
	});
    
    /**
     * Control Toggle shows & hides optons conditionally for better UX
     *
     * @since 2.0
     */ 
    window.control_toggle = function( id, option ) {
            
        // TOGGLE OPTIONS
        //
        // Take some examples to illustrate
        // option = withemes_logo_type
        // toggle = { 'text': [ 'withemes_logo_size', 'withemes_logo_face'], 'image' : [ 'withemes_logo_width', 'withemes_logo_height' ] }
        
        api.control( id, function( control ) {
        
            // Ignore options with display none state
            // Or has no toggle
            if ( 'none' == control.container.css( 'display' ) || undefined === option.toggle )
                return;

            // id = withemes_logo_type
            api( id, function( setting ) {

                // value = 'text'
                // elements = [ 'withemes_logo_size', 'withemes_logo_face' ]
                $.each( option.toggle, function( value, elements ) {

                    // elementID = withemes_logo_size
                    // each element ID should appear only once
                    $.each( elements, function( j, elementID ) {

                        api.control( elementID, function( control ) {
                            // to = current setting
                            var visibility = function ( to ) {
                                
                                // true and 'true'
                                if ( true === to ) {
                                    to = '1';
                                } else if ( false === to ) {
                                    to = '0';
                                }

                                // Hide everything except elements in current value
                                var toggle_Bool = ( to === value || ( undefined !== option.toggle[ to ] && option.toggle[ to ].indexOf( elementID ) > -1 ) );

                                var triggerEvent = toggle_Bool ? 'control_show' : 'control_hide';
                                
                                control.container
                                .toggle( toggle_Bool )
                                .trigger( triggerEvent );

                            };

                            visibility( setting.get() );

                            setting.bind( visibility );

                        }); // control

                    }); // each elements

                }); // option.toggle

            });

        }); // control

    } // funtion control_toggle
    
    /**
     * Live Preview and Conditionalize
     *
     * @since 2.0
     */
    api.bind( 'ready', function() {
        
        loadconcept();
        
        var settings = api.settings.settings;
        
        // Update the CSS whenever a setting is changed.
        _.each( api.settings.controls, function( option ) {
            
            var id = option.settings.default,
                transport = 'undefined' != typeof settings[id] ? settings[id].transport : '',
                selector = option.selector,
                property = option.property;
            
            /**
             * Toggle options for a better UX
             *
             * @since 2.0
             */
            api.control( id, function( control ) {
                
                if ( ! option.toggle ) return;
                
                control.container.on( 'control_show', function() {
                    control_toggle( id, option );
                }); // on show
                
                control.container.on( 'control_hide', function() {
                    
                    // value: leftright
                    // elements: left_1, left_2, right_1, right_2
                    $.each( option.toggle, function( value, elements ) {
                        
                        // elementID: // left_1
                        $.each( elements, function( j, elementID ) {
                        
                            api.control( elementID, function( control2 ) {
                                
                                control2.container
                                .hide()
                                .trigger( 'control_hide' );

                            }); // control
                            
                        });
                        
                    }); // each
                    
                }); // on show
            
            });
            
        }); // each
        
        // trigger control_toggle onload
        _.each( api.settings.controls, function( option ) {
            
            var id = option.settings.default;
            control_toggle( id, option );
            
        }); // each
    
    } );
    
} )( jQuery, WITHEMES_CUSTOMIZER, wp.customize );