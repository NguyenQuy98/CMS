<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fastor
 */
 
$allowedtags = fastor_get_allowed_tags();


?>                              </div>
                            </div>
                            <?php 
                            $fastor_options = fastor_get_options();
                            $fastor_layout = fastor_layout();
                            $fastor_sidebar = fastor_sidebar();

                            ?>
                            <?php if ($fastor_layout == 'right-sidebar' && $fastor_sidebar && is_active_sidebar( $fastor_sidebar )) : ?>
                            <div class="col-md-3 sidebar" id="column-right"><!-- main sidebar -->
                                <?php dynamic_sidebar( $fastor_sidebar ); ?>
                            </div><!-- end main sidebar -->
                            <?php endif; ?>
                        </div>
                        <?php if ( is_active_sidebar( 'content-bottom' ) ) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                            <?php dynamic_sidebar( 'content-bottom' ); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div><!-- // .container -->
                </div><!-- // .pattern -->
            </div><!-- // .background -->
        </div><!-- // .main-content -->
     
    <?php
	
	// Sprawdzanie czy panele są włączone
    if($fastor_options['footer-twitter-status'] || $fastor_options['footer-aboutus-status'] || $fastor_options['footer-facebook-status']) { 

        // Ustalanie szerokości paneli
        $grids = 12; $part = 0;  
        if($fastor_options['footer-aboutus-status']) { $part++; } 
        if($fastor_options['footer-twitter-status']) { $part++; } 
        if($fastor_options['footer-facebook-status']) { $part++; } 
        if($fastor_options['footer-contact-status']) { $part++; } 
        if($part == 0) { $part = 1; }
        $grids = 12/$part; 


?>
<!-- CUSTOM FOOTER
    ================================================== -->
<div class="custom-footer <?php if($fastor_options['layout-custom-footer'] == 1) { echo 'full-width'; } else { echo 'fixed'; } ?>">
    <div class="background-custom-footer"></div>
    <div class="background">
        <div class="shadow"></div>
        <div class="pattern">
            <div class="container">
                <div class="row">
                    <?php if($fastor_options['footer-aboutus-status']) { ?>
                    <!-- About us -->
                    <div class="col-lg-<?php echo esc_attr($grids); ?>">
                        <?php if($fastor_options['footer-aboutus-title'] != '') { ?>
                        <h4><i class="fa fa-info-circle"></i> <?php echo wp_kses($fastor_options['footer-aboutus-title'], $allowedtags); ?></h4>
                        <?php } ?>
                        <div class="custom-footer-text"><?php echo wp_kses(html_entity_decode($fastor_options['footer-aboutus-content']), $allowedtags); ?></div>
                    </div>
                    <?php } ?>

                    <?php if($fastor_options['footer-contact-status']) { ?>
                    <!-- Contact -->
                    <div class="col-lg-<?php echo esc_attr($grids); ?>">
                        <?php if($fastor_options['footer-contact-title'] != '') { ?>
                        <h4><i class="fa fa-envelope"></i> <?php echo wp_kses($fastor_options['footer-contact-title'], $allowedtags); ?></h4>
                        <?php } ?>
                        <ul class="contact-us clearfix">
                            <?php if($fastor_options['footer-contact-phone'] != '' || $fastor_options['footer-contact-phone2'] != '') { ?>
                            <!-- Phone -->
                            <li>
                                <i class="fa fa-mobile-phone"></i>
                                <p>
                                    <?php if($fastor_options['footer-contact-phone'] != '') { ?>
                                        <?php echo wp_kses($fastor_options['footer-contact-phone'], $allowedtags); ?><br>
                                    <?php } ?>
                                    <?php if($fastor_options['footer-contact-phone2'] != '') { ?>
                                        <?php echo wp_kses($fastor_options['footer-contact-phone2'], $allowedtags); ?>
                                    <?php } ?>
                                </p>
                            </li>
                            <?php } ?>
                            <?php if($fastor_options['footer-contact-email'] != '' || $fastor_options['footer-contact-email2'] != '') { ?>
                            <!-- Email -->
                            <li>
                                <i class="fa fa-envelope"></i>
                                <p>
                                    <?php if($fastor_options['footer-contact-email'] != '') { ?>
                                        <span><?php echo wp_kses($fastor_options['footer-contact-email'], $allowedtags); ?></span><br>
                                    <?php } ?>
                                    <?php if($fastor_options['footer-contact-email2'] != '') { ?>
                                        <span><?php echo wp_kses($fastor_options['footer-contact-email2'], $allowedtags); ?></span>
                                    <?php } ?>
                                </p>
                            </li>
                            <?php } ?>
                            <?php if($fastor_options['footer-contact-skype'] != '' || $fastor_options['footer-contact-skype2'] != '') { ?>
                            <!-- Phone -->
                            <li>
                                <i class="fa fa-skype"></i>
                                <p>
                                    <?php if($fastor_options['footer-contact-skype'] != '') { ?>
                                        <?php echo wp_kses($fastor_options['footer-contact-skype'], $allowedtags); ?><br>
                                    <?php } ?>
                                    <?php if($fastor_options['footer-contact-skype2'] != '') { ?>
                                        <?php echo wp_kses($fastor_options['footer-contact-skype2'], $allowedtags); ?>
                                    <?php } ?>
                                </p>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>

                    <?php if($fastor_options['footer-twitter-status']) { ?>
                    <!-- Twitter -->
                    <div class="col-lg-<?php echo esc_attr($grids); ?>">
                        <?php if($fastor_options['footer-twitter-title'] != '') { ?>
                        <h4><i class="fa fa-twitter"></i> <?php echo wp_kses($fastor_options['footer-twitter-title'], $allowedtags); ?></h4>
                        <?php } ?>

                        <div class="twitter-feed" data-id="<?php echo esc_html($fastor_options['footer-twitter-id']); ?>" data-max-tweets="<?php echo esc_html($fastor_options['footer-twitter-limit']); ?>" >
                            <div class="twitter-wrapper"><div class="tweets clearfix" id="twitterFeed"><small>Please wait whilst our latest tweets load.</small></div></div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if($fastor_options['footer-facebook-status']) { ?>
                    <!-- Facebook -->
                    <div class="col-lg-<?php echo esc_attr($grids); ?>">
                        <?php if($fastor_options['footer-facebook-title'] != '') { ?>
                        <h4><i class="fa fa-facebook"></i> <?php echo wp_kses($fastor_options['footer-facebook-title'], $allowedtags); ?></h4>
                        <?php } ?>

                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>

                        <div id="facebook">

                            <div class="fb-like-box fb_iframe_widget"
                                 data-profile_id="<?php echo esc_html($fastor_options['footer-facebook-id']); ?>"
                                 data-show-border="false"
                                 data-width="260"
                                 data-height="<?php if($fastor_options['footer-facebook-height'] > 0) { echo esc_html($fastor_options['footer-facebook-height']);
                             } else {
                                 echo '210';
                             } ?>"
                                 data-colorscheme="<?php if($fastor_options['footer-facebook-colorscheme'] != '1') {echo 'light'; } else { echo 'dark'; } ?>" data-stream="false"
                                 data-header="false"
                                 data-show-faces="<?php if($fastor_options['footer-facebook-showfaces']) { echo 'true'; } else { echo 'false'; } ?>" fb-xfbml-state="rendered"></div>
                        </div>
                    </div>
                    <?php } ?>

                </div>

            </div>
        </div>
    </div>
</div>
	<?php } ?>




     	<!-- FOOTER
     	 ================================================== -->
     	<footer class="footer <?php if($fastor_options['layout-footer'] == 1) { echo 'full-width'; } else { echo 'fixed'; } ?>">
     		<div class="background-footer"></div>
     		<div class="background">
     		     <div class="shadow"></div>
     		     <div class="pattern">
     		          <div class="container">
                          <?php if ( is_active_sidebar( 'footer-top' ) ) : ?>
                            <div class="row">
                                <div class="col-sm-12">
                                <?php dynamic_sidebar( 'footer-top' ); ?>
                                </div>
                            </div>
                           <?php endif; ?>
     		               <div class="row">
                            
                                <?php 
                                $cols = 0; 
                                for ($i = 1; $i <= 4; $i++) {
                                    if ( is_active_sidebar( 'footer-column-'. $i ) ) 
                                        $cols++;
                                }
                                if ($cols) : 
                                    $sm = 'col-sm-'. (12 / $cols);
                                ?>
                                <?php
                                $cols = 0;
                                for ($i = 1; $i <= 4; $i++) {
                                    if ( is_active_sidebar( 'footer-column-'. $i ) ) {
                                        $cols++;
                                        ?>
                                        <div class="<?php echo esc_attr($sm) ?>">
                                            <?php dynamic_sidebar( 'footer-column-'. $i ); ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                <?php endif; ?>
                              </div><!-- // .row -->
                          <?php if ( is_active_sidebar( 'footer-bottom' ) ) : ?>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <?php dynamic_sidebar( 'footer-bottom' ); ?>
                                  </div>
                              </div>
                          <?php endif; ?>
                          <?php if ( is_active_sidebar( 'footer-bottom2' ) ) : ?>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <?php dynamic_sidebar( 'footer-bottom2' ); ?>
                                  </div>
                              </div>
                          <?php endif; ?>
                         </div><!-- // .container -->
                    </div><!-- // .pattern -->
               </div><!-- // .background -->
          </footer><!-- // .footer -->
               
    </div><!-- // #main -->

</div>


<?php if($fastor_options['widget-facebook-status']) { ?>
    <div id="widget-facebook" class="facebook_<?php if($fastor_options['widget-facebook-position'] == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
        <div class="facebook-icon"><i class="fa fa-facebook" aria-hidden="true"></i></div>
        <div class="facebook-content">
            <div class="fb-like-box fb_iframe_widget" data-profile_id="<?php echo esc_html($fastor_options['widget-facebook-id']); ?>" data-colorscheme="light" data-height="370" data-connections="16" ></div>
        </div>
    </div>
<?php } ?>

<?php if($fastor_options['widget-twitter-status']) { ?>
    <div id="widget-twitter" class="twitter_<?php if($fastor_options['widget-twitter-position'] == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
        <div class="twitter-icon"><i class="fa fa-twitter" aria-hidden="true"></i></div>
        <div class="twitter-content" id="widget-twitter-content">
            <a class="twitter-timeline"  href="https://twitter.com/<?php echo esc_html($fastor_options['widget-twitter-username']); ?>"
               data-tweet-limit="<?php echo esc_html($fastor_options['widget-twitter-limit']); ?>" >
                Tweets by @<?php echo esc_html($fastor_options['widget-twitter-username']); ?></a>
        </div>
    </div>
<?php } ?>

<?php if($fastor_options['widget-custom-status']) { ?>
    <div id="widget-custom-content" class="custom_<?php if($fastor_options['widget-custom-position'] == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
        <div class="custom-icon">
            <?php if($fastor_options['widget-custom-position'] == 1):?>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            <?php else: ?>
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            <?php endif; ?>
        </div>
        <div class="custom-content">
            <?php //echo fastor_parse_shortcode(html_entity_decode($fastor_options['block-popup-content'])); ?>
            <?php $custom_content = fastor_parse_shortcode($fastor_options['widget-custom-content']); ?>
            <?php if(isset($custom_content)) echo wp_kses($custom_content, $allowedtags); ?>
        </div>
    </div>
<?php } ?>

<?php if($fastor_options['block-popup-status']) { ?>
    <?php if (!$fastor_options['block-popup-only-homepage'] || ( $fastor_options['block-popup-only-homepage'] && is_front_page())):?>
        <div id="popup" class="popup popup-newsletter mfp-hide <?php echo intval($fastor_options['block-popup-showonlyonce']) ? ' onlyonce' : ''; ?>" style="max-width: <?php echo esc_attr($fastor_options['block-popup-width']); ?>">
            <?php if ($fastor_options['block-popup-custom_block'] != '') { ?>
                <?php echo do_shortcode('[custom_block name="'.esc_attr($fastor_options['block-popup-custom_block']).'"]') ?>
                <?php
            }?>
            <?php echo fastor_parse_shortcode(html_entity_decode($fastor_options['block-popup-content'])); ?>
            <?php if($fastor_options['block-popup-dont-show-again-status']):?>
                <div class="dont-show-label">
                    <label>
                        <input type="checkbox" class="dont-show-me" />
                        <span><?php echo $fastor_options['block-popup-dont-show-again-text']; ?></span>
                    </label>
                </div>
            <?php endif ?>
        </div>
    <?php endif; ?>
<?php } ?>



<?php if($fastor_options['block-cookie-status']): ?>
    <div id="cookie" class="cookie "
         style="position: fixed;
             width: 100%;
             display: none;
             z-index: 9999;
         <?php if($fastor_options['block-cookie-position'] != '') {
             echo esc_attr($fastor_options['block-cookie-position']).': 0';
         }else{
             echo 'bottom: 0; top: auto';
         } ?>
             ">
        <div class="standard-body">
            <div class="full-width">
                <div class="container">
                    <div class="content"><?php echo wp_kses($fastor_options['block-cookie-content'], $allowedtags) ?></div>

                    <div class="operations">
                        <?php if($fastor_options['block-cookie-button-status']):?>
                            <div class="button"><?php echo wp_kses($fastor_options['block-cookie-button-text'], $allowedtags); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<a href="#" class="scrollup btn"><i class="fa fa-angle-up"></i></a>



<?php wp_footer(); ?>
</body>
</html>
