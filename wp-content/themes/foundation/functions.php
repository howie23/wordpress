<?php
//Remove WP version number from <head> and RSS feeds
function _remove_version() {
    return '';
}
add_filter('the_generator', '_remove_version');

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