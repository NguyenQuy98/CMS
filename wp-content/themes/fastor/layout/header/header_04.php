<!-- HEADER
================================================== -->
<?php $fastor_options = fastor_get_options();?>

<?php if($fastor_options['header-sticky-status']):?>

    <div class="fixed-header-1 sticky-header  header-type-3 header-type-4">
        <div class="background-header"></div>
        <div class="slider-header">
            <!-- Top of pages -->
            <div id="top" class="<?php if($fastor_options['layout-header'] == 1) { echo 'full-width'; } elseif($fastor_options['layout-header'] == 4) { echo 'fixed3 fixed2'; } elseif($fastor_options['layout-header'] == 3) { echo 'fixed2';  } else { echo 'fixed'; } ?>">
                <div class="background-top"></div>
                <div class="background">
                    <div class="shadow"></div>
                    <div class="pattern">

                        <div class="container">
                            <div class="row">
                                <!-- Header Left -->
                                <div class="col-sm-4" id="header-left">
                                    <!-- Logo -->
                                    <div class="logo">
                                        <a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
                                            <?php if($fastor_options['layout-logotype']){
                                                echo '<img src="'.esc_url($fastor_options['layout-logotype']['url']).'" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ) .'"/>';
                                            } ?>
                                        </a>
                                    </div>

                                </div>

                                <!-- Header Center -->
                                <div class="col-sm-4" id="header-center">


                                    <?php if($fastor_options['advanced-settings-header-megamenu-type'] == 4 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 5 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 6 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 9 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 14 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 19 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 29) { ?>
                                    <div class="container container-megamenu2">
                                        <?php } ?>

                                        <div class="megamenu-background">
                                            <div class="">
                                                <div class="overflow-megamenu container">

                                                    <?php if ( has_nav_menu( 'sidebar_menu' ) ) : ?>
                                                    <div class="row mega-menu-modules">
                                                        <div class="col-md-3">
                                                            <?php echo fastor_sidebar_menu() ?><!-- // .megamenu-wrapper -->
                                                        </div>
                                                        <div class="col-md-9">
                                                            <?php endif; ?>
                                                            <?php echo fastor_html_mainmenu() ?><!-- // .megamenu-wrapper -->

                                                            <?php if ( has_nav_menu( 'sidebar_menu' ) ) : ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>

                                        <?php if($fastor_options['advanced-settings-header-megamenu-type'] == 4 ||
                                        $fastor_options['advanced-settings-header-megamenu-type'] == 5 ||
                                        $fastor_options['advanced-settings-header-megamenu-type'] == 6 ||
                                        $fastor_options['advanced-settings-header-megamenu-type'] == 9 ||
                                        $fastor_options['advanced-settings-header-megamenu-type'] == 14 ||
                                        $fastor_options['advanced-settings-header-megamenu-type'] == 19 ||
                                        $fastor_options['advanced-settings-header-megamenu-type'] == 29) { ?>
                                    </div>
                                <?php } ?>


                                </div>

                                <!-- Header Right -->
                                <div class="col-sm-4" id="header-right">

                                    <!-- Search -->
                                    <?php echo fastor_search_form() ?>


                                    <?php if ( is_user_logged_in() ) : ?>
                                        <?php
                                        global $current_user;

                                        wp_get_current_user();
                                        ?>

                                        <div class="my-account-with-logout">
                                            <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
                                                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" onclick="window.location.href = '<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>'" class="my-account" data-hover="dropdown" data-toggle="dropdown"><i class="fa fa-user"></i></a>
                                            <?php endif; ?>
                                            <ul class="dropdown-menu">
                                                <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
                                                    <li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e('My Account','fastor'); ?></a></li>
                                                <?php endif; ?>
                                                <li><a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) ?>"><?php esc_html_e('Log out','fastor'); ?></a></li>
                                            </ul>
                                        </div>

                                    <?php else: ?>
                                        <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
                                            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account"><i class="fa fa-user"></i></a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php echo fastor_html_minicart(); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>


<!-- HEADER
	================================================== -->
<header class=" header-type-3 header-type-4">
    <div class="background-header"></div>
    <div class="slider-header">
        <!-- Top of pages -->
        <div id="top" class="<?php if($fastor_options['layout-header'] == 1) { echo 'full-width'; } elseif($fastor_options['layout-header'] == 4) { echo 'fixed3 fixed2'; } elseif($fastor_options['layout-header'] == 3) { echo 'fixed2';  } else { echo 'fixed'; } ?>">
            <div class="background-top"></div>
            <div class="background">
                <div class="shadow"></div>
                <div class="pattern">
                    <div class="container">
                        <div class="row">
                            <!-- Header Left -->
                            <div class="col-sm-4" id="header-left">
                                <!-- Logo -->
                                <div class="logo">
                                    <a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
                                        <?php if($fastor_options['layout-logotype']){
                                            echo '<img src="'.esc_url($fastor_options['layout-logotype']['url']).'" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ) .'"/>';
                                        } ?>
                                    </a>
                                </div>

                            </div>

                            <!-- Header Center -->
                            <div class="col-sm-4" id="header-center">


                                <?php if($fastor_options['advanced-settings-header-megamenu-type'] == 4 ||
                                $fastor_options['advanced-settings-header-megamenu-type'] == 5 ||
                                $fastor_options['advanced-settings-header-megamenu-type'] == 6 ||
                                $fastor_options['advanced-settings-header-megamenu-type'] == 9 ||
                                $fastor_options['advanced-settings-header-megamenu-type'] == 14 ||
                                $fastor_options['advanced-settings-header-megamenu-type'] == 19 ||
                                $fastor_options['advanced-settings-header-megamenu-type'] == 29) { ?>
                                <div class="container container-megamenu2">
                                    <?php } ?>

                                    <div class="megamenu-background">
                                        <div class="">
                                            <div class="overflow-megamenu container">

                                                <?php if ( has_nav_menu( 'sidebar_menu' ) ) : ?>
                                                <div class="row mega-menu-modules">
                                                    <div class="col-md-3">
                                                        <?php echo fastor_sidebar_menu() ?><!-- // .megamenu-wrapper -->
                                                    </div>
                                                    <div class="col-md-9">
                                                        <?php endif; ?>
                                                        <?php echo fastor_html_mainmenu() ?><!-- // .megamenu-wrapper -->

                                                        <?php if ( has_nav_menu( 'sidebar_menu' ) ) : ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                    <?php if($fastor_options['advanced-settings-header-megamenu-type'] == 4 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 5 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 6 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 9 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 14 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 19 ||
                                    $fastor_options['advanced-settings-header-megamenu-type'] == 29) { ?>
                                </div>
                            <?php } ?>


                            </div>

                            <!-- Header Right -->
                            <div class="col-sm-4" id="header-right">
                                <?php if (is_active_sidebar( 'header-block' )) : ?>
                                    <?php if ( is_active_sidebar( 'header-block' ) ) : ?>
                                        <?php dynamic_sidebar( 'header-block' ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <!-- Search -->
                                <?php echo fastor_search_form(false) ?>


                                <?php if ( is_user_logged_in() ) : ?>
                                    <?php
                                    global $current_user;
                                    wp_get_current_user();
                                    ?>
                                    <?php if(defined('WC_VERSION')): ?>
                                        <div class="my-account-with-logout">
                                            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" onclick="window.location.href = '<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>'" class="my-account" data-hover="dropdown" data-toggle="dropdown"><i class="fa fa-user"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e('My Account','fastor'); ?></a></li>
                                                <li><a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) ?>"><?php esc_html_e('Log out','fastor'); ?></a></li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <?php if(defined('WC_VERSION')): ?>
                                        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account"><i class="fa fa-user"></i></a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php echo fastor_html_minicart(); ?>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Slider -->
    <div id="slider" class="<?php if($fastor_options['layout-slideshow'] == 1) { echo 'full-width'; } elseif($fastor_options['layout-slideshow'] == 4) { echo 'fixed3 fixed2'; } elseif($fastor_options['layout-slideshow'] == 3) { echo 'fixed2'; } else { echo 'fixed'; } ?>">
        <div class="background-slider"></div>
        <div class="background">
            <div class="shadow"></div>
            <div class="pattern">
                <?php if (is_active_sidebar( 'slider' )) : ?>
                    <?php if ( is_active_sidebar( 'slider' ) ) : ?>
                        <?php dynamic_sidebar( 'slider' ); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php fastor_slideshow(); ?>
            </div>
        </div>
    </div>

</header>

