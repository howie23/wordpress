<?php
//Remove WP version number from <head> and RSS feeds
function _remove_version() {
    return '';
}
add_filter('the_generator', '_remove_version');

//Include ACF Repeater Plugin
include_once('acf-repeater/acf-repeater.php');

//Register Nav Menu
add_action( 'init', 'register_my_menus' );

function register_my_menus() {
	register_nav_menus(
        array (
            'primary-menu' => __( 'Primary Menu' ),
            'footer-menu' => __( 'Footer Menu' )
        )
    );
}

// Adjust for Foundation Navigation styles https://github.com/drewsymo/Foundation/blob/master/functions.php
// Add class to navigation sub-menu
class foundation_navigation extends Walker_Nav_Menu {

function start_lvl(&$output, $depth) {
	$indent = str_repeat("\t", $depth);
	$output .= "\n$indent<ul class=\"dropdown\">\n";
}

function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
	$id_field = $this->db_fields['id'];
	if ( !empty( $children_elements[ $element->$id_field ] ) ) {
		$element->classes[] = 'has-dropdown';
	}
		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}


// Adjust for Foundation Pagination styles https://github.com/drewsymo/Foundation/blob/master/functions.php

if ( ! function_exists( 'foundation_pagination' ) ) :

function foundation_pagination() {

global $wp_query;

$big = 999999999;

$links = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'prev_next' => true,
	'prev_text' => '&laquo;',
	'next_text' => '&raquo;',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
	'type' => 'list'
)
);

$pagination = str_replace('page-numbers','pagination',$links);

echo $pagination;

}

endif;

//Register Widgetized Sidebar
function foundation_widgets_init() {
    register_sidebars ( 4, 
        array (
            'name' => __( 'Sidebar %d' ),
            'id' => 'sidebar',
            'description' => __('Add widgets to be displayed throughout the site'),
            'class' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widgetTitle">',
            'after_title' => '</h4>'
        )
    );
}
add_action('widgets_init', 'foundation_widgets_init');

//Registering Shows custom post-type
function create_show_info() {
    $labels = array(
        'name' => __( 'Shows' ),
        'singular_name' => __( 'Show' ),
        'menu_name' => __( 'Manage Shows' ),
        'add_new' => __( 'Add New Show' ),
        'add_new_item' => __( 'Add New Show' ),
        'edit_item' => __( 'Edit Show' ),
        'view_item' => __( 'View Show' ),
        'search_items' => __( 'Search Shows' ),
        'not_found' => __( 'No shows found' ),
        'not_found_in_trash' => __( 'No shows found in trash' )
    );
    $args = array (
        'labels' => $labels,
        'description' => __( 'A custom post type for adding information about shows for upcoming seasons' ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => __( 'dashicons-star-filled' ),
        'supports' => array ('title', 'editor', 'thumbnail'),
    );
    register_post_type( 'shows', $args );
}
add_action('init', 'create_show_info');

//Register Taxonomy for Shows custom post-type
//Custom Taxonomy in this case is used to designate which season a show is a part of (will be used for archival purposes (hopefully))
register_taxonomy("Seasons", array("shows"), array("hierarchical" => true, "label" => "Seasons", "singular_label" => "Season", "rewrite" => true));

//Add custom data fields for Shows custom post-type
//Will be used for adding show specific information (cast lists, production staff, etc)
add_action ("admin_init", "admin_init");

function admin_init() {
    add_meta_box("director_meta", "Director", "show_director", "shows", "normal", "low");
}
function show_director() {
    global $post;
    $custom = get_post_custom($post->ID);
    $show_director = $custom["show_director"][0];
    ?>
    <label>Director:</label>
    <input name="show_director" value="<?php echo $show_director; ?>" />
    <?php
}
add_action('save_post', 'save_details');

function save_details () {
    global $post;
    update_post_meta($post->ID, "show_director", $_POST["show_director"]);
}