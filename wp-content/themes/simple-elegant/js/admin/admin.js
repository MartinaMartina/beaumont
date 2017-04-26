/**
 * global WITHEMES_ADMIN
 *
 * @since 2.0
 */
(function( window, WITHEMES_ADMIN, $ ) {
"use strict";
    
    var WITHEMES_ADMIN = WITHEMES_ADMIN || {}
    
    // cache element to hold reusable elements
    WITHEMES_ADMIN.cache = {
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
     * @since 2.0
     */
    WITHEMES_ADMIN.init = function() {
        
        /**
         * cache elements for faster access
         *
         * @since 2.0
         */
        WITHEMES_ADMIN.cache.$document = $(document);
        WITHEMES_ADMIN.cache.$window = $(window);
        
        WITHEMES_ADMIN.cache.$document.ready(function() {
        
            WITHEMES_ADMIN.reInit();
            
        });
        
    }
    
    /**
     * Initialize functions
     *
     * And can be used as a callback function for ajax events to reInit
     *
     * This can be used as a table of contents as well
     *
     * @since 2.0
     */
    WITHEMES_ADMIN.reInit = function() {
        
        // File Upload
        WITHEMES_ADMIN.fileUpload();
     
        // image Upload
        WITHEMES_ADMIN.imageUpload();
        
        // multiple-image Upload
        WITHEMES_ADMIN.imagesUpload();
        
        // tab
        WITHEMES_ADMIN.tab();
        
    }
    
    // Conditional metabox
    // ========================
    WITHEMES_ADMIN.conditionalMetabox = function() {
        
        // lib required
        if ( ! $().metabox_conditionize ) {
            return;
        }
    
        $( '.withemes-metabox-field[data-cond-option]' ).metabox_conditionize();
        
    }
    
    // Thickbox File Upload
    // ========================
    WITHEMES_ADMIN.fileUpload = function() {
        
        var mediaUploader
    
        // Append Image Action
        WITHEMES_ADMIN.cache.$document.on( 'click', '.upload-file-button', function( e ) {
            
            e.preventDefault();
            
            var button = $( this ),
                uploadWrapper = button.closest( '.withemes-upload-wrapper' ),
                type = uploadWrapper.data( 'type' ),
                holder = uploadWrapper.find( '.file-holder' ),
                input = uploadWrapper.find( '.media-result' ),
                args = {
                    title: WITHEMES_ADMIN.l10n.choose_file,
                    button: {
                        text: WITHEMES_ADMIN.l10n.choose_file,
                    }, 
                    multiple: false,
                }
            
            if ( type ) {
                args.library = {
                    type: type,
                }
            }
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media(args);

            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on( 'select', function() {
                
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                
                // set value
                input.val(attachment.id);
                
                // show the holder
                holder.addClass( 'has-file' );
                
                // change button text
                button.val( WITHEMES_ADMIN.l10n.change_file );
                
            });
            // Open the uploader dialog
            mediaUploader.open();
        
        });
        
        // Remove Image Action
        WITHEMES_ADMIN.cache.$document.on( 'click', '.remove-file-button', function( e ) {
            
            e.preventDefault();
            
            var remove = $( this ),
                uploadWrapper = remove.closest( '.withemes-upload-wrapper' ),
                holder = uploadWrapper.find( '.file-holder' ),
                input = uploadWrapper.find( '.media-result' ),
                button = uploadWrapper.find( '.upload-file-button' );
            
            input.val('');
            holder.removeClass( 'has-file' );
            button.val( WITHEMES_ADMIN.l10n.upload_file );
            
        });
    
    }
    
    // Thickbox Image Upload
    // ========================
    WITHEMES_ADMIN.imageUpload = function() {
        
        var mediaUploader
    
        // Append Image Action
        WITHEMES_ADMIN.cache.$document.on( 'click', '.upload-image-button', function( e ) {
            
            e.preventDefault();
            
            var button = $( this ),
                uploadWrapper = button.closest( '.withemes-upload-wrapper' ),
                holder = uploadWrapper.find( '.image-holder' ),
                input = uploadWrapper.find( '.media-result' );
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: WITHEMES_ADMIN.l10n.choose_image,
                button: {
                    text: WITHEMES_ADMIN.l10n.choose_image,
                }, 
                multiple: false,
                library : {
                    type : 'image',
                    // HERE IS THE MAGIC. Set your own post ID var
                    // uploadedTo : wp.media.view.settings.post.id
                },
            });

            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on('select', function() {
                
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                
                if ( attachment.type == 'image' ) {

                    input.val(attachment.id);
                    holder.find('img').remove();
                    if ( attachment.sizes.medium ) {
                        holder.prepend( '<img src="' + attachment.sizes.medium.url + '" />' );
                    } else {
                        holder.prepend( '<img src="' + attachment.url + '" />' );
                    }
                    
                    button.val( WITHEMES_ADMIN.l10n.change_image );
                    
                }

            });
            // Open the uploader dialog
            mediaUploader.open();
        
        });
        
        // Remove Image Action
        WITHEMES_ADMIN.cache.$document.on( 'click', '.remove-image-button', function( e ) {
            
            e.preventDefault();
            
            var remove = $( this ),
                uploadWrapper = remove.closest( '.withemes-upload-wrapper' ),
                holder = uploadWrapper.find( '.image-holder' ),
                input = uploadWrapper.find( '.media-result' ),
                button = uploadWrapper.find( '.upload-image-button' );
            
            input.val('');
            holder.find( 'img' ).remove();
            button.val( WITHEMES_ADMIN.l10n.upload_image );
            
        });
    
    }
    
    // Upload Multiplage Images
    // ========================
    WITHEMES_ADMIN.imagesUpload = function() {
        
        var mediaUploader,
        
            sortableCall = function() {
            
                // sortable required
                if ( !$().sortable ) {
                    return;
                }

                $( '.images-holder' ).each(function() {

                    var $this = $( this );
                    $this.sortable({

                        placeholder: 'image-unit-placeholder', 

                        update: function(event, ui) {

                            // trigger event changed
                            var uploadWrapper = $this.closest( '.withemes-upload-wrapper' );
                            uploadWrapper.trigger( 'changed' );

                        }

                    }); // sortable

                    $this.disableSelection();

                });

            },
            
            refine = function() {
            
                var uploadWrapper = $( this ),
                    holder = uploadWrapper.find( '.images-holder' ),
                    input = uploadWrapper.find( '.media-result' ),
                    id_string = [];

                // not images type
                if ( !holder.length ) {
                    return;
                }

                // otherwise, we rearrange everythings
                holder.find( '.image-unit' ).each(function() {

                    var unit = $( this ),
                        id = unit.data( 'id' );

                    id_string.push( id );

                } );

                input.val( id_string.join() );
            
            }
        
        // call sortable
        sortableCall();
        
        // refine the input the get result
        $( '.withemes-upload-wrapper' ).on( 'changed', refine );
    
        // Append Image Action
        WITHEMES_ADMIN.cache.$document.on( 'click', '.upload-images-button', function( e ) {
            
            e.preventDefault();
            
            var button = $( this ),
                uploadWrapper = button.closest( '.withemes-upload-wrapper' ),
                holder = uploadWrapper.find( '.images-holder' ),
                input = uploadWrapper.find( '.media-result' );
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: WITHEMES_ADMIN.l10n.choose_images,
                button: {
                    text: WITHEMES_ADMIN.l10n.choose_images,
                }, 
                multiple: true,
                library : {
                    type : 'image',
                    // HERE IS THE MAGIC. Set your own post ID var
                    // uploadedTo : wp.media.view.settings.post.id
                },
            });

            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on( 'select' , function() {
                
                var attachments = mediaUploader.state().get('selection').toJSON();
                
                var remaining_attachments = [],
                    existing_ids = [];
                if ( input.val() ) {
                    existing_ids = input.val().split(',');
                }

                // remove duplicated images
                for ( var i in attachments ) {
                    var attachment = attachments[i],
                        item = '';
                    if ( existing_ids.indexOf( attachment.id.toString() ) < 0 ) {
                        
                        item += '<figure class="image-unit" data-id="' + attachment.id + '">';
                        item += '<img src="' + attachment.sizes.thumbnail.url +'" />';
                        item += '<a href="#" class="remove-image-unit" title="' + WITHEMES_ADMIN.l10n.remove_image + '">&times;</a>';
                        item += '</figure>';
                        holder.append( item );
                        
                    }
                }
                
                uploadWrapper.trigger( 'changed' );

            });
            
            // Open the uploader dialog
            mediaUploader.open();
        
        });
        
        // Remove Image Action
        WITHEMES_ADMIN.cache.$document.on( 'click', '.remove-image-unit', function( e ) {
            
            e.preventDefault();
            
            var remove = $( this ),
                uploadWrapper = remove.closest( '.withemes-upload-wrapper' ),
                item = remove.closest( '.image-unit' );

            item.remove();
            uploadWrapper.trigger( 'changed' );
            
        });
    
    }
    
    /**
     * Metabox Tabs
     *
     * @since 2.0
     */
    WITHEMES_ADMIN.tab = function() {
        
        $( '.metabox-tabs' ).each(function() {
        
            var $this = $( this ),
                fields = $this.next( '.metabox-fields' );
            $this.find( 'a' ).click(function( e ) {
            
                var a = $( this),
                    href= a.data( 'href' );
                
                e.preventDefault();
                
                // active class
                $this.find( 'li' ).removeClass( 'active' );
                a.parent().addClass( 'active' );
                
                // Hide all
                fields.find( '.tab-content' ).hide();
                
                // Shows fields with attr href or no tab
                fields.find( '.tab-content[data-tab="' + href + '"]' ).show();
                fields.find( '.tab-content[data-tab=""]' ).show();
            
            });
            
            // Click to the first item
            $this.find( 'li:first-child' ).find( 'a' ).trigger( 'click' );
        
        });
        
    }
    
    WITHEMES_ADMIN.init();
    
})( window, WITHEMES_ADMIN, jQuery );