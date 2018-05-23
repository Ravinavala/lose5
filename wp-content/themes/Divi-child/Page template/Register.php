<?php
/* Template Name: weight tracking */

get_header();

$current_user = wp_get_current_user();
if ((!is_user_logged_in()) || !($current_user->membership_levels)):
    echo '<script>window.location.href="' . site_url() . '"</script>';
endif;

if (have_posts()) :
    while (have_posts()) : the_post();
        ?>
        <p><?php the_content(); ?></p>

        <?php
    endwhile;
endif;
get_footer();
?>