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
                <h2><?php //echo getShowTypeIcon('icon'); ?>&nbsp;<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <?php //echo getShowTypeIcon('full'); ?>
                <hr />
                <?php the_excerpt(); ?>
                <br>
                <?php
                    //displayShowPeople('the_director');
                    //$directors = get_field('the_director');
                    //if ($directors) {
                    //    $i = 1;
                    //    while (has_sub_field('the_director')) {
                    //        $director = get_sub_field('name');
                    //        if ($i == 1) {
                    //            echo '<p>Directed by ' . $director;
                    //        } else {
                    //            echo ' and ' . $director;
                    //        }
                    //        $i++;
                    //    }
                    //    echo '</p>';
                    //}
                ?>
                <p><?php //var_dump(get_field('the_director')); ?></p>
                <?php $auditionInformation = getAuditionInformation(); ?>
                <p><?php var_dump(checkInformation('the_director')); ?></p>
                <p><?php var_dump($auditionInformation); ?></p>
                <p>Directed by 
                    <?php
                        $directorCount = count($auditionInformation['director']);
                        $i=1;
                        foreach($auditionInformation['director'] as $director) {
                            if ($directorCount == 1) {
                                echo $director;
                            }
                            if ($directorCount == 2) {
                                if ($i == 1) {
                                    echo $director;
                                    $i++;
                                } else {
                                    echo ' and ' . $director;
                                }
                            }
                            if ($directorCount > 2) {
                                if ($i == 1) {
                                    echo $director;
                                    $i++;
                                } elseif ($i >= 2) {
                                    echo ', ' . $director;
                                }
                            }
                        }
                    ?>
                </p>
                <?php
                    $all_audition_information = TRUE; //Show audition information on this page
                    if ($all_audition_information)  { ?>
                        <h3>Audition Information</h3>
                        <p>
                            <strong>Location:</strong> <?php echo $auditionInformation['location']; ?><br>
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