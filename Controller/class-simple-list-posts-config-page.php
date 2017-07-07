<?php 

/**
* 
*/
class Simple_List_Posts {
	function __construct() {
		add_action('admin_menu', array( $this, 'simple_list_posts_menu' ), 10);
		add_action('admin_enqueue_scripts', array( $this, 'register_plugin_styles' ), 10);
	}

	public function simple_list_posts_menu() {
		add_options_page( 'Listagem de posts', 'Simple List Posts', 'manage_options', 'simple-list-posts', array( $this, 'my_plugin_options') );
	}

	public function register_plugin_styles() {
		$screen = get_current_screen();
		if($screen->base == "settings_page_simple-list-posts"){
			wp_register_style( 'bootstrap', plugins_url() . '/simple-list-posts/static/css/bootstrap.min.css');   
			wp_enqueue_style('bootstrap');
		}	
	}

	public function my_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'Sem permissões para acessar esta página.' ) );
		}
		$args = array('post_type' => 'post');

		$the_query = new WP_Query($args);
		require_once(dirname(__FILE__) . "/../View/simple-list-post-config-page.php");
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
		}
	}

	


}