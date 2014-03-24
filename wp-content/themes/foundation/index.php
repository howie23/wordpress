<?php
/*
The Main Index Page for the Ignite Theme
*/
get_header();
?>
            

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="post">
                <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <hr />
                <?php the_content(); ?>
            </div><?php //post ?>
            <?php wp_link_pages(); ?>
        <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
        <?php posts_nav_link(); ?>
        </div><?php //content ?>
        <?php get_sidebar(); ?>
        </div><?php //contentContainer ?>
<?php get_footer(); ?>
