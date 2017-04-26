(function ( $ ) {
    
    window.VcTestimonialView = window.VcTabsView.extend( {
        
        addTab: function ( e ) {
			e.preventDefault();
			// check user role to add controls
			if ( ! vc_user_access().shortcodeAll( 'vc_tab' ) ) {
				return false;
			}
			this.new_tab_adding = true;
			var tab_title = 'Testimonial',
                tabs_count = this.$tabs.find( '[data-element_type=vc_tab]' ).length,
				tab_id = (Date.now() + '-' + tabs_count + '-' + Math.floor( Math.random() * 11 ));
			vc.shortcodes.create( {
				shortcode: 'testimonial',
				params: { title: tab_title, tab_id: tab_id },
				parent_id: this.model.id
			} );
			return false;
		},
        
    } );
    
})( window.jQuery );