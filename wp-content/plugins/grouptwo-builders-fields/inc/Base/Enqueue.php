<?php
/**
 * @package g2builderdfields
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class Enqueue extends BaseController {

	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	function enqueue() {
		// enqueue all our scripts
		wp_enqueue_style( 'pluginstyle', $this->plugin_url . 'assets/pluginstyle.css' );
		wp_enqueue_script( 'pluginscript', $this->plugin_url . 'assets/pluginscript.js' );
	}
}

