<?php

$tt = json_encode($set_slider);
if ($settings['master_slave'] === 'yes') {
    $name_slider = $settings['name_this_slider'];
}
?>
    <div class="carousel">
        <div class="carousel-wrapper">
            <?php $this->render_header(); ?>
            <div class="pssa multiple-items <?php echo $name_slider ?>" data-id="<?php echo 'tt' . $this->get_id() ?>"
                 data-set-ss=<?php echo $tt ?>> <?php
                while ($all_posts->have_posts()) :

                    $all_posts->the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('wrapper'); ?>>
                        <div class="wrapper-in">
                            <div class="content">
                                <?php
                                $this->render_thumbnail(); ?>
                                <div class="content_text">
                                    <?php
                                    $this->render_title();

                                    $this->render_meta();
                                    $this->render_excerpt();
                                    $this->render_readmore();
                                    ?>
                                </div>
                            </div>
                        </div>

                    </article>

                <?php


                endwhile; ?>
            </div>
        </div>
    </div>
<?php
