<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Format comments */
require_once( 'library/class-foundationpress-comments.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/class-foundationpress-top-bar-walker.php' );
require_once( 'library/class-foundationpress-mobile-walker.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Nav Options to Customer */
require_once( 'library/custom-nav.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/class-foundationpress-protocol-relative-theme-assets.php' );



/********************* START OF THE MENU SNIPPET **********************/
/* To add a metabox in admin menu page */
add_action('admin_head-nav-menus.php', 'd2l_add_custommenu_metabox');

function d2l_add_custommenu_metabox() {
    add_meta_box('add-d2l_custommenu', __('Register, Log In/Out Links'), 'd2l_custommenu_metabox', 'nav-menus', 'side', 'default');
}
    /* The metabox code. */
function d2l_custommenu_metabox($object) {
        global $nav_menu_selected_id;
        $menukeywords = array(
            '#custom-link#' => __('Custum Link'),
        );
        class d2lCustomMenuItems {
            public $db_id = 0;
            public $object = 'd2l_custommenu';
            public $object_id;
            public $menu_item_parent = 0;
            public $type = 'custom';
            public $title;
            public $url;
            public $target = '';
            public $attr_title = '';
            public $classes = array();
            public $xfn = '';
        }
        $menukeywords_obj = array();
        foreach($menukeywords as $value => $title) {
$menukeywords_obj[ $title ] 				= new d2lCustomMenuItems();
$menukeywords_obj[ $title ]->object_id		= esc_attr( $value );
$menukeywords_obj[ $title ]->title			= esc_attr( $title );
$menukeywords_obj[ $title ]->url			= esc_attr( $value );
        }
        $walker = new Walker_Nav_Menu_Checklist(array()); 
        ?>
<div id="d2l-custommenu" class="loginlinksdiv">
<div id="tabs-panel-d2l-custommenu-all" class="tabs-panel tabs-panel-view-all tabs-panel-active">
<ul id="d2l-custommenuchecklist" class="list:d2l-custommenu categorychecklist form-no-clear">
<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $menukeywords_obj ), 0, (object) array( 'walker' => $walker ) ); ?>
</ul>
</div>
<p class="button-controls">
<span class="list-controls">
<a href="<?php echo admin_url('/nav-menus.php?d2l_custommenu-tab=all&amp;selectall=1#d2l-custommenu');?>" class="select-all aria-button-if-js" role="button">Select All</a>
</span>
<span class="add-to-menu">
<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-d2l-custommenu-menu-item" id="submit-d2l-custommenu" />
<span class="spinner"></span>
</span>
</p>
</div>
<?php
}
    /* Replace the #keyword# by links */
// add_filter('wp_setup_nav_menu_item', 'd2l_setup_nav_menu_item');

// function d2l_setup_nav_menu_item($menu_item) {
//     global $currentpage;
//     $menukeywords = array('#d2l_login#', '#d2l_logout#', '#d2l_loginout#', '#d2l_register#', '#d2l_profile#');
//     if (isset($menu_item - > object, $menu_item - > url) && $currentpage != 'nav-menus.php' && !is_admin() && 'custom' == $menu_item - > object && in_array($menu_item - > url, $menukeywords)) {
//         $item_url = substr($menu_item - > url, 0, strpos($menu_item - > url, '#', 1)).
//         '#';
//         $item_redirect = str_replace($item_url, '', $menu_item - > url);
//         if ($item_redirect == '%actualpage%') {
//             $item_redirect = $_SERVER['REQUEST_URI'];
//         }
//         switch ($item_url) {
//             case '#d2l_login#':
//                 $menu_item - > url = wp_login_url($item_redirect);
//                 break;
//             case '#d2l_logout#':
//                 $menu_item - > url = wp_logout_url($item_redirect);
//                 break;
//             case '#d2l_profile#':
//                 if (is_user_logged_in()) {
//                     $current_user = wp_get_current_user();
//                     $menu_item - > title = 'Hi, '.$current_user - > display_name;
//                     $menu_item - > url = get_edit_user_link($current_user - > ID);
//                 } else {
//                     $menu_item - > title = '#d2l_profile#';
//                 }
//                 break;
//             case '#d2l_register#':
//                 if (is_user_logged_in()) {
//                     $menu_item - > title = '#d2l_register#';
//                 } else {
//                     $menu_item - > url = wp_registration_url();
//                 }
//                 break;
//             case '#d2l_loginout#':
//                 if (is_user_logged_in()) {
//                     $menu_item - > title = 'Log Out';
//                     $menu_item - > url = wp_logout_url();
//                 } else {
//                     $menu_item - > title = 'Log In';
//                     $menu_item - > url = wp_login_url();
//                 }
//                 break;
//         }
//         $menu_item - > url = esc_url($menu_item - > url);
//     }
//     return $menu_item;
// }
// add_filter('wp_nav_menu_objects', 'd2l_nav_menu_objects');

// function d2l_nav_menu_objects($sorted_menu_items) {
//     foreach($sorted_menu_items as $k => $item) {
//         if ($item - > title == $item - > url && '#d2l_register#' == $item - > title) {
//             unset($sorted_menu_items[$k]);
//         }
//         if ($item - > title == $item - > url && '#d2l_profile#' == $item - > title) {
//             unset($sorted_menu_items[$k]);
//         }
//     }
//     return $sorted_menu_items;
// }
/********************* END OF THE MENU SNIPPET **********************/