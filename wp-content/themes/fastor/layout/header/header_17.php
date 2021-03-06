<!-- HEADER
================================================== -->
<?php $fastor_options = fastor_get_options();?>

<?php if($fastor_options['header-sticky-status']):?>

    <div class="fixed-header-1 sticky-header">
        <div class="background-header"></div>
        <div class="slider-header">
            <!-- Top of pages -->
            <div id="top" class="<?php if($fastor_options['layout-header'] == 1) { echo 'full-width'; } elseif($fastor_options['layout-header'] == 4) { echo 'fixed3 fixed2'; } elseif($fastor_options['layout-header'] == 3) { echo 'fixed2';  } else { echo 'fixed'; } ?>">
                <div class="background-top"></div>
                <div class="background">
                    <div class="shadow"></div>
                    <div class="pattern">
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
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>


<!-- HEADER
	================================================== -->
<header class="header-type-17">
    <div class="background-header"></div>
    <div class="slider-header">
        <!-- Top of pages -->
        <div id="top" class="<?php if($fastor_options['layout-header'] == 1) {
                echo 'full-width';
            }
            elseif($fastor_options['layout-header'] == 4) {
                echo 'fixed3 fixed2';
            } elseif($fastor_options['layout-header'] == 3) { echo 'fixed2';
            } else {
                echo 'fixed';
            } ?>">
            <div class="background-top"></div>
            <div class="background">
                <div class="shadow"></div>
                <div class="pattern">
                    
                    <div class="container">
                        <div class="row">
                            <!-- Header Left -->
                            <div class="col-sm-4" id="header-left">
                                <?php if (is_active_sidebar( 'header-block' )) : ?>
                                    <?php if ( is_active_sidebar( 'header-block' ) ) : ?>
                                        <?php dynamic_sidebar( 'header-block' ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php echo fastor_html_topmenu() ?>

                            </div>

                            <!-- Header Center -->
                            <div class="col-sm-4" id="header-center">
                                <!-- Logo -->
                                <div class="logo">
                                    <a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
                                        <?php if($fastor_options['layout-logotype']){
                                            echo '<img src="'.esc_url($fastor_options['layout-logotype']['url']).'" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ) .'"/>';
                                        } ?>
                                    </a>
                                </div>
                            </div>

                            <!-- Header Right -->
                            <div class="col-sm-4" id="header-right">

                                <?php echo fastor_currency_switcher() ?>
                                <?php echo fastor_lang_switcher() ?>
                                <?php echo fastor_html_minicart(); ?>

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

                    <?php if (is_active_sidebar( 'under-menu' )) : ?>
                        <?php if ( is_active_sidebar( 'under-menu' ) ) : ?>
                            <?php dynamic_sidebar( 'under-menu' ); ?>
                        <?php endif; ?>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>

    <!-- Slider -->
    <?php if (is_active_sidebar( 'slider' ) || is_fastor_slideshow()) : ?>
        <div id="slider" class="
                <?php if($fastor_options['layout-slideshow'] == 1) {
                    echo 'full-width';
                } else if ($fastor_options['layout-slideshow'] == 4){
                    echo 'fixed3 fixed2';
                } else if ($fastor_options['layout-slideshow'] == 3){
                    echo 'fixed2';
                }else{
                    echo 'fixed';
                } ?>">

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
    <?php endif; ?>

</header>

