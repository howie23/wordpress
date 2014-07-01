<?php
    get_header();
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    query_posts(array( 'post_type'=>'shows', 'season'=>$term->slug));
?>
    <div class="container">
        <div id="content">
        <h2><?php echo $term->name; ?></h2>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="post">
                <h2><?php echo getShowTypeIcon('icon'); ?>&nbsp;<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <hr />
                <?php the_excerpt(); ?>
            </div><?php //post ?>
            <?php wp_link_pages(); ?>
        <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
        <?php posts_nav_link(); ?>
        <p class="show-type"><i class="fi-social-skillshare" title="Indicates a Footlight production. Footlight productions are fully staged productions."></i> - Indicates a Footlight production. Footlight productions are fully staged productions.</p>
        <p class="show-type"><i class="fi-book" title="Indicates a Booklight production. Booklight productions are readers theatre productions with minimal staging."></i> - Indicates a Booklight production. Booklight productions are readers theatre productions with minimal staging.</p>
        </div><?php //content ?>
        <?php get_sidebar(); ?>
    </div><?php //container ?>
<?php get_footer(); ?>