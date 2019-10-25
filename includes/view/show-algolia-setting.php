<?php
$wp_algolia_application_id = get_option('wp_algolia_application_id', '');
$wp_algolia_search_api_key = get_option('wp_algolia_search_api_key', '');
$wp_algolia_api_key = get_option('wp_algolia_api_key', '');
$wp_algolia_index_name_prefix = get_option('wp_algolia_index_name_prefix', 'wp_');
?>
<div class="wrap">
  <h1>WP Algolia Searcher</h1>

  <form method="post" action="">
    <input type="hidden" name="action" value="wp_algolia_settings" />
    <p>Configure your Algolia account credentials. You can find them in the "API Keys" section of your Algolia dashboard.</p>
    <p>Once you provide your Algolia Application ID and API key, this plugin will be able to securely communicate with Algolia servers.</p>
    <p>No Algolia account yet? <a href="https://www.algolia.com/users/sign_up">Follow this link</a> to create one for free in a couple of minutes!</p>

    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th scope="row">Application ID</th>
          <td>
            <input type="text" name="wp_algolia_application_id" class="regular-text" value="<?php echo $wp_algolia_application_id; ?>">
  		      <p class="description" id="home-description">Your Algolia Application ID.</p>
          </td>
        </tr>
        <tr>
          <th scope="row">Search-only API key</th>
          <td>
            <input type="text" name="wp_algolia_search_api_key" class="regular-text" value="<?php echo $wp_algolia_search_api_key; ?>">
          	<p class="description" id="home-description">Your Algolia Search-only API key (public).</p>
          </td>
        </tr>
        <tr>
          <th scope="row">Admin API key</th>
          <td>
            <input type="password" name="wp_algolia_api_key" class="regular-text" value="<?php echo $wp_algolia_api_key; ?>">
        		<p class="description" id="home-description">Your Algolia ADMIN API key (kept private).</p>
          </td>
        </tr>
        <tr>
          <th scope="row">Index name</th>
          <td>
            <input type="text" name="wp_algolia_index_name_prefix" value="<?php echo $wp_algolia_index_name_prefix; ?>">
        		<p class="description" id="home-description">This will be used as the name of your index.</p>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="submit">
      <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </p>
  </form>
</div>
