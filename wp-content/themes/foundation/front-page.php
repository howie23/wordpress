<?php
/*
Template Name: Home Page
The Front Page for the Ignite Theme
*/
    $image1 = get_field('banner_image_1');
    $image2 = get_field('banner_image_2');
    $image3 = get_field('banner_image_3');
    $image4 = get_field('banner_image_4');
    $image5 = get_field('banner_image_5');

get_header();
?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php if (is_sticky()) { 
                if ($image1) { ?>
                <div class="slideshow-wrapper">
                    <div class="preloader"></div>
                    <ul data-orbit>
                        <li>
                            <img src="<?php echo $image1['url']; ?>" alt="<?php echo $image1['alt']; ?>">
                            <div class="orbit-caption"><?php echo $image1['caption']; ?></div>
                        </li>
                        <?php if(get_field('banner_image_2')) { ?>
                        <li>
                            <img src="<?php echo $image2['url']; ?>" alt="<?php echo $image2['alt']; ?>">
                            <div class="orbit-caption"><?php echo $image2['caption']; ?></div>
                        </li>
                        <?php } ?>
                        <?php if(get_field('banner_image_3')) { ?>
                        <li>
                            <img src="<?php echo $image3['url']; ?>" alt="<?php echo $image3['alt']; ?>">
                            <div class="orbit-caption"><?php echo $image3['caption']; ?></div>
                        </li>
                        <?php } ?>
                        <?php if(get_field('banner_image_4')) { ?>
                        <li>
                            <img src="<?php echo $image4['url']; ?>" alt="<?php echo $image4['alt']; ?>">
                            <div class="orbit-caption"><?php echo $image4['caption']; ?></div>
                        </li>
                        <?php } ?>
                        <?php if(get_field('banner_image_5')) { ?>
                        <li>
                            <img src="<?php echo $image5['url']; ?>" alt="<?php echo $image5['alt']; ?>">
                            <div class="orbit-caption"><?php echo $image5['caption']; ?></div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php }
            } else {?>
            <div class="post">
                <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <hr />
                <?php the_content(); ?>
            </div><?php //post ?>
            <?php wp_link_pages(); ?>
            <?php } ?>
        <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
        <?php posts_nav_link(); ?>
        </div><?php //content ?>
        <?php get_sidebar(); ?>
        </div><?php //contentContainer ?>
<?php get_footer(); ?>