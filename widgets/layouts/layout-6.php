<?php ?>
    <div class="carousel">
<div class="slider multiple-items"> <?php
while ( $all_posts->have_posts() ) :

    $all_posts->the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('wrapper'); ?>>

        <?php
            $this->render_thumbnail(); ?>
            <div class="content">
                <h5><?php the_title()?> </h5>
                <?php the_excerpt();?>
            </div>


    </article>
<?php

endwhile; ?>
</div>
</div>
<?php
