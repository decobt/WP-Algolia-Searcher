<?php

class Algolia_Command {
    public function reindex_post( $args ) {
      global $algolia;
      $index = $algolia->initIndex('WP_TEST');

      $index->clearObjects()->wait();

      $paged = 1;
      $count = 0;
      do {
          $posts = new WP_Query([
              'posts_per_page' => 100,
              'paged' => $paged,
              'post_type' => 'post'
          ]);

          if (! $posts->have_posts()) {
              break;
          }

          $records = [];
          foreach ($posts->posts as $post) {
              $record = (array) apply_filters('post_to_record', $post);

              if (! isset($record['objectID'])) {
                  $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
              }

              $records[] = $record;
              $count++;
          }

          $index->saveObjects($records);

          $paged++;

      } while (true);

  }
}

function algolia_post_to_record(WP_Post $post) {
    $tags = array_map(function (WP_Term $term) {
        return $term->name;
    }, wp_get_post_terms( $post->ID, 'post_tag' ));

    return [
        'objectID' => implode('#', [$post->post_type, $post->ID]),
        'title' => $post->post_title,
        'author' => [
            'id' => $post->post_author,
            'name' => get_user_by( 'ID', $post->post_author )->display_name,
        ],
        'excerpt' => $post->post_excerpt,
        'content' => strip_tags($post->post_content),
        'tags' => $tags,
        'url' => get_post_permalink($post->ID),
        'custom_field' => get_post_meta($post->id, 'custom_field_name'),
    ];
}
add_filter('post_to_record', 'algolia_post_to_record');
