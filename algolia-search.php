<?php
/**
  * @wordpress-plugin
  * Plugin Name:       Algolia Custom Searcher
  * Plugin URI:        https://github.com/WebDevStudios/wp-search-with-algolia
  * Description:       Integrates Algolia with your wordpress installation, lots of configurations available to choose from.
  * Version:           1.0.0
  * Author:            Trayche Roshkoski
  * Author URI:        roskoskitrajce@gmail.com
  * License:           GNU General Public License v2.0 / MIT License
  * Text Domain:       algoliasearcher
  *
  * @package         Algolia_Custom_Searcher
*/

define('ALGOLIA_SEARCHER_URL', plugin_dir_url( __FILE__ ));
define('ALGOLIA_SEARCHER_DIR', plugin_dir_path( __FILE__ ));

require_once ALGOLIA_SEARCHER_DIR . '/vendor/autoload.php';
require_once ALGOLIA_SEARCHER_DIR . '/wp-cli.php';
global $algolia;

require_once ALGOLIA_SEARCHER_DIR .'includes/class/algolia_settings.php';
require_once ALGOLIA_SEARCHER_DIR .'includes/class/algolia_commands.php';

if (!class_exists('AlgoliaCustomSearcher')) {
	class AlgoliaCustomSearcher {
		function __construct() {
			$type = new AlgoliaSearcherSettings();
			$commands = new AlgoliaCommands();
      //$algolia = \Algolia\AlgoliaSearch\SearchClient::create("XAPF7HXGDL", "e212acaca62dfe58883ab0a85c736a28");

      //register_activation_hook( __FILE__, array( 'AlgoliaCustom', 'index_existing' ) );
		}
	}
}

$algolia_searcher = new AlgoliaCustomSearcher;

?>
