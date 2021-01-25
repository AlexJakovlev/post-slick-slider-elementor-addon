<?php
$set_slider = array(
        'dots' => true,
            'slidesToShow' => 3,
            'slidesToScroll' => 3,
            'speed' => 500,
            'easing' => 'easy',
            'responsive' => array (
                    array(
                            'breakpoint' => 768,
                        'settings' => array(
                                'slidesToShow' => 2,
                            ),
                        ),
                ),

            // appendArrows: $(".content_arrow_slick"),


        );
$tt = json_encode($set_slider);

?>
    <div class="carousel">
<div class="slider multiple-items" id="<?php echo $this->get_id() ?>" data-set-ss=<?php echo $tt ?>> <?php
while ( $all_posts->have_posts() ) :

    $all_posts->the_post(); ?>

    <article style="padding-right: 27px;" id="post-<?php the_ID(); ?>" <?php post_class('wrapper'); ?>>

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
