<?php
/*
Template page for Shows custom post-type in the Ignite Theme
*/
get_header();
?>
    <div class="container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="post">
            <h2><?php echo getShowTypeIcon('icon'); ?><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <?php echo getShowTypeIcon(); ?>
            <hr />
            <?php the_content(); ?>
            <?php
                //Displaying Cast and Crew Information
                $director_information = TRUE;
                $directors = get_field('show_director');
                if (empty($directors[0]['director_name'])) {
                    $director_information = FALSE;
                }
                $cast_information = TRUE;
                $cast = get_field('cast_members');
                //Check to see if at least one cast name has been set. If not, don't display cast information
                if (empty($cast[0]['actor_name'])) {
                    $cast_information = FALSE;
                }
                $crew_information = TRUE;
                $crew = get_field('the_crew');
                //Check to see if at least one crew name has been set. If not, don't display crew information
                if (empty($crew[0]['crew_name'])) {
                    $crew_information = FALSE;
                }
                if ($director_information) {
                    if ($cast_information == FALSE) {
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
                    } else {
                        $i=1;
                        $length = count($directors);
                        foreach  ($directors as $director) {
                            $counter = ($i % 2); //Modulo to determine if count of row is even or odd.
                            if ($counter !== 0) {
                                echo '<div class="row cast-list">';
                            }
                            if (!empty($director['director_headshot'])) {
                                echo '<div class="large-2 columns">';
                                echo '<a href="' . $director['director_headshot']['url'] . '"><img src="' . $director['director_headshot']['sizes']['thumbnail'] . '" alt="' . $director['director_headshot']['alt'] . '"></a>';
                                echo '</div>';
                                echo '<div class="large-4 columns';
                                if ($i == $length && $counter !==0) {
                                    echo ' end';
                                }
                                echo '">';
                            } else {
                                echo '<div class="large-6 columns';
                                if ($i == $length && $counter !==0) {
                                    echo ' end';
                                }
                                echo '">';
                            }
                            echo '<h3>' . $director['director_name'] . '</h3>';
                            echo '<h4>' . $director['director_role'] . '</h4>';
                            echo '</div>';
                            if ($counter == 0) {
                                echo '</div>'; //End Row
                            }
                            if ($counter !==0 && $i == $length) {
                                echo '</div>'; //End Directors Section
                            }
                            $i++;
                        }
                    }
                }
                //Get show dates
                $performanceInfo = get_field('performance_info');
                if (!empty($performanceInfo[0]['performance_date']) && have_rows('performance_info')): ?>
                <div class="row">
                    <div class="large-8 large-centered columns">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        Performance Dates
                                    </th>
                                    <th>
                                        Performance times
                                    </th>
                                    <th>
                                        Buy Tickets
                                    </th>
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
                                            <p class="text-center"><?php the_sub_field('performance_time'); ?></p>
                                        </td>
                                        <td>
                                            <a href="<?php the_field('ticket_link'); ?>" class="button round" target="_blank">Buy Tickets Now</a>
                                        </td>
                                    </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif;
                //List cast of charcters
                if($cast_information) {
                    echo '<h2>Cast</h2>';
                    $i=1;
                    $length = count($cast);
                    foreach ($cast as $row) {
                        $counter = ($i % 2); //Modulo to determine if count of row is even or odd.
                        if ($counter !== 0) {
                            echo '<div class="row cast-list">';
                        }
                        if (!empty($row['actor_headshot'])) { //Check to see if a headshot has been uploaded, if so, make room for the headshot or else just display character and actor names
                            echo '<div class="large-2 columns">';
                            echo '<a href="' . $row['actor_headshot']['url'] . '"><img src="' . $row['actor_headshot']['sizes']['thumbnail'] . '" alt="' . $row['actor_headshot']['alt'] . '"></a>';
                            echo '</div>';
                            echo '<div class="large-4 columns';
                            if ($i == $length && $counter !==0) {
                                echo ' end';
                            }
                            echo '">';
                        } else {
                            echo '<div class="large-6 columns';
                            if ($i == $length && $counter !==0) {
                                echo ' end';
                            }
                            echo '">';
                        }
                        echo '<h3>' . $row['character_name'] . '</h3>';
                        echo '<h4>' . $row['actor_name'] . '</h4>';
                        echo '</div>';
                        if ($counter == 0) {
                            echo '</div>'; //End Row
                        }
                        if ($counter !==0 && $i == $length) {
                            echo '</div>'; //End Cast Section
                        }
                        $i++;
                    }
                }
                //List of crew
                if($crew_information && $cast_information) {
                    echo '<h2>The Crew</h2>';
                    $i=1;
                    $length = count($crew);
                    foreach($crew as $crew_row) {
                        $counter = ($i % 2);
                        if ($counter !== 0) {
                            echo '<div class="row cast-list">';
                        }
                        if (!empty($crew_row['crew_headshot'])) {
                            echo '<div class="large-2 columns">';
                            echo '<a href="' . $crew_row['crew_headshot']['url'] . '"><img src="' . $crew_row['crew_headshot']['sizes']['thumbnail'] . '" alt="' . $crew_row['crew_headshot']['alt'] . '"></a>';
                            echo '</div>';
                            echo '<div class="large-4 columns';
                            if ($i == $length && $counter !==0) {
                                echo ' end';
                            }
                            echo '">';
                        } else {
                            echo '<div class="large-6 columns';
                            if ($i == $length && $counter !==0) {
                                echo ' end';
                            }
                            echo '">';
                        }
                        echo '<h3>' . $crew_row['crew_role'] . '</h3>';
                        echo '<h4>' . $crew_row['crew_name'] . '</h4>';
                        echo '</div>';
                        if ($counter == 0) {
                            echo '</div>'; //End Row
                        }
                        if ($counter !==0 && $i == $length) {
                            echo '</div>'; //End Crew section
                        }
                        $i++;
                    }
                }
            ?>
        </div><?php //post ?>
        <?php wp_link_pages(); ?>
    <?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
    <?php posts_nav_link(); ?>
    </div><?php //contentContainer ?>
<?php get_footer(); ?>