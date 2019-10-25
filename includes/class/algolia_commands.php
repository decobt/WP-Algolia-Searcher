<?php
class AlgoliaCommands{
  private $index;
  function __construct() {

    $wp_algolia_application_id = get_option('wp_algolia_application_id', '');
    $wp_algolia_api_key = get_option('wp_algolia_api_key', '');
    $wp_algolia_index_name_prefix = get_option('wp_algolia_index_name_prefix', 'wp_');

    $algolia = \Algolia\AlgoliaSearch\SearchClient::create($wp_algolia_application_id, $wp_algolia_api_key);
    $this->index = $algolia->initIndex($wp_algolia_index_name_prefix);

    add_action('save_post', array($this, 'algolia_process_post'), 10, 3);
    add_action('update_post_meta', array($this, 'algolia_update_post_meta'), 10, 4);
  }

  /**
   * Register the main settings page
   */
  function algolia_process_post($id, WP_Post $post, $update) {
    if (wp_is_post_revision( $id) || wp_is_post_autosave( $id )) {
        return $post;
    }

    $record = (array) apply_filters($post->post_type.'_to_record', $post);

    if (! isset($record['objectID'])) {
      $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
    }

    if ('trash' == $post->post_status) {
        $this->index->deleteObject($record['objectID']);
    } else {
        $this->index->saveObject($record);
    }

    return $post;
  }

  function algolia_update_post_meta($meta_id, $object_id, $meta_key, $_meta_value) {
    global $algolia;
    $indexedMetaKeys = ['seo_description', 'seo_title'];

    if (in_array($meta_key, $indexedMetaKeys)) {
        $index = $algolia->initIndex(
            apply_filters('algolia_index_name', 'post')
        );

        $index->partialUpdateObject([
            'objectID' => 'post#'.$object_id,
	        $meta_key => $_meta_value,
        ]);
    }
  }


}
