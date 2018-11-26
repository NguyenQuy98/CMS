<div class="wrap about-wrap fastor-wrap">
    <h1><?php echo esc_html__( 'Welcome to Fastor!', 'fastor' ); ?></h1>
    <div class="about-text"><?php echo esc_html__( 'Fastor is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'fastor' ); ?></div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=fastor' ), esc_html__( "Welcome", 'fastor' ) );
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( "System Status", 'fastor' ) );
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
        <table class="widefat" cellspacing="0">
            <thead>
            <tr>
                <th colspan="2"><?php echo esc_html__( 'Fastor Versions', 'fastor' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo esc_html__( 'Current Version:', 'fastor' ); ?></td>
                <td><?php echo FASTOR_VERSION; ?></td>
            </tr>
            </tbody>
        </table>
        <table class="widefat" cellspacing="0">
            <thead>
            <tr>
                <th colspan="2"><?php echo esc_html__( 'WordPress Environment', 'fastor' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo esc_html__( 'Home URL:', 'fastor' ); ?></td>
                <td><?php echo esc_url(home_url('/')); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'Site URL:', 'fastor' ); ?></td>
                <td><?php echo esc_url(site_url('/')); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'WP Version:', 'fastor' ); ?></td>
                <td><?php bloginfo('version'); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'WP Multisite:', 'fastor' ); ?></td>
                <td><?php if ( is_multisite() ) echo '&#10004;'; else echo '&ndash;'; ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'WP Memory Limit:', 'fastor' ); ?></td>
                <td><?php
                    $memory = $this->let_to_num( WP_MEMORY_LIMIT );
                    if ( $memory < 128000000 ) {
                        echo '<mark class="error">' . sprintf( wp_kses(__( '%s - We recommend setting memory to at least <strong>128MB</strong>.<br /> Please define memory limit in <strong>wp-config.php</strong> file. To learn how, see: <a href="%s" target="_blank">Increasing memory allocated to PHP.</a>', 'fastor' ), fastor_get_allowed_tags()), size_format( $memory ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
                    } else {
                        echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
                        if ( $memory < 256000000 ) {
                            echo '<br /><mark class="error">' . wp_kses(__( 'Your current memory limit is sufficient, but if you installed many plugins or need to import demo content, the required memory limit is <strong>256MB.</strong>', 'fastor' ), fastor_get_allowed_tags()) . '</mark>';
                        }
                    }
                    ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'WP Debug Mode:', 'fastor' ); ?></td>
                <td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . '&#10004;' . '</mark>'; else echo '<mark class="no">' . '&ndash;' . '</mark>'; ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'Language:', 'fastor' ); ?></td>
                <td><?php echo get_locale() ?></td>
            </tr>
            </tbody>
        </table>
        <table class="widefat" cellspacing="0">
            <thead>
            <tr>
                <th colspan="2"><?php echo esc_html__( 'Server Environment', 'fastor' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo esc_html__( 'PHP Version:', 'fastor' ); ?></td>
                <td><?php if ( function_exists( 'phpversion' ) ) echo esc_html( phpversion() ); ?></td>
            </tr>
            <?php if ( function_exists( 'ini_get' ) ) : ?>
                <tr>
                    <td><?php echo esc_html__( 'PHP Post Max Size:', 'fastor' ); ?></td>
                    <td><?php echo size_format( $this->let_to_num( ini_get('post_max_size') ) ); ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'PHP Time Limit:', 'fastor' ); ?></td>
                    <td><?php
                        $time_limit = ini_get('max_execution_time');
                        if ( $time_limit < 180 && $time_limit != 0 ) {
                            echo '<mark class="error">' . sprintf( wp_kses(__( '%s - We recommend setting max execution time to at least 180. <br /> To import demo content, <strong>300</strong> seconds of max execution time is required.<br />See: <a href="%s" target="_blank">Increasing max execution to PHP</a>', 'fastor' ), fastor_get_allowed_tags()), $time_limit, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) . '</mark>';
                        } else {
                            echo '<mark class="yes">' . $time_limit . '</mark>';
                            if ( $time_limit < 300 && $time_limit != 0 ) {
                                echo '<br /><mark class="error">' . wp_kses(__( 'Current time limit is sufficient, but if you need import demo content, the required time is <strong>300</strong>.', 'fastor' ), fastor_get_allowed_tags()) . '</mark>';
                            }
                        }
                        ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'PHP Max Input Vars:', 'fastor' ); ?></td>
                    <td><?php
                        echo $max_input_vars = ini_get('max_input_vars');
                        ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'SUHOSIN Installed:', 'fastor' ); ?></td>
                    <td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
                </tr>
                <?php if ( extension_loaded( 'suhosin' ) ): ?>
                    <tr>
                        <td><?php echo esc_html__( 'Suhosin Post Max Vars:', 'fastor' ); ?></td>
                        <td><?php
                            echo $max_input_vars = ini_get( 'suhosin.post.max_vars' );
                            ?></td>
                    </tr>
                    <tr>
                        <td><?php echo esc_html__( 'Suhosin Request Max Vars:', 'fastor' ); ?></td>
                        <td><?php
                            echo $max_input_vars = ini_get( 'suhosin.request.max_vars' );
                            ?></td>
                    </tr>
                    <tr>
                        <td><?php echo esc_html__( 'Suhosin Post Max Value Length:', 'fastor' ); ?></td>
                        <td><?php
                            $suhosin_max_value_length = ini_get( "suhosin.post.max_value_length" );
                            $recommended_max_value_length = 2000000;
                            if ( $suhosin_max_value_length < $recommended_max_value_length ) {
                                echo '<mark class="error">' . sprintf( wp_kses(__( '%s - Recommended Value: %s.<br />Post Max Value Length limitation may prohibit the Theme Options data from being saved to your database. See: <a href="%s" target="_blank">Suhosin Configuration Info</a>.', 'fastor' ), fastor_get_allowed_tags()), $suhosin_max_value_length, '<strong>' . $recommended_max_value_length . '</strong>', 'http://suhosin.org/stories/configuration.html' ) . '</mark>';
                            } else {
                                echo '<mark class="yes">' . $suhosin_max_value_length . '</mark>';
                            }
                            ?></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
            <tr>
                <td><?php echo esc_html__( 'GZip:', 'fastor' ); ?></td>
                <td><?php echo class_exists( 'ZipArchive' ) ? '&#10004;' : '&ndash;'; ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'MySQL Version:', 'fastor' ); ?></td>
                <td>
                    <?php
                    global $wpdb;
                    if (version_compare($wpdb->db_version(), '5.0', '>=')) {
                        echo '<mark class="yes">' . $wpdb->db_version() . '</mark>';
                    } else {
                        echo '<mark class="error">' . $wpdb->db_version() . '</mark>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'Max Upload Size:', 'fastor' ); ?></td>
                <td><?php echo size_format( wp_max_upload_size() ); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'DOMDocument:', 'fastor' ); ?></td>
                <td><?php echo class_exists( 'DOMDocument' ) ? '&#10004;' : '&ndash;'; ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'WP Remote Get:', 'fastor' ); ?></td>
                <?php $response = wp_safe_remote_get( 'https://www.woothemes.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) ); ?>
                <td><?php echo ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">wp_remote_get() failed. Some theme features may not work. Please contact your hosting provider.</mark>'; ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__( 'WP Remote Post:', 'fastor' ); ?></td>
                <?php $response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array(
                    'timeout'     => 60,
                    'user-agent'  => 'WooCommerce/2.6',
                    'httpversion' => '1.1',
                    'body'        => array(
                        'cmd'    => '_notify-validate'
                    )
                ) ); ?>
                <td><?php echo ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">wp_remote_post() failed. Some theme features may not work. Please contact your hosting provider.</mark>'; ?></td>
            </tr>
            </tbody>
        </table>
        <table class="widefat" cellspacing="0" id="status">
            <thead>
            <tr>
                <th colspan="2"><?php echo esc_html__( 'Active Plugins', 'fastor' ); ?> (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if ( is_multisite() ) {
                $active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
            }
            foreach ( $active_plugins as $plugin ) {
                $plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
                $version_string = '';
                $network_string = '';
                if ( ! empty( $plugin_data['Name'] ) ) {
                    // link the plugin name to the plugin url if available
                    $plugin_name = esc_html( $plugin_data['Name'] );
                    if ( ! empty( $plugin_data['PluginURI'] ) ) {
                        $plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_html__( 'Visit plugin homepage' , 'fastor' ) . '">' . $plugin_name . '</a>';
                    }
                    ?>
                    <tr>
                        <td><?php echo $plugin_name; ?></td>
                        <td><?php printf( _x( 'by %s', 'by author', 'fastor' ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>