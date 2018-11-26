<?php

// Newsletter Shortcode

add_shortcode("newsletter", "fastor_shortcode_newsletter");

function fastor_shortcode_newsletter($attr, $content = null) {

    $fastor_options = fastor_get_options();
    $custom_class = fastor_vc_custom_class();

    extract(shortcode_atts(array(
        "title" => '',
        'desc' => '',
        'layout' => 'default',
        'mailchimp_id' => '',
        'class' => ''
    ), $attr));

    ob_start();
    ?>
    <?php if($layout == 'default'):?>

        <div class="shortcode shortcode-products <?php echo esc_html($class) ?>">
            <div class="box-heading"><?php echo $title; ?></div>
            <div class="strip-line"></div>
            <div class="clearfix default-newsletter">
                <?php echo esc_html($desc); ?>
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if($layout == 'gardentools'):?>
        <div class="gardentools-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-4">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-4">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'ceramica'):?>
        <div class="ceramica-newsletter clearfix <?php echo esc_html($class) ?>">
            <div class="heading">
                <p><?php echo $title; ?></p>
            </div>

            <div class="content">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="inputs">
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'naturalcosmetics'):?>
        <div class="naturalcosmetics-newsletter clearfix <?php echo esc_html($class) ?>">
            <div class="heading">
                <p><?php echo $title; ?></p>
            </div>

            <div class="content">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="inputs">
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'wine'):?>
        <div class="newsletter wine-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'computer3'):?>
        <div class="newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'military'):?>
        <div class="military-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="left">
                <div class="heading">
                    <?php echo $title; ?>
                </div>

                <p><?php echo $desc; ?></p>
            </div>

            <div class="inputs">
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'glamshop'):?>
        <div class="newsletter glamshop-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'market'):?>
        <div class="market-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-1 hidden-xs"></div>
            <div class="col-sm-4">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <?php if($layout == 'carparts'):?>
        <div class="carparts-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-1 hidden-xs"></div>
            <div class="col-sm-4">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'cosmetics'):?>
        <div class="newsletter cosmetics-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <?php if($layout == 'cosmetics2'):?>
        <div class="newsletter cosmetics2-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'medic'):?>
        <div class="newsletter medic-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'bakery'):?>
        <div class="newsletter bakery-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <h6><?php echo $title; ?></h6>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'sportwinter'):?>
        <div class="newsletter sportwinter-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="heading col-sm-7">
                <div class="first-heading">
                    <?php echo $title; ?>
                </div>
                <div class="second-heading"><?php echo $desc; ?></div>
            </div>

            <div class="col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'architecture'):?>
        <div class="newsletter architecture-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="inputs col-sm-4">
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'exclusive'):?>
        <div class="exclusive-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content-newsletter col-sm-4 col-md-5">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="col-sm-5 col-md-4">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>


    <?php if($layout == 'books'):?>
        <div class="overflow-books-newsletter">
            <div class="books-newsletter clearfix row <?php echo esc_html($class) ?>">
                <div class="col-sm-7">
                    <div class="heading">
                        <div class="first-heading"><?php echo $title; ?></div>
                        <div class="second-heading"><?php echo $desc; ?></div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="inputs">
                        <?php if($mailchimp_id): ?>
                            <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                        <?php else: ?>
                            <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>


    <?php if($layout == 'sport'):?>
        <div class="sport-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="heading">
                <p><?php echo $title; ?></p>
            </div>

            <div class="content-newsletter">
                <?php echo $desc; ?>
            </div>

            <div class="inputs">
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>
    <?php if($layout == 'sport2'):?>
        <div class="newsletter glamshop-newsletter sport2-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-4">
                <div class="heading">
                <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="inputs col-sm-4">
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if($layout == 'spices'):?>
        <div class="newsletter spices-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="col-sm-3">
                <div class="heading">
                    <p><?php echo $title; ?></p>
                </div>
            </div>

            <div class="content col-sm-4">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="inputs col-sm-5">
                <div class="inputs">
                    <?php if($mailchimp_id): ?>
                        <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                    <?php else: ?>
                        <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>


    <?php if($layout == 'perfume'):?>
        <div class="perfume-newsletter clearfix row <?php echo esc_html($class) ?>">
            <div class="circle">
                <?php echo $title; ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?php echo $desc; ?>
                </div>

                <div class="col-md-6">
                    <div class="inputs">
                        <?php if($mailchimp_id): ?>
                            <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                        <?php else: ?>
                            <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>


    <?php if($layout == 'fashion3'):?>
        <div class="fashion3-newsletter text-center clearfix <?php echo esc_html($class) ?>">
            <div class="heading">
                <h4><?php echo $title; ?></h4>
            </div>

            <div class="content">
                <p><?php echo $desc; ?></p>
            </div>

            <div class="inputs">
                <?php if($mailchimp_id): ?>
                    <?php echo do_shortcode('[mc4wp_form id="' . $mailchimp_id . '"]'); ?>
                <?php else: ?>
                    <?php echo do_shortcode('[subscribe2 hide="unsubscribe" wrap="false"]'); ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>


    <?php

    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_shortcode_newsletter() {
        $vc_icon = fastor_vc_icon().'shortcode.png';
        $custom_class = fastor_vc_custom_class();

        vc_map( array(
            "name" => "Newsletter",
            "base" => "newsletter",
            "category" => "Fastor",
            "icon" => $vc_icon,
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => "Title",
                    "param_name" => "title",
                    "admin_label" => true
                ),
                array(
                    'type' => 'textarea_html',
                    'holder' => 'div',
                    'heading' => 'Description',
                    'param_name' => 'desc',
                ),

                array(
                    "type" => "newsletter_layout_type",
                    "heading" => "Layout",
                    "param_name" => "layout",
                    "value" => "default",
                ),
                array(
                    "type" => "textfield",
                    "heading" => "Mailchimp ID (optional)",
                    "param_name" => "mailchimp_id",
                    "admin_label" => true
                ),
                $custom_class
            )
        ) );

        if ( class_exists( 'WPBakeryShortCodes' ) ) {
            class WPBakeryShortCode_Newsletters extends WPBakeryShortCodes {
            }
        }
    }

}
