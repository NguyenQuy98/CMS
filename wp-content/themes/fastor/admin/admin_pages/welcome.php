
<div class="wrap about-wrap fastor-wrap">
    <h1><?php echo esc_html__( 'Welcome to Fastor!', 'fastor' ); ?></h1>
    <div class="about-text">
        <?php echo esc_html__( 'Fastor is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'fastor' ); ?>
    </div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( "Welcome", 'fastor' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=fastor-system' ), esc_html__( "System Status", 'fastor' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=fastor-plugins' ), esc_html__( "Plugins", 'fastor' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=fastor-demos' ), esc_html__( "Install Demos", 'fastor' ) );
        if(fastor_is_plugin_active( 'redux-framework/redux-framework.php' )) {
            printf('<a href="%s" class="nav-tab">%s</a>', admin_url('admin.php?page=fastor_options'), esc_html__("Theme Options", 'fastor'));
        }else{
            printf('<span class="nav-tab disabled">%s <small><strong>(%s)</strong></small></span>', esc_html__("Theme Options", 'fastor'), esc_html__("Redux framework required", 'fastor'));
        }
        ?>
    </h2>
    <div class="fastor-section">
        <p class="about-description">
            <?php printf(wp_kses(__( 'Before you get started, please be sure to always check out <a href="%s" target="_blank">this documentation</a>.
 We outline all kinds of good information, and provide you with all the details you need to use Fastor.', 'fastor'), fastor_get_allowed_tags()), 'http://fastordocs.cleventhemes.net/'); ?>
        </p>
        <p class="about-description">
            <?php printf( wp_kses(__( 'If you are unable to find your answer in our documentation, we encourage you to contact us through
 <a href="%s" target="_blank">contact from</a>
  with your site FTP and wordpress admin details. 
  We are very happy to help you and you will get reply from us more faster than you expected.', 'fastor'), fastor_get_allowed_tags()), 'https://themeforest.net/user/cleventhemes'); ?>
        </p>
        <img src="<?php echo get_template_directory_uri() ?>/screenshot.png"/>

    </div>
</div>