/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {
    
    var api = wp.customize,
        fontsLoaded = [],
        typekitLoaded = [];
    
    // Inline CSS not exists, insert it to <head />
    var style = $( '#color-preview' );
    if ( ! style.length ) {
        style = $( '<style id="color-preview" />' );
        $( 'head' ).append( style );
    }
    
    // SIMPLE CSS RULES
	api.bind( 'preview-ready', function() {
        
        // Theme CSS
		api.preview.bind( 'update-jasmine-theme-style', function( css ) {
            // We need only live preview CSS
			style.html( css );
		} );
        
        // Load Typekit
        api.preview.bind( 'loadtypekit', function( data ) {
            
            // We only load fonts haven't loaded yet
            if ( -1 === typekitLoaded.indexOf ( data[ 'typekit' ] ) ) {
                
                WebFont.load({
                    typekit: {
                        id : data[ 'typekit' ]
                    },
                    active : function() {
                        console.log( 'Successfully loaded the kit: ' + data[ 'typekit' ] );
                        
                        // append to array of fonts
                        typekitLoaded.push( data[ 'typekit' ] );
                    },
                    inactive : function() {
                        console.error( 'Cannot load the kit: ' + data[ 'typekit' ] );
                    },
                    timeout: 4000 // Set the timeout to two seconds
                });
            }
            
        } ); // typekit load
        
	});
    
} )( jQuery );