<?php
get_header();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
    <div class="container">
        <div id="content">
            <h2><?php echo $term->name; ?></h2>
            <hr>
            <p><?php echo $term->description; ?></p>
            <?php
                //Get category ID
                $term_id = $term->term_id;
                //Get custom taxonomy name
                $taxonomy = $term->taxonomy;
                //Get children of the custom taxonomy ID
                $term_children = get_term_children($term_id,$taxonomy);
                //Build list of past seasons based on category ID and custom taxonomy   
                foreach ($term_children as $child) {
                    $termInfo = get_term_by('id', $child, $taxonomy);
                    echo '<h3><a href="' . get_term_link($child,$taxonomy) . '">' . $termInfo->name . '</a></h3>';
                    if (!empty($termInfo->description)) {
                        echo '<p>' . $termInfo->description . '</p>';
                    }
                }
            ?>
        </div><?php //content ?>
        <?php get_sidebar(); ?>
    </div><?php //contentContainer ?>
<?php get_footer(); ?>