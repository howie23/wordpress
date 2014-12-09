<?php
    /*
    Template page for Shows custom post-type in the Ignite Theme
    */
    get_header();
    $showInformation = getShowInformation('show');
    $today = strtotime('today');
?>
    <div class="container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="post">
            <h2><?php echo getShowTypeIcon('icon'); ?>&nbsp;<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <hr />
            <?php the_content(); ?>
            <div class="row">
                <div class="large-4 columns">
                    <?php
                        if (function_exists(have_rows) && have_rows('the_director')) {
                            while(have_rows('the_director')) : the_row();
                                $role = get_sub_field('role');
                                $name = get_sub_field('name');
                                $pic = get_sub_field('headshot');
                                if (!empty($pic)) {
                                    echo '<a href="' . $pic['url'] . '"><img src="' . $pic['sizes']['medium'] . '" alt="' . $pic['alt'] . '"></a>';
                                }
                                echo '<h4>';
                                echo $role;
                                echo '</h4>';
                                echo '<h3>';
                                echo $name;
                                echo '</h3>';
                                unset($role);
                                unset($name);
                                unset($pic);
                            endwhile;
                        }
                        if (function_exists(have_rows) && have_rows('the_cast')) {
                            while(have_rows('the_cast')) : the_row();
                                $role = get_sub_field('role');
                                $name = get_sub_field('name');
                                $pic = get_sub_field('headshot');
                                if (!empty($pic)) {
                                    echo '<a href="' . $pic['url'] . '"><img src="' . $pic['sizes']['medium'] . '" alt="' . $pic['alt'] . '"></a>';
                                }
                                echo '<h4>';
                                the_sub_field('role');
                                echo '</h4>';
                                echo '<h3>';
                                the_sub_field('name');
                                echo '</h3>';
                                unset($role);
                                unset($name);
                                unset($pic);
                            endwhile;
                        }
                        if (function_exists(have_rows) && have_rows('the_crew')) {
                            while(have_rows('the_crew')) : the_row();
                                $role = get_sub_field('role');
                                $name = get_sub_field('name');
                                $pic = get_sub_field('headshot');
                                if (!empty($pic)) {
                                    echo '<a href="' . $pic['url'] . '"><img src="' . $pic['sizes']['medium'] . '" alt="' . $pic['alt'] . '"></a>';
                                }
                                echo '<h4>';
                                the_sub_field('role');
                                echo '</h4>';
                                echo '<h3>';
                                the_sub_field('name');
                                echo '</h3>';
                                unset($role);
                                unset($name);
                                unset($pic);
                            endwhile;
                        }
                    ?>
                </div>
                <div class="large-8 columns">
                    <?php 
                        //$performanceArray = get_field('performance_info');
                        //$lastShow = end($performanceArray);
                        //if (strtotime($lastShow['performance_date']) > $today) {
                        $ticketLink = get_field('ticket_link'); ?>
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
                            while(have_rows('performance_info')) : the_row(); ?>
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
                    <?php //} ?>
                </div>
            </div>
            <?php echo getShowTypeIcon('full'); ?>
        </div><?php //post ?>
        <?php wp_link_pages(); ?>
    <?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
    <?php posts_nav_link(); ?>
    </div><?php //contentContainer ?>
<?php get_footer(); ?>