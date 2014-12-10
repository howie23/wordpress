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
                <h2><?php echo getShowTypeIcon('icon'); ?>&nbsp;<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <hr />
                <?php
                    the_excerpt();
                    $auditionInformation = getShowInformation('audition');
                    $directorInfo = isset($auditionInformation['director']) ? $auditionInformation['director'] : FALSE;
                    if ($directorInfo) {
                        $directorCount = count($directorInfo);
                        foreach($directorInfo as $director) {
                            if ($directorCount === 1) {
                                echo '<p>Directed by ' . $director . '</p>';
                            }
                            if ($directorCount === 2) {
                                if ($director === reset($directorInfo)) {
                                    echo'<p> Directed by ' . $director;
                                } else {
                                    echo ' and ' . $director . '</p>';
                                }
                            }
                            if ($directorCount > 2) {
                                if ($director === reset($directorInfo)) {
                                    echo '<p>Directed by ' . $director;
                                } elseif ($director === end($directorInfo)) {
                                    echo ', and ' . $director . '</p>';
                                } else {
                                    echo ', ' . $director;
                                } 
                            }
                        }
                    }
                ?>
                <?php
                    if (!empty($auditionInformation['date'][0])) { ?>
                        <h3>Audition Information</h3>
                        <p>
                            <?php
                                $auditionLocation = isset($auditionInformation['location']) ? $auditionInformation['location'] : FALSE;
                                if (!$auditionLocation == FALSE) {
                                    echo '<strong>Location:</strong> ' . $auditionLocation . '<br>';
                                }
                            ?>
                            <strong>Audition Dates:</strong><br>
                            <?php
                                foreach (array_combine($auditionInformation['date'], $auditionInformation['time']) as $date => $time) {
                                    echo ' - ' . date("l F d, Y", strtotime($date));
                                    if (!empty($time)) {
                                        echo ' at ' . $time;
                                    }
                                    echo '<br>';
                                }
                            ?>
                        </p>
                    <?php
                        $auditionNote = get_field('audition_info');
                        if (!empty($auditionNote)) {
                            echo $auditionNote;
                        }
                    } else { ?>
                        <p><em>Audition information for <?php echo get_the_title($post->post_ID); ?> has not been announced. Information will be posted soon.</em></p>
                <?php
                    } ?>
                <?php echo getShowTypeIcon('full'); ?>
            </div><?php //post ?>
            <?php wp_link_pages(); ?>
        <?php endwhile; else: ?>
            <p><?php _e('There are no upcoming auditions.'); ?></p>
        <?php endif; ?>
        </div><?php //content ?>
        <?php get_sidebar(); ?>
    </div><?php //contentContainer ?>
<?php get_footer(); ?>