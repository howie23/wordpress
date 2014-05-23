<?php
    get_header();
    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    query_posts(array( 'post_type'=>'shows', 'season'=>$term->slug));
    $pageTitle = $term->name;
    $pageDescription = $term->description;
?>
    <div class="container">
        <div id="content">
            <h1><?php echo $pageTitle; ?></h1>
            <p><?php echo $pageDescription; ?></p>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="post">
                <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <hr />
                <?php the_excerpt(); ?>
                <?php
                    if (have_rows(audition_dates)) {
                        $audition_locale = (get_field(audition_locale)) ? get_field(audition_locale) : NULL;
                        $audition_dates = get_field(audition_dates);
                        echo '<p>';
                        echo 'Location: ' . $audition_locale . '<br>';
                        echo '<ul>';
                        echo 'Audition Dates:';
                        foreach ($audition_dates as $dates) {
                            echo '<li>' . date("l F d, Y", strtotime($dates['audition_date'])) . ' at ' . $dates['audition_time'] . '</li>';
                        }
                        echo '</ul>';
                        echo '</p>';
                    } else {
                        echo '<p><em>Audition dates for ' . get_the_title($post->post_ID) , ' have not been announced.</em></p>';
                    }
                ?>
            </div><?php //post ?>
            <?php wp_link_pages(); ?>
        <?php endwhile; else: ?>
            <p><?php _e('There are no upcoming auditions.'); ?></p>
        <?php endif; ?>
        </div><?php //content ?>
        <?php get_sidebar(); ?>
    </div><?php //contentContainer ?>
<?php get_footer(); ?>