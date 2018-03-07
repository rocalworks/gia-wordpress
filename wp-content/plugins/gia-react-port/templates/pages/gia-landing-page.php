<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

    <body>
        <?php
            // TODO: Lock and loaded!

            // Start the Loop.
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
        ?>
        <?php wp_footer(); ?>
    </body>

</html>
