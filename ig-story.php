<?php

/**
 * Plugin Name: Historias de CARMELO 
 * Plugin URI: https://carmelocoton.com
 * Description: El mejor plugin que existe
 * Version: 1.0
 * Author: Carmelo Cotón
 * Author URI: https://carmelocoton.com
 */


defined('ABSPATH') or die('No script kiddies please!');

//meter funciones
require __DIR__ . '/functions.php';


/**
 *
 *   PÁGINA DE CONFIGURACIÓN    *******
 *
 *
 **/


// Register the menu.
add_action("admin_menu", "carmelo_stories_function");
function carmelo_stories_function()
{
    add_submenu_page(
        "options-general.php",  // MENU PADRE
        "Carmelo Stories",         // Page title
        "Carmelo Stories",       // Menu title
        "manage_options",       // Minimum capability (manage_options is an easy way to target administrators)
        "stories",            // Menu slug
        "carmelo_stories_options"     // Callback that prints the markup
    );
}

// Print the markup for the page
function carmelo_stories_options()
{
    if (!current_user_can("manage_options")) {
        wp_die(__("You do not have sufficient permissions to access this page."));
    }

    if (isset($_GET['status']) && $_GET['status'] == 'success') {
?>
<div id="message" class="updated notice is-dismissible">
    <p><?php _e("Settings updated!", "instagram-api"); ?></p>
    <button type="button" class="notice-dismiss">
        <span class="screen-reader-text"><?php _e("Dismiss this notice.", "instagram-api"); ?></span>
    </button>
</div>
<?php
    }

    ?>
<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">

    <input type="hidden" name="action" value="update_instagram_settings" />

    <h1><?php _e("LAS HISTORIAS DE CARMELO", "instagram-api"); ?></h1>

    <h3><?php _e("API de FACEBOOK", "instagram-api"); ?></h3>
    <p>
        <label>
            <i class="fa fa-instagram"></i>
            <?php _e("Instagram User Id", "instagram-api"); ?>
        </label>
        <input class="" type="text" name="ig_user" value="<?php echo get_option('ig_user'); ?>" />
    </p>

    <p>
        <label>
            <i class="fa fa-facebook"></i>
            <?php _e("Access Token", "instagram-api"); ?>
        </label>
        <input class="" type="text" name="ig_token" value="<?php echo get_option('ig_token'); ?>" />
    </p>

    <h3><?php _e("APP de FACEBOOK", "instagram-api"); ?></h3>
    <p>
        <label>
            <i class="fa fa-facebook"></i>
            <?php _e("App ID", "instagram-api"); ?>
        </label>
        <input class="" type="text" name="fb_app_id" value="<?php echo get_option('fb_app_id'); ?>" />
    </p>

    <p>
        <label>
            <i class="fa fa-facebook"></i>
            <?php _e("App Secret", "instagram-api"); ?>
        </label>
        <input class="" type="text" name="fb_app_secret" value="<?php echo get_option('fb_app_secret'); ?>" />
    </p>

    <input class="button button-primary" type="submit" value="<?php _e("Guardar", "instagram-api"); ?>" />

</form>

<?php

}

//GUARDAR SETTINGS
add_action('admin_post_update_instagram_settings', 'instagram_handle_save');

function instagram_handle_save()
{

    // Get the options that were sent
    $user = (!empty($_POST["ig_user"])) ? $_POST["ig_user"] : NULL;
    $token = (!empty($_POST["ig_token"])) ? $_POST["ig_token"] : NULL;
    $appId = (!empty($_POST["fb_app_id"])) ? $_POST["fb_app_id"] : NULL;
    $appSecret = (!empty($_POST["fb_app_secret"])) ? $_POST["fb_app_secret"] : NULL;

    // Validation would go here

    // Update the values
    update_option("ig_user", $user, TRUE);
    update_option("ig_token", $token, TRUE);
    update_option("fb_app_id", $appId, TRUE);
    update_option("fb_app_secret", $appSecret, TRUE);

    // Redirect back to settings page
    // The ?page=stories corresponds to the "slug" 
    // set in the fourth parameter of add_submenu_page() above.

    $redirect_url = get_bloginfo("url") . "/wp-admin/options-general.php?page=stories&status=success";
    header("Location: " . $redirect_url);
    exit;
}




/**
 **   SHORTCODE  *****
 **/

function story_function($atts)
{

    $user = get_option("ig_user");
    $token = get_option("ig_token");

    getNewToken($token);

    $token = get_option("ig_token");

    // get the users stories
    $stories = getUserStories($user, $token);

    //sacar media de cada story
    foreach ($stories as &$story) { // loop over the each story element
        // add the story media info to the story
        $story['media_info'] = getMediaInfo($story, $token);
    };

    unset($story);

    //echo_log($user);

    return renderLayout($stories, $user, $token);
}

add_shortcode("carmelo_stories", "story_function");