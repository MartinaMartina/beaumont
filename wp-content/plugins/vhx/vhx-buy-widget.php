<?php
/**
 * Plugin Name: VHX Purchase Widget
 * Plugin URI: http://dev.vhx.tv/docs/embeds/
 * Description: Adds the VHX Checkout Widget to your site and automatically powers links to activate purchasing on VHX.
 * Version: 1.2
 * Author: VHX
 * Author URI: http://vhx.tv
 * License: GPL2
 */


/*  Copyright 2015  VHX  (email : contact@vhx.tv)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* REGISTER ADMIN SETTINGS
*/
class VHXSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', array( $this, 'add_plugin_page' ) );

        // setup the actual settings page
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }


  /**
     * Add options page
     */
    public function add_plugin_page()
    {
         // add the menu to the left
        add_menu_page('VHX Settings', 'VHX  Widget', 'administrator', __FILE__, array($this, 'create_admin_page'));


    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        ?>
        <div class="wrap">
            <h2>VHX Purchase Widget Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'vhx_plugin_options' );
                do_settings_sections( 'vhx_widget_admin' ); // this is your 'page' name
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting( 'vhx_plugin_options', 'vhx_domain' );

        // adds a section to hold the setting, prints out intro text
        add_settings_section(
            'vhx_buy_widget_section',
            '', // Title (blank for us because it is redundant)
            array( $this, 'print_section_info' ), // Callback
            'vhx_widget_admin' // Page Name (from do_settings_section)
        );

        // adds the actual settings field for "vhx_domain_field"
        add_settings_field(
            'vhx_domain_field', // MUST match the 2nd param from register_setting above
            'Your VHX Domain',
            array( $this, 'create_subdomain_input' ),
            'vhx_widget_admin', // page name: from the do_settings section
            'vhx_buy_widget_section' // section name: from the 'section' from above
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_domain( $input )
    {
        $new_input = array();

        // TO DO: validate field to ___.vhx.tv
        if( isset( $input['vhx_domain'] ) )
            $new_input['vhx_domain'] = sanitize_text_field( $input['vhx_domain'] );
            // http://codex.wordpress.org/Function_Reference/sanitize_text_field

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {

        print 'Enter your VHX subdomain below.';
        if (isset($_GET['settings-updated'])) {
          echo '<div class="success" style="padding: 10px; margin-top: 20px; background-color: #f4f6d2; border: 1px solid #ebebeb;">Settings Updated</div>';
        }
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function create_subdomain_input()
    {
        // Set class property
        echo '<input type="text" id="vhx_domain" name="vhx_domain" value="'.get_option('vhx_domain').'" placeholder="http://yoursite.vhx.tv/" />';


    }


}





/**
* HOOK FOR PUBLIC FACING INTEGRATION
*/
class VHXPlugin {

    /**
    * Hold our options and our JS location
    */
     private $javascript_location = 'https://cdn.vhx.tv/assets/api.js';
     private $domain;


    /**
     * Start up
     */
    public function __construct()
    {
      // get our subdomain
      $this->domain = get_option( 'vhx_domain' );
      //add your actions to the constructor!
      add_action( 'wp_head', array( $this, 'output_vhx_javascript' ) );

    }
    public function output_vhx_javascript() {

        // TO DO: make this a regex
        $this->domain = str_replace("http://","",$this->domain);
        $this->domain = str_replace("https://","",$this->domain);
        $this->domain = str_replace("/","",$this->domain);

        print "\r\n\r\n<!-- VHX! You're a wonderful person! -->\r\n";
        print "<script src='" . $this->javascript_location . "'";
        if ($this->domain != ""){
          print " data-vhx-site='". $this->domain . "'";
        }
        print "></script>\r\n\r\n";
      }

}









if( is_admin() )
  $my_settings_page = new VHXSettingsPage();
else {
  $my_plugin = new VHXPlugin();
}

?>
