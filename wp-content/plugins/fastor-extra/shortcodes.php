<?php

function fastor_shortcodes_formatter($content) {
    $block = join("|",array("map", "testimonials", "testimonial", "faq", "sw_bestseller_products",
        "sw_featured_products", "sw_sale_products", "sw_latest_products", 'sw_custom_products', "background", "container",
        "feature_box", "feature_box_slider", "brands", "brand", "carousel", "carousel_item", "filter_products", "filter_products_tab","animation", "content_box",
        "persons", "person", "person_boxs", "person_box", "persons_slider", "persons_slide",
        "quote", "title", "camera_slider", "camera_slide", "latest_posts", "custom_block", "menu", "newsletter", "buttongroup", "btngrptoolbar", "button",
        "dl", "dlitem", "dropdown", "dropdownhead", "dropdownbody", "dropdownitem", "icon", "iconheading",
        "image", "label", "list", "li", "notification", "popover", "panel", "panel-footer",
        "panel-header", "panel-content",  "table", "table_head", "table_body", "table_row",
        "row_column", "th_column", "tabs", "tab", "thumbnail", "toggles", "toggle", "tooltip", "well",
        "row", "column", "one_half", "one_half_last", "one_third", "one_third_last", "two_third", "two_third_last",
        "one_fourth", "one_fourth_last", "three_fourth", "three_fourth_last", "one_fourth_second", "one_fourth_third",
        "one_half_second", "one_third_second", "one_column", "counter_circle", "counter_box", "fontawesome",
        "pre", "servicebox", "slider", "grid_container", "grid_item", "posts", "posts_slider"));
    
    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)/","[/$2]",$rep);

    return $rep;
}

add_filter('the_content', 'fastor_shortcodes_formatter');
add_filter('widget_text', 'fastor_shortcodes_formatter');


function fastor_extra_admin_scripts(){
    wp_register_style( 'fastor-extra', plugins_url( 'shortcodes/css/shortcodes.css', __FILE__ ));
    wp_enqueue_style( 'fastor-extra' );
}

add_action('admin_enqueue_scripts', 'fastor_extra_admin_scripts');

// Shortcodes
global $fastor_shortcode_files;

$fastor_shortcode_files = array(
    "latest_posts",
    "custom_block",
    "menu",
    "newsletter",
    "brands",
    "carousel",
    "products",
    "custom_products",
    "camera_slider",
    "filter_products",
    "bootstrap",
);

// Add buttons to tinyMCE
class Fastor_TinyMCE_Buttons {
    function __construct() {
        add_action( 'init', array(&$this,'init') );
    }
    function init() {
        if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
            return;        
        if ( get_user_option('rich_editing') == 'true' ) {  
            add_filter( 'mce_external_plugins', array(&$this, 'add_plugin') );  
            add_filter( 'mce_buttons', array(&$this,'register_button') ); 
            }  
    }  
    function add_plugin($plugin_array) {
        if (get_bloginfo('version') >= 3.9)
            $plugin_array['shortcodes'] =plugins_url( 'shortcodes/tinymce/shortcodes_new.js', __FILE__ );
        else
            $plugin_array['shortcodes'] = plugins_url( 'shortcodes/tinymce/shortcodes.js', __FILE__ );

        $plugin_array['fastor_shortcodes'] = plugins_url( 'shortcodes/js/fastor_shortcodes.js', __FILE__ );
        return $plugin_array;
    }
    function register_button($buttons) {  
        array_push($buttons, "shortcodes_button");
        return $buttons; 
    }     
}
$shortcode = new Fastor_TinyMCE_Buttons;

foreach ($fastor_shortcode_files as $file){
    include plugin_dir_path(__FILE__).'shortcodes/'.$file.'.php';
}

// Register Shortcodes in Visual Composer Editor
if (function_exists('vc_set_as_theme')) {

    function fastor_vc_icon() {
        return plugins_url( 'shortcodes/images/', __FILE__ );
    }

    
    function fastor_vc_layout_type() {
        return array(
            "type" => "layout_type",
            "heading" => "Layout Type",
            "param_name" => "layout_type",
            "admin_label" => true
        );
    }
    
    function fastor_vc_animation_type() {
        return array(
            "type" => "animation_type",
            "heading" => "Animation Type",
            "param_name" => "animation_type",
            "admin_label" => true
        );
    }


    function fastor_vc_animation_duration() {
        return array(
            "type" => "textfield",
            "heading" => "Animation Duration",
            "param_name" => "animation_duration",
            "description" => "numerical value (unit: seconds)",
            "value" => '1'
        );
    }

    function fastor_vc_animation_delay() {
        return array(
            "type" => "textfield",
            "heading" => "Animation Delay",
            "param_name" => "animation_delay",
            "description" => "numerical value (unit: seconds)",
            "value" => '0'
        );
    }

    function fastor_vc_custom_class() {
        return array(
            "type" => "textfield",
            "heading" => "Extra Class Name",
            "param_name" => "class",
            "admin_label" => true
        );
    }


    function fastor_vc_layout_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("0" => "Full width", "1" => "Fixed");
        foreach ( $options as $option => $label ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . $label . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }
    

    function fastor_vc_text_transform_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $param_line .= '<option value="">None</option>';

        $options = array("capitalize", "uppercase", "lowercase");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_title_size_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("", "large");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_boolean_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("true", "false");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_line_pos_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("top", "middle", "bottom");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_align_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("left", "center", "right");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }


    function fastor_vc_link_target_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("", "_blank", "_self", "_parent", "_top");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords(str_replace("_", "", $option)) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_fontawesome_icon_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("adjust", "adn", "align-center", "align-justify", "align-left", "align-right", "ambulance",
            "anchor", "android", "angle-double-down", "angle-double-left", "angle-double-right", "angle-double-up",
            "angle-down", "angle-left", "angle-right", "angle-up", "apple", "archive", "arrow-circle-down",
            "arrow-circle-left", "arrow-circle-o-down", "arrow-circle-o-left", "arrow-circle-o-right",
            "arrow-circle-o-up", "arrow-circle-right", "arrow-circle-up", "arrow-down", "arrow-left", "arrow-right",
            "arrow-up", "arrows", "arrows-alt", "arrows-h", "arrows-v", "asterisk", "automobile", "backward", "ban",
            "bank", "bar-chart-o", "barcode", "bars", "beer", "behance", "behance-square", "bell", "bell-o",
            "bitbucket", "bitbucket-square", "bitcoin", "bold", "bolt", "bomb", "book", "bookmark", "bookmark-o",
            "briefcase", "btc", "bug", "building", "building-o", "bullhorn", "bullseye", "cab", "calendar",
            "calendar-o", "camera", "camera-retro", "car", "caret-down", "caret-left", "caret-right",
            "caret-square-o-down", "caret-square-o-left", "caret-square-o-right", "caret-square-o-up", "caret-up",
            "certificate", "chain", "chain-broken", "check", "check-circle", "check-circle-o", "check-square",
            "check-square-o", "chevron-circle-down", "chevron-circle-left", "chevron-circle-right", "chevron-circle-up",
            "chevron-down", "chevron-left", "chevron-right", "chevron-up", "child", "circle", "circle-o",
            "circle-o-notch", "circle-thin", "clipboard", "clock-o", "cloud", "cloud-download", "cloud-upload", "cny",
            "code", "code-fork", "codepen", "coffee", "cog", "cogs", "columns", "comment", "comment-o", "comments",
            "comments-o", "compass", "compress", "copy", "credit-card", "crop", "crosshairs", "css3", "cube", "cubes",
            "cut", "cutlery", "dashboard", "database", "dedent", "delicious", "desktop", "deviantart", "digg", "dollar",
            "dot-circle-o", "download", "dribbble", "dropbox", "drupal", "edit", "eject", "ellipsis-h", "ellipsis-v",
            "empire", "envelope", "envelope-o", "envelope-square", "eraser", "eur", "euro", "exchange", "exclamation",
            "exclamation-circle", "exclamation-triangle", "expand", "external-link", "external-link-square", "eye",
            "eye-slash", "facebook", "facebook-square", "fast-backward", "fast-forward", "fax", "female", "fighter-jet",
            "file", "file-archive-o", "file-audio-o", "file-code-o", "file-excel-o", "file-image-o", "file-movie-o",
            "file-o", "file-pdf-o", "file-photo-o", "file-picture-o", "file-powerpoint-o", "file-sound-o", "file-text",
            "file-text-o", "file-video-o", "file-word-o", "file-zip-o", "files-o", "film", "filter", "fire",
            "fire-extinguisher", "flag", "flag-checkered", "flag-o", "flash", "flask", "flickr", "floppy-o", "folder",
            "folder-o", "folder-open", "folder-open-o", "font", "forward", "foursquare", "frown-o", "gamepad", "gavel",
            "gbp", "ge", "gear", "gears", "gift", "git", "git-square", "github", "github-alt", "github-square",
            "gittip", "glass", "globe", "google", "google-plus", "google-plus-square", "graduation-cap", "group",
            "h-square", "hacker-news", "hand-o-down", "hand-o-left", "hand-o-right", "hand-o-up", "hdd-o", "header",
            "headphones", "heart", "heart-o", "history", "home", "hospital-o", "html5", "image", "inbox", "indent",
            "info", "info-circle", "inr", "instagram", "institution", "italic", "joomla", "jpy", "jsfiddle", "key",
            "keyboard-o", "krw", "language", "laptop", "leaf", "legal", "lemon-o", "level-down", "level-up",
            "life-bouy", "life-ring", "life-saver", "lightbulb-o", "link", "linkedin", "linkedin-square", "linux",
            "list", "list-alt", "list-ol", "list-ul", "location-arrow", "lock", "long-arrow-down", "long-arrow-left",
            "long-arrow-right", "long-arrow-up", "magic", "magnet", "mail-forward", "mail-reply", "mail-reply-all",
            "male", "map-marker", "maxcdn", "medkit", "meh-o", "microphone", "microphone-slash", "minus",
            "minus-circle", "minus-square", "minus-square-o", "mobile", "mobile-phone", "money", "moon-o",
            "mortar-board", "music", "navicon", "openid", "outdent", "pagelines", "paper-plane", "paper-plane-o",
            "paperclip", "paragraph", "paste", "pause", "paw", "pencil", "pencil-square", "pencil-square-o", "phone",
            "phone-square", "photo", "picture-o", "pied-piper", "pied-piper-alt", "pied-piper-square", "pinterest",
            "pinterest-square", "plane", "play", "play-circle", "play-circle-o", "plus", "plus-circle", "plus-square",
            "plus-square-o", "power-off", "print", "puzzle-piece", "qq", "qrcode", "question", "question-circle",
            "quote-left", "quote-right", "ra", "random", "rebel", "recycle", "reddit", "reddit-square", "refresh",
            "renren", "reorder", "repeat", "reply", "reply-all", "retweet", "rmb", "road", "rocket", "rotate-left",
            "rotate-right", "rouble", "rss", "rss-square", "rub", "ruble", "rupee", "save", "scissors", "search",
            "search-minus", "search-plus", "send", "send-o", "share", "share-alt", "share-alt-square", "share-square",
            "share-square-o", "shield", "shopping-cart", "sign-in", "sign-out", "signal", "sitemap", "skype", "slack",
            "sliders", "smile-o", "sort", "sort-alpha-asc", "sort-alpha-desc", "sort-amount-asc", "sort-amount-desc",
            "sort-asc", "sort-desc", "sort-down", "sort-numeric-asc", "sort-numeric-desc", "sort-up", "soundcloud",
            "space-shuttle", "spinner", "spoon", "spotify", "square", "square-o", "stack-exchange", "stack-overflow",
            "star", "star-half", "star-half-empty", "star-half-full", "star-half-o", "star-o", "steam", "steam-square",
            "step-backward", "step-forward", "stethoscope", "stop", "strikethrough", "stumbleupon",
            "stumbleupon-circle", "subscript", "suitcase", "sun-o", "superscript", "support", "table", "tablet",
            "tachometer", "tag", "tags", "tasks", "taxi", "tencent-weibo", "terminal", "text-height", "text-width",
            "th", "th-large", "th-list", "thumb-tack", "thumbs-down", "thumbs-o-down", "thumbs-o-up", "thumbs-up",
            "ticket", "times", "times-circle", "times-circle-o", "tint", "toggle-down", "toggle-left", "toggle-right",
            "toggle-up", "trash-o", "tree", "trello", "trophy", "truck", "try", "tumblr", "tumblr-square",
            "turkish-lira", "twitter", "twitter-square", "umbrella", "underline", "undo", "university", "unlink",
            "unlock", "unlock-alt", "unsorted", "upload", "usd", "user", "user-md", "users", "video-camera",
            "vimeo-square", "vine", "vk", "volume-down", "volume-off", "volume-up", "warning", "wechat", "weibo",
            "weixin", "wheelchair", "windows", "won", "wordpress", "wrench", "xing", "xing-square", "yahoo", "yen",
            "youtube", "youtube-play", "youtube-square");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . $option . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_fontawesome_size_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("", "lg", "2x", "3x", "4x", "5x");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . $option . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_testimonial_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("normal", "banner");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_gmap_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("roadmap", "satellite", "hybrid", "terrain");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_view_mode_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("grid", "slider", 'menu');
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_posts_layout_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array( "default", "home_page", "home_page_v2", 'home_page_cameras', 'home_page_cosmetics', 'home_page_medic', 'home_page_wine');
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_products_layout_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("default", 'antique', 'architecture', 'computer4', 'fashion2', 'furniture', 'games_blue', 'games_green',
            'games_grey', 'games_orange', 'games_pink', 'holidays', 'medic_last_in_stock', 'products_grid', 'products_grid_flowers',
            'products_grid_sportwinter', 'products_grid_one_product_flowers','products_grid_with_carousel', 'shoes3_today_deals',
            'sport', 'today_deals', 'toys2_today_deals', 'footer_list');

        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_newsletter_layout_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("default", "gardentools", 'architecture', 'audio', 'bakery', 'books', 'carparts', 'ceramica',
                          'computer3', 'cosmetics2', 'cosmetics', 'exclusive', 'fashion2', 'fashion3', 'furniture', 'glamshop',
                          'lingerie', 'market', 'matrialarts', 'medic', 'military', 'naturalcosmetics', 'perfume', 'shoes3',
                          'spices', 'sport', 'sport2', 'sportwinter', 'wine');

        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_menu_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
        foreach ( $menus as $menu ) {
            $selected = '';
            if ( $menu->term_id == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . esc_attr($menu->term_id) . '"' . $selected
                . '>'. esc_html( $menu->name ) . '</option>';
        }

        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_products_type_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("latest", "bestseller", 'sale', 'featured');

        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_orderby_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("date", "price", "rand", "sales");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_order_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("desc", "asc");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_yes_no_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("yes", "no");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    function fastor_vc_blog_layout_field($settings, $value) {
        $param_line = '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value dropdown wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';

        $options = array("grid", "timeline", "large-alt", "medium-alt", "small-alt");
        foreach ( $options as $option ) {
            $selected = '';
            if ( $option == $value ) $selected = ' selected="selected"';
            $param_line .= '<option value="' . $option . '"' . $selected . '>' . ucwords($option) . '</option>';
        }
        $param_line .= '</select>';

        return $param_line;
    }

    $new_fields = array("layout_type", "posts_layout_type", "products_layout_type", 'newsletter_layout_type', 'menu_type', 'products_type', "text_transform", "title_size", "boolean", "line_pos", "align", "link_target",
        "fontawesome_icon", "fontawesome_size", "testimonial_type", "gmap_type", "view_mode", "orderby", "order", "yes_no",
        "blog_layout"
    );

    foreach ($new_fields as $new_field)
        vc_add_shortcode_param($new_field, 'fastor_vc_'.$new_field.'_field');

    $vc_shortcodes = array( "brands", "brand", "carousel", "carousel_item","filter_products", "filter_products_tab",'latest_posts', 'custom_block', 'menu','newsletter',
        "camera_slider", "camera_slide", 
        "sw_bestseller_products", "sw_featured_products", "sw_sale_products", "sw_latest_products", 'sw_custom_products', "bootstrap",
    );

    foreach ($vc_shortcodes as $shortcode)
        add_action('init', 'fastor_vc_shortcode_'.$shortcode);

    // remove element
    vc_remove_element('vc_images_carousel');
    vc_remove_element('vc_carousel');
    vc_remove_element('vc_widget_sidebar');
    vc_remove_element('vc_pie');
    vc_remove_element('vc_progress_bar');

    // add param
    $attributes = array(
        'type' => 'dropdown',
        'heading' => "Type",
        'param_name' => 'type',
        'value' => array("Default" => "default", "Custom" => "custom"),
        'description' => '',
        "admin_label" => true
    );
    vc_add_param('vc_tabs', $attributes);
}
