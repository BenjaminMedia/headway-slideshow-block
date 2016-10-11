<?php
class HeadwaySlideshowBlock extends HeadwayBlockAPI {

    public $id = 'Slideshow';
    public $name = 'Slideshow';
    public $options_class = 'HeadwaySlideshowBlockOptions';

    public static function enqueue_action($block_id, $block) {
        add_action('headway_body_close', array(__CLASS__, 'add_slideshow_js'));
        return;
    }

    public static function add_slideshow_js() {
        /* Check to make sure it hasn't been loaded before */
        global $headway_slideshow_block_enqueued;
        if ( isset( $headway_slideshow_block_enqueued ) && $headway_slideshow_block_enqueued ) {
            return false;
        }

        /* Hasn't been loaded, go ahead and load js now */
        ?>
        <link rel="stylesheet" href="<?php echo plugins_url('headway-slideshow-block/assets/owl.carousel.css'); ?>">
        <link rel="stylesheet" href="<?php echo plugins_url('headway-slideshow-block/assets/style.css'); ?>">
        <script type="text/javascript" src="<?php echo plugins_url('headway-slideshow-block/assets/owl.carousel.js'); ?>"></script>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("#main-carousel-container").owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: true,
                    navText: [
                        "<i class='icon-chevron-left icon-white'></i>",
                        "<i class='icon-chevron-right icon-white'</i>"
                    ],
                    dots: false,
                    items: 1,
                    center: true,
                    autoHeight: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    autoplaySpeed: 1000,

                });
            });
        </script>
        <?php
        $headway_slideshow_block_enqueued = true;
    }

    /* DISPLAY BLOCK CONTENT */
    function content($block) {
        ?>
        <div class="home-slider">
            <div class="wrap">
                <div class="container">
                    <div id="main-carousel-container" class="owl-carousel">
                        <?php
                        $slides = get_field('slides', 'option');
                        foreach ($slides as $post_id) {
                            $post = get_post($post_id);
                            $post_id = $post->ID;
                            
                            if ($post->post_type == 'attachment') {
                                // image
                                $thumb_url = wp_get_attachment_image_src($post_id, 'large');
                            } else {
                                // post page
                                $categories = wp_get_post_categories($post_id);
                                $thumb_id = get_post_thumbnail_id($post_id);
                                $thumb_url = wp_get_attachment_image_src($thumb_id, 'large');
                            }
                            ?>
                            <div class="slider-content">
                                <div class="sldr-img" style="background-image: url(<?php echo $thumb_url[0]; ?>);"></div>
                                <?php if ($post->post_type != 'attachment') { ?>
                                <div class="sldr-post-cntnt-algnr">
                                    <div class="sldr-post-cntnt">
                                        <div class="sldr-post-cntnt-brdr">
                                            <div class="sldr-ttl">
                                                <span class="excrpt-cats">
                                                    <span class="entry-categories">
                                                        <?php foreach ($categories as $id) {
                                                            $category = get_category($id); ?>
                                                            <a href="<?php echo get_category_link($id); ?>" rel="category tag"><?php echo $category->name; ?></a>
                                                        <?php } ?>
                                                    </span>
                                                </span>
                                                <a href="<?php echo get_permalink($post_id); ?>" title="<?php echo $post->post_title; ?>">
                                                    <h1 class="sldr-ttl-h"><?php echo $post->post_title; ?></h1>
                                                </a>
                                            </div>
                                            <div class="sldr-cntnt">
                                                <div class="sldr-rdmr">
                                                    <a href="<?php echo get_permalink($post_id); ?>">READ MORE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div><!-- .slider-content -->
                        <?php } ?>
                    </div><!-- .owl-carousel -->
                </div><!-- .container -->
                <div class="clearfix"></div>
            </div>
        </div>
        <?php
    }
}