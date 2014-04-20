<?php
/*
Template page for Shows custom post-type in the Ignite Theme
*/
get_header();
?>
    <div class="container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="post">
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <hr />
            <?php the_content(); ?>
            <?php
                $crew = get_field('the_crew');
                if($crew) {
                    echo '<h2>Creative Team</h2>';
                    $i=1;
                    $length = count($crew);
                    foreach($crew as $crew_row) {
                        $crew_counter = ($i % 3);
                        if ($crew_counter == 1) {
                            echo '<div class="row cast-list">';
                        }
                        echo '<div class="large-4 columns';
                        if ($i == $length && $crew_counter == 2) {
                            echo ' end';
                        }
                        echo '">';
                        echo '<h3>' . $crew_row['crew_role'] . '</h3>';
                        echo '<h4>' . $crew_row['crew_name'] . '</h4>';
                        echo '</div>';
                        if ($crew_counter == 0) {
                            echo '</div>';
                        } elseif ($crew_counter !== 0 && $i == $length) {
                            echo '</div>';
                        }
                        $i++;
                    }
                }
                $cast = get_field('cast_members');
                if($cast) {
                    echo '<h2>Cast</h2>';
                    $i=1;
                    $length = count($cast);
                    foreach ($cast as $row) {
                        $counter = ($i % 2); //Modulo to determine if count of row is even or odd.
                        if ($counter !== 0) {
                            echo '<div class="row cast-list">';
                        }
                        echo '<div class="large-2 columns">';
                        echo '<a href="' . $row['actor_headshot']['url'] . '"><img src="' . $row['actor_headshot']['sizes']['thumbnail'] . '" alt="' . $row['actor_headshot']['alt'] . '"></a>';
                        echo '</div>';
                        echo '<div class="large-4 columns';
                        if ($i == $length && $counter !==0) {
                            echo ' end';
                        }
                        echo '">';
                        echo '<h3>' . $row['character_name'] . '</h3>';
                        echo '<h4>' . $row['actor_name'] . '</h4>';
                        echo '</div>';
                        if ($counter == 0) {
                            echo '</div>'; //End Row
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