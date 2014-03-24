    </div><?php //main body container ?>
    <footer>
        <div class="container">
            <div class="footerDiv">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar 2') ) : ?>
                <?php endif; ?>
            </div>
            <div class="footerDiv">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar 3') ) : ?>
                <?php endif; ?>
            </div>
            <div class="footerDiv">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar 4') ) : ?>
                <?php endif; ?>
            </div>
        </div>
    </footer>
    <p id="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    <script src="<?php echo get_template_directory_uri(); ?>/javascripts/vendor/jquery.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascripts/foundation/foundation.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascripts/foundation/foundation.orbit.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascripts/foundation/foundation.topbar.js"></script>
    <script>
        $(document).foundation();
    </script>
    <?php wp_footer(); ?>
</body>
</html>