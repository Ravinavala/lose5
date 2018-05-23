<?php
get_header();
?>
<div id="main-content">
    <div class="individual_product">
        <?php while (have_posts()) : the_post(); ?>
            <div class="image_sec">
                <?php the_post_thumbnail(); ?>
            </div>
            <p> <?php the_content(); ?> </p>
        
    <?php endwhile; ?>
    <div class="load-more-blog-section load_more_btn">
<button id="search_load_more_blog_btn" class="blue_btn">Load more</button>
    </div>
</div>
 
</div>
<?php get_footer(); ?>