<?php

$fastor_url = 'http://cleventhemes.net/fastor/woocommerce/';

$demos = fastor_demo_types();
$demo_filters = fastor_demo_filters();



wp_register_script('fastor-admin-isotope', get_template_directory_uri().'/js/jquery.isotope.min.js', array('jquery'), FASTOR_VERSION, true);

wp_enqueue_script('fastor-admin-isotope');

?>

<div class="wrap about-wrap fastor-wrap">

    <h1><?php echo esc_html__( 'Welcome to Fastor!', 'fastor' ); ?></h1>

    <div class="about-text"><?php echo esc_html__( 'Fastor is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'fastor' ); ?></div>


    <h2 class="nav-tab-wrapper">

        <?php

        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=fastor' ), esc_html__( "Welcome", 'fastor' ) );

        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=fastor-system' ), esc_html__( "System Status", 'fastor' ) );

        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=fastor-plugins' ), esc_html__( "Plugins", 'fastor' ) );

        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( "Install Demos", 'fastor' ) );

        if(fastor_is_plugin_active( 'redux-framework/redux-framework.php' )) {
            printf('<a href="%s" class="nav-tab">%s</a>', admin_url('admin.php?page=fastor_options'), esc_html__("Theme Options", 'fastor'));
        }else{
            printf('<span class="nav-tab disabled">%s <small><strong>(%s)</strong></small></span>', esc_html__("Theme Options", 'fastor'), esc_html__("Redux framework required", 'fastor'));
        }

        ?>

    </h2>

    <div class="fastor-section">

        <p class="about-description">
            <?php echo esc_html__( 'Installing a demo provides pages, posts, menus, images, theme options, widgets and more.', 'fastor'); ?>
            <br>
            <?php echo esc_html__( 'The included plugins need to be installed and activated before you install a demo. Please check the "System Status" tab to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red.', 'fastor' ); ?>
            <br>
            <strong>
                <?php echo esc_html('IMPORTANT: If you have problem with complete demo installation (it hangs), try to an alternative way to import demo content', 'fastor') ?>
                <a href="http://fastordocs.cleventhemes.net/setup/demo-content-alternative-way" target="_blank"><?php echo esc_html('Click here to learn more', 'fastor'); ?></a>
            </strong>
            </p>

        <div class="fastor-install-demos">

            <div id="fastor-install-options" style="display: none;">

                <h3><span class="theme-name"></span> <?php echo esc_html__('Install Options', 'fastor') ?></h3>


                <input type="hidden" id="fastor-install-demo-type" value="default"/>

                <label for="fastor-reset-menus"><input type="checkbox" id="fastor-reset-menus" value="1" checked="checked"/> <?php echo esc_html__('Reset menus', 'fastor') ?></label>

                <label for="fastor-reset-widgets"><input type="checkbox" id="fastor-reset-widgets" value="1" checked="checked"/> <?php echo esc_html__('Reset widgets', 'fastor') ?></label>

                <label for="fastor-import-dummy"><input type="checkbox" id="fastor-import-dummy" value="1" checked="checked"/> <?php echo esc_html__('Import dummy content', 'fastor') ?></label>

                <label for="fastor-import-widgets"><input type="checkbox" id="fastor-import-widgets" value="1" checked="checked"/> <?php echo esc_html__('Import menus & widgets', 'fastor') ?></label>

                <p><?php echo esc_html__('Do you want to install demo? It can also take a minute to complete.', 'fastor') ?></p>

                <button class="button button-primary" id="fastor-import-yes"><?php echo esc_html__('Yes', 'fastor') ?></button>

                <button class="button" id="fastor-import-no"><?php echo esc_html__('No', 'fastor') ?></button>

            </div>

            <div id="import-status"></div>

            <div class="feature-section theme-browser rendered">

                <div class="demo-sort-filters">

                    <ul data-sort-id="theme-install-demos" class="sort-source">

                        <?php foreach ( $demo_filters as $filter_class => $filter_name) : ?>

                            <li data-filter-by="<?php echo esc_attr($filter_class) ?>" data-active="<?php echo ($filter_class=='demos' ? 'true' : 'false') ?>"><a href="#"><?php echo $filter_name ?></a></li>

                        <?php endforeach; ?>

                    </ul>

                    <div class="clear"></div>

                </div>

                <div class="" id="theme-install-demos">

                    <?php foreach ( $demos as $demo => $demo_details) : ?>

                        <div class="theme <?php echo $demo_details['filter'] ?>">

                            <div class="theme-wrapper">

                                <div class="theme-screenshot">

                                    <img src="<?php echo $demo_details['img']; ?>" />

                                    <?php printf( '<a class="preview dashicons dashicons-visibility" title="%1s" target="_blank" href="%2s"></a>', esc_html__( 'Preview', 'fastor' ), ( $demo != 'landing' ) ? $fastor_url .  $demo : $fastor_url ); ?>

                                </div>

                                <h3 class="theme-name" id="<?php echo $demo; ?>"><?php echo $demo_details['alt']; ?></h3>

                                <div class="theme-actions">

                                    <?php printf( '<a class="button button-primary button-install-demo" data-demo-id="%s" href="#">%s</a>', strtolower( $demo ), esc_html__( 'Install', 'fastor' ) ); ?>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>



    </div>


</div>