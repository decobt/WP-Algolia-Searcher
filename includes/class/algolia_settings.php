<?php
class AlgoliaSearcherSettings{
  function __construct() {
    add_action( 'admin_menu', array($this, 'algolia_register_main_settings_page') );
    add_action( 'admin_menu', array($this, 'algolia_register_submenus') );

    add_action( 'init', array($this, 'algolia_process_settings_page'));
  }

  /**
   * Register the main settings page
   */
  function algolia_register_main_settings_page() {
    add_menu_page(
        __( 'WP Algolia Searcher', 'algoliasearcher' ),
        'Algolia Searcher',
        'manage_options',
        'wp_algolia_searcher',
        array($this, 'render_settings_page'),
        'dashicons-search'
    );
  }

  function algolia_register_submenus() {
    add_submenu_page( 'wp_algolia_searcher', 'Searchable attributes', 'Searchable attributes', 'manage_options', 'algolia_attributes', array($this, 'render_settings_page') );
    add_submenu_page( 'wp_algolia_searcher', 'Algolia indexable', 'Algolia indexable', 'manage_options', 'my-custom-submenu-page_2', array($this, 'render_settings_page') );
  }

	function render_settings_page() {
		require_once ALGOLIA_SEARCHER_DIR . '/includes/view/show-algolia-setting.php';
	}

  function algolia_process_settings_page() {
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'wp_algolia_settings') {
      $id = $_POST['wp_algolia_application_id'];
      $api_key = $_POST['wp_algolia_api_key'];
      $search_api_key = $_POST['wp_algolia_search_api_key'];
      $index = $_POST['wp_algolia_index_name_prefix'];

      if( $this->algolia_save_setting($id, 'wp_algolia_application_id', 'Application ID') &&
      $this->algolia_save_setting($search_api_key, 'wp_algolia_search_api_key', 'Search Api Key') &&
      $this->algolia_save_setting($api_key, 'wp_algolia_api_key', 'Api Key') &&
      $this->algolia_save_setting($index, 'wp_algolia_index_name_prefix', 'Index Name')){
        $this->algolia_settings_page_notices('success','Settings Saved');
      }
    }
  }

  function algolia_save_setting($data, $name, $title){
    if(isset($data) && $data != ''){
      update_option($name, $data);
      return true;
    }else{
      $this->algolia_settings_page_notices('error', $title . ' should not be empty.');
      return false;
    }
  }

  function algolia_settings_page_notices( $type, $message ) {
      ?>
      <div class="notice is-dismissible notice-<?php echo $type; ?>">
          <p><?php _e( $message, 'algoliasearcher' ); ?></p>
      </div>
      <?php
  }

}
?>
