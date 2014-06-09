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
                    $directors = get_field('show_director');
                    if ($directors) {
                        $i = 1;
                        while (has_sub_field('show_director')) {
                            $director = get_sub_field('director_name');
                            if ($i == 1) {
                                echo '<p>Directed by ' . $director;
                            } else {
                                echo ' and ' . $director;
                            }
                            $i++;
                        }
                        echo '</p>';
                    }
                ?>
                <?php
                    $all_audition_information = TRUE; //Show audition information on this page
                    $audition_dates = get_field(audition_dates); //Get Audition dates/times return an array
                    $audition_locale = get_field(audition_locale); //Get Audition location
                    $characters = get_field(cast_members); //Get list of characters and descriptions
                    //Check to see if at least one Audition date/time has been set set. If not, don't display audition information
                    if (empty($audition_dates[0]['audition_time']) || empty($audition_dates[0]['audition_date'])) {
                        $all_audition_information = FALSE;
                    }
                    //Check to see if there is an audition location set. If not, don't display audition information
                    if (empty($audition_locale)) {
                        $all_audition_information = FALSE;
                    }
                    //Check to see if at least one character name and description has been set. If not, don't display audition information
                    if (empty($characters[0]['character_name']) || empty($characters[0]['character_description'])) {
                        $all_audition_information = FALSE;
                    }
                    if ($all_audition_information)  { ?>
                        <h3>Audition Information</h3>
                        <p>
                            <strong>Location:</strong> <?php echo $audition_locale; ?><br>
                            <strong>Audition Dates:</strong><br>
                            <?php
                            foreach ($audition_dates as $dates) {
                                echo ' - ' . date("l F d, Y", strtotime($dates['audition_date'])) . ' at ' . $dates['audition_time'] . '<br>';
                            } ?>
                        </p>
                        <h3>Available Roles</h3>
                        <p>
                        <?php
                            foreach ($characters as $character_info) {
                                echo '<strong>' . $character_info['character_name'] . '</strong> - <em>' . $character_info['character_description'] . '</em><br>';
                            }
                        ?>
                        </p>
                    <?php } else { ?>
                        <p><em>Audition information for <?php echo get_the_title($post->post_ID); ?> have not been announced.</em></p>
                    <?php } ?>
            </div><?php //post ?>
            <?php wp_link_pages(); ?>
        <?php endwhile; else: ?>
            <p><?php _e('There are no upcoming auditions.'); ?></p>
        <?php endif; ?>
        </div><?php //content ?>
        <?php get_sidebar(); ?>
    </div><?php //contentContainer ?>
<?php get_footer(); ?>