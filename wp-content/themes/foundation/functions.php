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
add_action('init','create_shows_taxonomies', 0);

function create_shows_taxonomies() {
    //Add Seasons taxonomy for current/past seasons
    $labels = array(
        'name'              => _x( 'Seasons', 'taxonomy general name' ),
        'singular_name'     => _x( 'Season', 'taxonomy singular name' ),
        'seach_items'       => __( 'Seach Seasons' ),
        'all_items'         => __( 'All Seasons' ),
        'edit_item'         => __( 'Edit Seasons' ),
        'update_item'       => __( 'Update Seasons' ),
        'add_new_item'      => __( 'Add New Season' ),
        'new_item_name'     => __( 'New Season' ),
        'menu_name'         => __( 'Seasons' ),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'rewrite'           => true,
    );
    
    register_taxonomy( 'season','shows', $args);
}

//Add link to Excerpt
function excerpt_read_more_link($output) {
    global $post;
    return $output . '<a href="'. get_permalink($post->ID) . '"> Read More...</a>';
}
add_filter('the_excerpt', 'excerpt_read_more_link');

//Get Show icon
function getShowTypeIcon ($icon) {
    $showTypes = array (
        'book-light' => array (
            'icon-name'         => 'fi-book',
            'show-type-title'   => 'Indicates a Booklight production. Booklight productions are readers theatre productions with minimal staging.'
        ),
        'foot-light' => array (
            'icon-name'         => 'fi-social-skillshare',
            'show-type-title'   => 'Indicates a Footlight production. Footlight productions are fully staged productions.'
        )
    );
    $setShowType = get_field('show_type');
    $showTypeIcon = $showTypes[$setShowType]['icon-name'];
    $showTypeTitle = $showTypes[$setShowType]['show-type-title'];
    if ($icon == 'icon') {
        $showType = '<i class="' . $showTypeIcon . '" title="' . $showTypeTitle . '"></i>';
    } elseif ($icon == 'full') {
        $showType = '<p class="show-type"><i class="' . $showTypeIcon . '" title="' . $showTypeTitle . '"></i> - ' . $showTypeTitle . '</p>';
    }
    return $showType;
}

//Verify ACF is functioning
function pluginStatusCheck() {
    $result = '';
    if (function_exists('get_field')) {
        $result = TRUE;
    } else {
        $result = FALSE;
    }
    return $result;
}
//Verify information is present
function checkInformation($object) {
    $results = '';
    if (pluginStatusCheck()) {
        if(!empty(get_field($object))) {
            $results = TRUE;
        } else {
            $results = FALSE;
        }
    } else {
        $results = "It appears that Advanced Custom Fields is not functioning. Is it installed and activated?";
    }
    return $results;
}

function displayShowPeople($peopleType) {
//Check if ACF is active
    $pluginStatusCheck = function_exists('get_field') ? TRUE : FALSE;
    if (!$pluginStatusCheck) {
        $error = "It appears that Advanced Custom Fields is not functional. Is it installed?";
        return $error;
    } else {
        $peopleField = get_field($peopleType);
        $html = '';
        $i=1;
        $length = count($peopleField);
        foreach($peopleField as $person) {
            if (!empty($person['headshot'])) {
                $html .='<div class="large-12">';
                $html .='<a href="' . $person['headshot']['url'] . '"><img src="' . $person['headshot']['sizes']['medium'] . '" alt="' . $person['headshot']['alt'] . '"></a>';
                $html .='</div>';
            }
            $html .='<div class="large-12">';
            $html .='<h3>' . $person['role'] . '</h3>';
            $html .='<h4>' . $person['name'] . '</h4>';
            $html .='</div>';
        }
        return $html;
    }
}

function getAuditionInformation() {
    $n = array();
    //$director = get_field('the_director');
    if (checkInformation('the_director')) {
        while(has_sub_field('the_director')) {
            $n["director"][] = get_sub_field('name');
        }
    }
    if (checkInformation('audition_locale')) {
        $n["location"] = get_field('audition_locale');
    }
    if (checkInformation('audition_dates')) {
        while(has_sub_field('audition_dates')) {
            $n["date"][] = date("l F d, Y", strtotime(get_sub_field('audition_date')));
            $n["time"][] =get_sub_field('audition_time');
        }
    }
    return $n;
}