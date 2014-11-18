<?php
    /*
    Template page for Shows custom post-type in the Ignite Theme
    */
    get_header();
    $showInformation = getShowInformation('show');
?>
    <div class="container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="post">
            <h2><?php echo getShowTypeIcon('icon'); ?>&nbsp;<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <hr />
            <?php the_content();
                $directorArray = array_map(null, $showInformation['directorName'], $showInformation['directorRole'], $showInformation['directorHeadshot']);
                var_dump($directorArray);
                $directorInfo = isset($showInformation['directorName']) ? TRUE : FALSE;
                if ($directorInfo) { ?>
                    <div class="row">
                        <div class="large-4 columns">
                            <?php
                                foreach(array_combine($showInformation['directorName'], $showInformation['directorRole']) as $director => $role) {
                                echo '<h3>' . $director . '</h3>';
                                echo '<h4>' . $role . '</h4>';
                            } ?>
                        </div>
                    </div>
                    <?php
                }
            ?>
            <?php

                //Displaying Cast and Crew Information
                //$director_information = TRUE;
                //$directors = function_exists('get_field') ? get_field('the_director') : FALSE;
                //if (($directors == FALSE) || (empty($directors[0]['name']))) {
                //    $director_information = FALSE;
                //}
                //$cast_information = TRUE;
                //$cast = function_exists('get_field') ? get_field('the_cast') : FALSE;
                //Check to see if at least one cast name has been set. If not, don't display cast information
                //if (($cast == FALSE) || (empty($cast[0]['name']))) {
                //    $cast_information = FALSE;
                //}
                //$crew_information = TRUE;
                //$crew = function_exists('get_field') ? get_field('the_crew') : FALSE;
                //Check to see if at least one crew name has been set. If not, don't display crew information
                //if (($crew == FALSE) || (empty($crew[0]['name']))) {
                //    $crew_information = FALSE;
                //}
                //Get show dates
                $performanceInfo = function_exists('get_field') ? get_field('performance_info') : FALSE;
                if (!empty($performanceInfo[0]['performance_date']) && have_rows('performance_info')): ?>
                <div class="row">
                    <div class="large-4 columns">
                        <?php
                        if ($director_information) {
                            if ($cast_information == FALSE) {
                                $i = 1;
                                while (has_sub_field('the_director')) {
                                    $director = get_sub_field('name');
                                    if ($i == 1) {
                                        echo '<p>Directed by ' . $director;
                                    } else {
                                        echo ' and ' . $director;
                                    }
                                    $i++;
                                }
                                echo '</p>';
                            } else {
                                echo displayShowPeople('the_director');
                            }
                        }
                        //List cast of charcters
                        if($cast_information) {
                            echo '<h2>Cast</h2>';
                            echo displayShowPeople('the_cast');
                        }
                        //List of crew
                        if($crew_information && $cast_information) {
                            echo '<h2>The Crew</h2>';
                            echo displayShowPeople('the_crew');
                        }
                        $ticketLink = get_field('ticket_link'); ?>
                    </div>
                    <div class="small-12 large-8 columns">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        Performance Dates
                                    </th>
                                    <th>
                                        Performance times
                                    </th>
                                    <?php
                                        if (!empty($ticketLink)) {
                                    ?>
                                    <th>
                                        Buy Tickets
                                    </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while(have_rows('performance_info')): the_row(); ?>
                                    <tr>
                                        <td>
                                            <?php echo date("l F d, Y", strtotime(get_sub_field('performance_date'))); ?>
                                        </td>
                                        <td>
                                            <span class="text-center"><?php the_sub_field('performance_time'); ?></span>
                                        </td>
                                        <?php if (!empty($ticketLink)) { ?>
                                        <td>
                                            <a href="<?php echo $ticketLink; ?>" class="button round purchaseTicket" target="_blank">Buy Tickets</a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif;
            ?>
            <?php echo getShowTypeIcon('full'); ?>
        </div><?php //post ?>
        <?php wp_link_pages(); ?>
    <?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
    <?php posts_nav_link(); ?>
    </div><?php //contentContainer ?>
<?php get_footer(); ?>