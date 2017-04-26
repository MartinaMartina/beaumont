<?php

// @see Vc_Base::frontCss, used to append actions when frontCss(frontend editor/and real view mode) method called
// This action registers all styles(fonts) to be enqueue later
add_action( 'vc_base_register_front_css', 'withemes_iconpicker_base_register_css' );

// @see Vc_Base::registerAdminCss, used to append action when registerAdminCss(backend editor) method called
// This action registers all styles(fonts) to be enqueue later
add_action( 'vc_base_register_admin_css', 'withemes_iconpicker_base_register_css' );

// @see Vc_Backend_Editor::printScriptsMessages (wp-content/plugins/js_composer/include/classes/editors/class-vc-backend-editor.php),
// used to enqueue needed js/css files when backend editor is rendering
add_action( 'vc_backend_editor_enqueue_js_css', 'withemes_iconpicker_editor_jscss' );
// @see Vc_Frontend_Editor::enqueueAdmin (wp-content/plugins/js_composer/include/classes/editors/class-vc-frontend-editor.php),
// used to enqueue needed js/css files when frontend editor is rendering
add_action( 'vc_frontend_editor_enqueue_js_css', 'withemes_iconpicker_editor_jscss' );

if ( ! function_exists( 'withemes_iconpicker_base_register_css' ) ) :
/**
 * Register Theme Icon Fonts
 *
 * @since 1.3
 */
function withemes_iconpicker_base_register_css() {
    
    wp_register_style( 'withemes-budicon', get_template_directory_uri() . '/css/vendor/budicon/css/budicon.css' );

}
endif;

if ( ! function_exists( 'withemes_iconpicker_editor_jscss' ) ) :
/**
 * Enqueues Theme Icon Fonts
 *
 * @since 1.3
 */
function withemes_iconpicker_editor_jscss() {
    
    wp_enqueue_style( 'withemes-budicon' );

}
endif;