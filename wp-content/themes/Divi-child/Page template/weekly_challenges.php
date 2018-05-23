
<?php
/*
 *  Template Name: challenges
 */
?>
<?php
get_header();
$current_user = wp_get_current_user();
if ((!is_user_logged_in()) || !($current_user->membership_levels)):
    echo '<script>window.location.href="' . site_url() . '"</script>';
endif;

//$user = wp_get_current_user();
//if($user->roles[0] == ' pro_member');
global $wpdb, $post, $pmpro_pages, $current_user;
$post->ID = $pmpro_pages['profile'];
?>
<div id="weekelu_c_sec" class="weekelu_c_sec min_height container">
    <div class="weekly_class">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args_1 = array(
            'post_type' => 'weekelychallenges',
            'paged' => $paged,
            'posts_per_page' => 20,
            'order' => 'DESC',
        );

        $guide = new WP_Query($args_1);

        if ($guide->have_posts()) :

            while ($guide->have_posts()) : $guide->the_post();
                ?>
                <div class="video_sec">
                    <div class="video_seq">
                        <?php
                        $videourl = get_field('video_url');

                        $uplodedvideo = get_field('upload_video');

                        if ($uplodedvideo || $videourl) {

                            if (($uplodedvideo) && ($videourl)) {

                                $video_url = $uplodedvideo;
                            } elseif ($uplodedvideo) {

                                $video_url = $uplodedvideo;
                            } elseif (($videourl)) {

                                $video_url = $videourl;
                            }



                            if (get_field('upload')):
                                echo ' <video controls><source src="' . $video_url . '" type="video/mp4"></video>';
                            else :
                                echo ' <iframe width="360" height="280" src="' . $video_url . '">
                    </iframe>';
                            endif;
                        }
                        else {
                            echo '<img src="' . get_template_directory_uri() . '/images/noimage.jpg" class="img-responsive" />';
                        }
                        ?>




                        <h4><?php the_title(); ?></h4>

                        <?php the_content(); ?>

                    </div>
                </div>

                <?php
            endwhile;

        else:

            echo '<p> no post found to match your criteria </p>';

        endif;

        wp_reset_query();
        ?>


        <?php
        echo '<div class="col-sm-12">

  <div class="pagination">';

        if (function_exists("custom_paginations")) {

            echo custom_paginations($guide->max_num_pages, $paged);
        }

        echo '</div>

     </div>';
        ?>
    </div>
</div>

<?php get_footer(); ?>
