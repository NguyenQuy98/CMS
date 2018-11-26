<?php


/**
 * Class Name: wp_bootstrap_navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.4
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!class_exists('wp_bootstrap_navwalker')) {
    class wp_bootstrap_navwalker extends Walker_Nav_Menu {

      /**
         * @see Walker::start_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
        }

        /**
         * @see Walker::start_el()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param int $current_pagince Menu item ID.
         * @param object $args
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            /**
             * Dividers, Headers or Disabled
             * =============================
             * Determine whether the item is a Divider, Header, Disabled or regular
             * menu item. To prevent errors we use the strcasecmp() function to so a
             * comparison that is not case sensitive. The strcasecmp() function returns
             * a 0 if the strings are equal.
             */
            if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
                $output .= $indent . '<li role="presentation" class="divider">';
            } else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
                $output .= $indent . '<li role="presentation" class="divider">';
            } else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
                $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
            } else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
                $output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
            } else {

                $class_names = $value = '';

                $classes = empty( $item->classes ) ? array() : (array) $item->classes;

                $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

                if ( $args->has_children )
                    $class_names .= ' dropdown';

                if ( in_array( 'current-menu-item', $classes ) )
                    $class_names .= ' active';

                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


                $output .= $indent . '<li' . $value . $class_names .'>';

                $atts = array();
                $atts['title']  = ! empty( $item->title )    ? $item->title    : '';
                $atts['target'] = ! empty( $item->target )    ? $item->target    : '';
                $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn    : '';

                // If item has_children add atts to a.
                if ( $args->has_children && $depth === 0 ) {
                    $atts['href']           = '#';
                    $atts['data-toggle']    = 'dropdown';
                    $atts['data-hover']    = 'dropdown';
                    $atts['class']            = 'dropdown-toggle';
                } else {
                    $atts['href'] = ! empty( $item->url ) ? $item->url : '';
                }

                $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

                $attributes = '';
                foreach ( $atts as $attr => $value ) {
                    if ( ! empty( $value ) ) {
                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                    }
                }

                $item_output = $args->before;

                /*
                 * Glyphicons
                 * ===========
                 * Since the the menu item is NOT a Divider or Header we check the see
                 * if there is a value in the attr_title property. If the attr_title
                 * property is NOT null we apply it as the class name for the glyphicon.
                 */
                if ( ! empty( $item->attr_title ) )
                    $item_output .= '<a'. $attributes .'><span class="menu-icon glyphicon ' . esc_attr( $item->attr_title ) . '"></span>';
                else
                    $item_output .= '<a'. $attributes .'>';

                $item_output .= '<span class="menu-label">'. $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after .'</span>';
                $item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
                $item_output .= $args->after;

                $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
        }

        /**
         * Traverse elements to create list from elements.
         *
         * Display one element if the element doesn't have any children otherwise,
         * display the element and its children. Will only traverse up to the max
         * depth and no ignore elements under that depth.
         *
         * This method shouldn't be called directly, use the walk() method instead.
         *
         * @see Walker::start_el()
         * @since 2.5.0
         *
         * @param object $element Data object
         * @param array $children_elements List of elements to continue traversing.
         * @param int $max_depth Max depth to traverse.
         * @param int $depth Depth of current element.
         * @param array $args
         * @param string $output Passed by reference. Used to append additional content.
         * @return null Null on failure with no changes to parameters.
         */
        public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
            if ( ! $element )
                return;

            $id_field = $this->db_fields['id'];

            // Display this element.
            if ( is_object( $args[0] ) )
                $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }

        /**
         * Menu Fallback
         * =============
         * If this function is assigned to the wp_nav_menu's fallback_cb variable
         * and a manu has not been assigned to the theme location in the WordPress
         * menu manager the function with display nothing to a non-logged in user,
         * and will add a link to the WordPress menu manager if logged in as an admin.
         *
         * @param array $args passed from the wp_nav_menu function.
         *
         */
        public static function fallback( $args ) {
            if ( current_user_can( 'manage_options' ) ) {

                extract( $args );

                $fb_output = null;

                if ( $container ) {
                    $fb_output = '<' . $container;

                    if ( $container_id )
                        $fb_output .= ' id="' . $container_id . '"';

                    if ( $container_class )
                        $fb_output .= ' class="' . $container_class . '"';

                    $fb_output .= '>';
                }

                $fb_output .= '<ul';

                if ( $menu_id )
                    $fb_output .= ' id="' . $menu_id . '"';

                if ( $menu_class )
                    $fb_output .= ' class="' . $menu_class . '"';

                $fb_output .= '>';
                $fb_output .= '<li><a href="' . esc_url(admin_url( 'nav-menus.php' )) . '">Add a menu</a></li>';
                $fb_output .= '</ul>';

                if ( $container )
                    $fb_output .= '</' . $container . '>';

                echo  $fb_output;
            }
        }
    }
}

// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'fastor_add_custom_nav_fields' );

function fastor_add_custom_nav_fields( $menu_item ) {
   

    $menu_item->nolink = get_post_meta( $menu_item->ID, '_menuitem_nolink', true );
    $menu_item->hide = get_post_meta( $menu_item->ID, '_menuitem_hide', true );
    $menu_item->cols = get_post_meta( $menu_item->ID, '_menuitem_cols', true );
    $menu_item->tip_label = get_post_meta( $menu_item->ID, '_menuitem_tip_label', true );
    $menu_item->tip_color = get_post_meta( $menu_item->ID, '_menuitem_tip_color', true );
    $menu_item->tip_bg = get_post_meta( $menu_item->ID, '_menuitem_tip_bg', true );
    $menu_item->display_on_mobile = get_post_meta( $menu_item->ID, '_menuitem_display_on_mobile', true );
    $menu_item->display_submenu_on = get_post_meta( $menu_item->ID, '_menuitem_display_submenu_on', true );
    $menu_item->submenu_width = get_post_meta( $menu_item->ID, '_menuitem_submenu_width', true );
    $menu_item->menu_content_width = get_post_meta( $menu_item->ID, '_menuitem_menu_content_width', true );
    $menu_item->content_type = get_post_meta( $menu_item->ID, '_menuitem_content_type', true );
    $menu_item->icon_img = get_post_meta( $menu_item->ID, '_menuitem_icon_img', true );
    $menu_item->background_img = get_post_meta( $menu_item->ID, '_menuitem_background_img', true );
    $menu_item->background_position = get_post_meta( $menu_item->ID, '_menuitem_background_position', true );
    $menu_item->background_repeat = get_post_meta( $menu_item->ID, '_menuitem_background_repeat', true );
    $menu_item->background_size = get_post_meta( $menu_item->ID, '_menuitem_background_size', true );
    $menu_item->searchbar = get_post_meta( $menu_item->ID, '_menuitem_searchbar', true );

    if($menu_item->display_submenu_on == ''){
        $menu_item->display_submenu_on = 1;
    }
    if($menu_item->display_on_mobile == ''){
        $menu_item->display_on_mobile = 1;
    }


    return $menu_item;
}

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'fastor_update_custom_nav_fields', 10, 3 );

function fastor_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    $check = array('nolink', 'hide', 'cols', 'display_submenu_on', 'submenu_width', 'content_type', 'menu_content_width',
        'background_img', 'icon_img', 'background_position', 'background_size', 'background_repeat', 'display_on_mobile', 'tip_label', 'tip_color', 'tip_bg', 'searchbar');
    foreach ( $check as $key )
    {
        if (!isset($_POST['menu-item-'.$key][$menu_item_db_id])){
            if (!isset($args['menu-item-'.$key]))
                $value = "";
            else
                $value = $args['menu-item-'.$key];
        } else {
            $value = $_POST['menu-item-'.$key][$menu_item_db_id];
        }

        if(!add_post_meta( $menu_item_db_id, '_menuitem_'.$key, $value, true )){
            update_post_meta( $menu_item_db_id, '_menuitem_'.$key, $value );
        }
    }
}

// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', 'fastor_edit_walker', 10, 2 );

function fastor_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}

// Create HTML list of nav menu input items.
// Extend from Walker_Nav_Menu class
class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
    /**
     * @see Walker_Nav_Menu::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    /**
     * @see Walker_Nav_Menu::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $_wp_nav_menu_max_depth;

        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );
        ob_start();
        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }

        $classes = array(
            'menu-item menu-item-depth-' . esc_html($depth),
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( '%s (Invalid)', $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( '%s (Pending)', $item->title );
        }

        $title = empty( $item->label ) ? $title : $item->label;

        ?>
        <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><?php echo esc_html( $title ); ?></span>
                    <span class="item-controls">
                <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                <span class="item-order hide-if-js">
                    <a href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'move-up-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
                        ),
                        'move-menu_item'
                    );
                    ?>" class="item-move-up"><abbr title="Move up">&#8593;</abbr></a>
                    |
                    <a href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'move-down-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
                        ),
                        'move-menu_item'
                    );
                    ?>" class="item-move-down"><abbr title="Move down">&#8595;</abbr></a>
                </span>
                <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="Edit Menu Item" href="<?php
                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] )
                    ? esc_url(admin_url( 'nav-menus.php' ))
                    : add_query_arg( 'edit-menu-item', $item_id,
                        remove_query_arg( $removed_args, esc_url(admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
                ?>"><?php echo 'Edit Menu Item'; ?></a>
            </span>
                </dt>
            </dl>

            <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
                <?php if( 'custom' == $item->type ) : ?>
                    <p class="description description-wide">
                        <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
                            <?php echo 'URL'; ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url"
                                   name="menu-item-url[<?php echo esc_attr($item_id); ?>]"
                                   data-name="menu-item-url[<?php echo esc_attr($item_id); ?>]"
                                   value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-wide">
                    <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Navigation Label'; ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title"
                               name="menu-item-title[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-title[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description">
                    <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank"
                               name="menu-item-target[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-target[<?php echo esc_attr($item_id); ?>]"
                            <?php checked( $item->target, '_blank' ); ?> />
                        <?php echo 'Open link in a new window/tab'; ?>
                    </label>
                </p>
                <?php
                /* New fields insertion starts here */
                ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-nolink-<?php echo esc_attr($item_id); ?>">
                        <input type="checkbox" id="edit-menu-item-nolink-<?php echo esc_attr($item_id); ?>" class="code edit-menu-item-custom" value="nolink"
                               name="menu-item-nolink[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-nolink[<?php echo esc_attr($item_id); ?>]"
                            <?php checked( $item->nolink, 'nolink' ); ?> />
                        <?php echo "Don't link"; ?>
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-hide-<?php echo esc_attr($item_id); ?>">
                        <input type="checkbox" id="edit-menu-item-hide-<?php echo esc_attr($item_id); ?>" class="code edit-menu-item-custom" value="hide"
                               name="menu-item-hide[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-hide[<?php echo esc_attr($item_id); ?>]"
                            <?php checked( $item->hide, 'hide' ); ?> />
                        <?php echo "Don't show a link label"; ?>
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-tip_label-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Tip Label'; ?><br />
                        <input type="text" id="edit-menu-item-tip_label-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-tip_label"
                               name="menu-item-tip_label[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-tip_label[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr( $item->tip_label ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-tip_color-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Tip Text Color'; ?><br />
                        <input type="text" id="edit-menu-item-tip_color-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-tip_color"
                               name="menu-item-tip_color[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-tip_color[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr( $item->tip_color ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-tip_bg-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Tip BG Color'; ?><br />
                        <input type="text" id="edit-menu-item-tip_bg-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-tip_bg"
                               name="menu-item-tip_bg[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-tip_bg[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr( $item->tip_bg ); ?>" />
                    </label>
                </p>
                <div style="clear:both;"></div><br>
                <p class="description description-thin">
                    <label for="edit-menu-item-searchbar-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Use as searchbar'; ?><br />
                        <select id="edit-menu-item-searchbar-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-searchbar[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-searchbar[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="0" <?php if(esc_attr($item->searchbar) == "0"){echo 'selected="selected"';} ?>><?php echo 'No' ?></option>
                            <option value="1" <?php if(esc_attr($item->searchbar) == "1"){echo 'selected="selected"';} ?>><?php echo 'Yes' ?></option>
                        </select>
                    </label>
                </p>
                <div style="clear:both;"></div><br>
                <p class="description description-thin">
                    <label for="edit-menu-item-display_on_mobile-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Display on mobile'; ?><br />
                        <select id="edit-menu-item-display_on_mobile-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-display_on_mobile[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-display_on_mobile[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="1" <?php if(esc_attr($item->display_on_mobile) == "1"){echo 'selected="selected"';} ?>><?php echo 'Yes' ?></option>
                            <option value="2" <?php if(esc_attr($item->display_on_mobile) == "2"){echo 'selected="selected"';} ?>><?php echo 'No' ?></option>
                        </select>
                    </label>
                </p>
                <div style="clear:both;"></div>
                <p class="description description-thin">
                    <label for="edit-menu-item-display_submenu_on-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Display submenu on'; ?><br />
                        <select id="edit-menu-item-display_on_mobile-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-display_submenu_on[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-display_submenu_on[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="1" <?php if(esc_attr($item->display_submenu_on) == "1"){echo 'selected="selected"';} ?>><?php echo 'Hover' ?></option>
                            <option value="2" <?php if(esc_attr($item->display_submenu_on) == "2"){echo 'selected="selected"';} ?>><?php echo 'Click (only 1 level)' ?></option>
                        </select>
                    </label>
                </p>


                <div style="clear:both;"></div>
                <p class="description description-thin">
                    <label for="edit-menu-item-submenu_width-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Submenu width'; ?><br />
                        <input type="text" id="edit-menu-item-tip_bg-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-tip_bg"
                               name="menu-item-submenu_width[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-submenu_width[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr( $item->submenu_width ); ?>" />
                    </label>
                    <?php echo 'for example 100% or 250px'; ?>
                </p>

                <div style="clear:both;"></div>
                <p class="description description-thin">
                    <label for="edit-menu-item-content_type-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Content type'; ?><br />
                        <select id="edit-menu-item-content_type-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-content_type[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-content_type[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="0" <?php if(esc_attr($item->content_type) == "0" || ($item->content_type == '' && $depth > 0)){echo 'selected="selected"';} ?>><?php echo 'Menu' ?></option>
                            <option value="2" <?php if(esc_attr($item->content_type) == "2"){echo 'selected="selected"';} ?>><?php echo 'Custom Block' ?></option>
                        </select>
                    </label>
                </p>
                <div style="clear:both;"></div>
                <p class="description description-thin">
                    <label for="edit-menu-item-menu_content_width-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Menu content width'; ?><br />
                        <select id="edit-menu-item-menu_content_width-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-menu_content_width[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-menu_content_width[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="1" <?php if(esc_attr($item->menu_content_width) == "1"){echo 'selected="selected"';} ?>><?php echo '1/12' ?></option>
                            <option value="2" <?php if(esc_attr($item->menu_content_width) == "2"){echo 'selected="selected"';} ?>><?php echo '2/12' ?></option>
                            <option value="3" <?php if(esc_attr($item->menu_content_width) == "3"){echo 'selected="selected"';} ?>><?php echo '3/12' ?></option>
                            <option value="4" <?php if(esc_attr($item->menu_content_width) == "4"){echo 'selected="selected"';} ?>><?php echo '4/12' ?></option>
                            <option value="5" <?php if(esc_attr($item->menu_content_width) == "5"){echo 'selected="selected"';} ?>><?php echo '5/12' ?></option>
                            <option value="6" <?php if(esc_attr($item->menu_content_width) == "6"){echo 'selected="selected"';} ?>><?php echo '6/12' ?></option>
                            <option value="7" <?php if(esc_attr($item->menu_content_width) == "7"){echo 'selected="selected"';} ?>><?php echo '7/12' ?></option>
                            <option value="8" <?php if(esc_attr($item->menu_content_width) == "8"){echo 'selected="selected"';} ?>><?php echo '8/12' ?></option>
                            <option value="9" <?php if(esc_attr($item->menu_content_width) == "9"){echo 'selected="selected"';} ?>><?php echo '9/12' ?></option>
                            <option value="10" <?php if(esc_attr($item->menu_content_width) == "10"){echo 'selected="selected"';} ?>><?php echo '10/12' ?></option>
                            <option value="11" <?php if(esc_attr($item->menu_content_width) == "11"){echo 'selected="selected"';} ?>><?php echo '11/12' ?></option>
                            <option value="12" <?php if(esc_attr($item->menu_content_width) == "12" || !esc_attr($item->menu_content_width)){echo 'selected="selected"';} ?>><?php echo '12/12' ?></option>
                        </select>
                    </label>
                </p>


                <p class="description description-wide">
                    <label for="edit-menu-item-background_img-<?php echo $item_id; ?>">
                        <?php echo 'Background Image (only wide)'; ?><br />
                        <input type="text" id="edit-menu-item-background_img-<?php echo $item_id; ?>" class="widefat code edit-menu-item-background_img"
                            <?php if (esc_attr( $item->background_img )) : ?>
                                name="menu-item-background_img[<?php echo $item_id; ?>]"
                            <?php endif; ?>
                               data-name="menu-item-background_img[<?php echo $item_id; ?>]"
                               value="<?php echo esc_attr( $item->background_img ); ?>" />
                        <br/>
                        <input class="button_upload_image button" id="edit-menu-item-background_img-<?php echo $item_id; ?>" type="button" value="Upload Image" />&nbsp;
                <input class="button_remove_image button" id="edit-menu-item-background_img-<?php echo $item_id; ?>" type="button" value="Remove Image" />
                </label>
                </p>


                <div style="clear:both;"></div>

                <p class="description description-thin">
                    <label for="edit-menu-item-background_position-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Background position'; ?><br />
                        <select id="edit-menu-item-background_position-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-background_position[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-background_position[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="top left" <?php if(esc_attr($item->background_position) == "top left" || ($item->background_position == '' && $depth > 0)){echo 'selected="selected"';} ?>><?php echo 'Top left' ?></option>
                            <option value="top center" <?php if(esc_attr($item->background_position) == "top center"){echo 'selected="selected"';} ?>><?php echo 'Top center' ?></option>
                            <option value="top right" <?php if(esc_attr($item->background_position) == "top right"){echo 'selected="selected"';} ?>><?php echo 'Top right' ?></option>
                            <option value="bottom left" <?php if(esc_attr($item->background_position) == "bottom left"){echo 'selected="selected"';} ?>><?php echo 'Bottom left' ?></option>
                            <option value="bottom center" <?php if(esc_attr($item->background_position) == "bottom center"){echo 'selected="selected"';} ?>><?php echo 'Bottom center' ?></option>
                            <option value="bottom right" <?php if(esc_attr($item->background_position) == "bottom right"){echo 'selected="selected"';} ?>><?php echo 'Bottom right' ?></option>
                            <option value="center" <?php if(esc_attr($item->background_position) == "center"){echo 'selected="selected"';} ?>><?php echo 'Center' ?></option>
                        </select>
                    </label>
                </p>
                <div style="clear:both;"></div>
                <p class="description description-thin">
                    <label for="edit-menu-item-background_repeat-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Background repeat'; ?><br />
                        <select id="edit-menu-item-background_repeat-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-background_repeat[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-background_repeat[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="no-repeat" <?php if(esc_attr($item->background_repeat) == "no-repeat" || ($item->background_repeat == '' && $depth > 0)){echo 'selected="selected"';} ?>><?php echo 'No repeat' ?></option>
                            <option value="repeat" <?php if(esc_attr($item->background_repeat) == "repeat"){echo 'selected="selected"';} ?>><?php echo 'Repeat' ?></option>
                            <option value="repeat-x" <?php if(esc_attr($item->background_repeat) == "repeat-x"){echo 'selected="selected"';} ?>><?php echo 'Repeat-x' ?></option>
                            <option value="repeat-y" <?php if(esc_attr($item->background_repeat) == "repeat-y"){echo 'selected="selected"';} ?>><?php echo 'Repeat-y' ?></option>
                        </select>
                    </label>
                </p>
                <div style="clear:both;"></div>
                <p class="description description-thin">
                    <label for="edit-menu-item-background_size-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Background size'; ?><br />
                        <select id="edit-menu-item-background_size-<?php echo esc_attr($item_id); ?>"
                                name="menu-item-background_size[<?php echo esc_attr($item_id); ?>]"
                                data-name="menu-item-background_size[<?php echo esc_attr($item_id); ?>]"
                        >
                            <option value="inherit" <?php if(esc_attr($item->background_size) == "inherit" || ($item->background_size == '' && $depth > 0)){echo 'selected="selected"';} ?>><?php echo 'Inherit' ?></option>
                            <option value="cover" <?php if(esc_attr($item->background_size) == "cover"){echo 'selected="selected"';} ?>><?php echo 'Cover' ?></option>
                            <option value="contain" <?php if(esc_attr($item->background_size) == "contain"){echo 'selected="selected"';} ?>><?php echo 'Contain' ?></option>
                        </select>
                    </label>
                </p>
                <div style="clear:both;"></div>

                <p class="description description-wide">
                    <label for="edit-menu-item-icon_img-<?php echo $item_id; ?>">
                        <?php echo 'Icon (image)'; ?><br />
                        <input type="text" id="edit-menu-item-icon_img-<?php echo $item_id; ?>" class="widefat code edit-menu-item-icon_img"
                            <?php if (esc_attr( $item->icon_img )) : ?>
                                name="menu-item-icon_img[<?php echo $item_id; ?>]"
                            <?php endif; ?>
                               data-name="menu-item-icon_img[<?php echo $item_id; ?>]"
                               value="<?php echo esc_attr( $item->icon_img ); ?>" />
                        <br/>
                        <input class="button_upload_image button" id="edit-menu-item-icon_img-<?php echo $item_id; ?>" type="button" value="Upload Image" />&nbsp;
                        <input class="button_remove_image button" id="edit-menu-item-icon_img-<?php echo $item_id; ?>" type="button" value="Remove Image" />
                    </label>
                </p>
                <?php
                /* New fields insertion ends here */
                ?><div style="clear:both;"></div><br/>
                <p class="description description-wide">
                    <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'Icon'; ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title"
                               name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                    ex. flag flag-us, fa fa-home
                </p>
                <div style="clear:both;"></div>
                <p class="description description-thin">
                    <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
                        <?php echo 'CSS Classes (optional)'; ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes"
                               name="menu-item-classes[<?php echo esc_attr($item_id); ?>]"
                               data-name="menu-item-classes[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <div style="clear:both;"></div>
                <div class="menu-item-actions description-wide submitbox">
                    <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( 'Original: %s', '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php echo 'Remove'; ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, esc_url(admin_url( 'nav-menus.php' )) ) ) );
                    ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php echo 'Cancel'; ?></a>
                </div>
                <div style="clear:both;"></div>


                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        </li>
        <?php
        $output .= ob_get_clean();
    }
}

/* Top Main Menu */
if (!class_exists('fastor_main_menuwalker')) {
    class fastor_main_menuwalker extends Walker_Nav_Menu
    {
        private $submenu_links_status = false;
        private $item_lvl = array();

        // add classes to ul sub menus
        function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
        {
            $id_field = $this->db_fields['id'];

            if (is_object($args[0])) {
                $args[0]->has_children = !empty($children_elements[$element->$id_field]);
            }
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }

        // add popup class to ul sub-menus

        function start_lvl(&$output, $depth = 0, $args = array())
        {

            $this->item_lvl[$depth]['title'] = $args->title;
            $this->item_lvl[$depth]['submenu_width'] = $args->submenu_width;
            $this->item_lvl[$depth]['content_type'] = $args->content_type;
            $this->item_lvl[$depth]['display_submenu_on'] = $args->display_submenu_on;
            $this->item_lvl[$depth]['has_children'] = $args->has_children;

            $indent = str_repeat("\t", $depth);
            $submenu_width = "200px";

            if ($args->submenu_width) {
                $submenu_width = esc_attr($args->submenu_width);
            }
            $submenu_class = '';
            if($submenu_width == '100%'){
                $submenu_class = 'full-width-sub-menu';
            }

            if ($depth == 0) {
                $output .= "\n$indent<div class=\"sub-menu $submenu_class\" style=\"width: $submenu_width\">\n";
                $output .= "\n". $indent . '<div class="content"
                 style="'. ($args->background_img ? "background-image: url('". esc_url($args->background_img) ."');
                  background-repeat: ".esc_attr($args->background_repeat) .";
                  background-size: ".esc_attr($args->background_size).";
                  background-position: ".esc_attr($args->background_position) : '') .'">'. "\n";
                $output .= "\n$indent<span class=\"arrow\"></span>\n";
            }
            if ($args->has_children && $depth  == 0) {

                if($args->content_type != 2) {
                    $output .= "\n$indent<div class=\"row\">\n";
                    $output .= '<div class="col-sm-'. esc_attr($args->menu_content_width) .' ' . ($args->display_on_mobile == 2 ? 'mobile-disabled' : 'mobile-enabled') . '">';
                    $output .= "\n$indent<div class=\"row\">\n";
                    $output .= "\n$indent<div class=\"col-sm-12". ' ' .esc_attr(implode(' ', $args->classes)) . ' ' . ($args->display_submenu_on == 2 ? 'hover-menu click-menu' : 'hover-menu') . "\">\n";
                    $output .= "\n$indent<div class=\"menu\">\n";
                }


                if($args->content_type != 2){
                    $output .= "\n$indent<ul>\n";
                }

            }

            if ($depth >= 1 && $args->content_type == 0) {

                $output .= "$indent<ul style=\"width: $submenu_width\" >\n";

            }
        }

        function end_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);

            if ($depth >= 1 && $this->item_lvl[$depth]['content_type'] == 0) {
                $output .= "$indent</ul>\n";

            }
                if ($this->item_lvl[$depth]['has_children'] && $depth == 0) {

                    if($this->item_lvl[$depth]['content_type'] != 2){
                        $output .= "\n$indent</ul>\n";
                    }

                if($this->item_lvl[$depth]['content_type'] != 2) {
                    $output .= "\n$indent</div>\n";
                    $output .= "\n$indent</div>\n";
                    $output .= "\n$indent</div>\n";
                    $output .= "\n$indent</div>\n";
                    $output .= "\n$indent</div>\n";

                }


            }
            if ($depth == 0) {
                $output .= "\n$indent</div>\n";
                $output .= "\n$indent</div>\n";
            }



        }

        // add main/sub classes to li's and links
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            global $wp_query;


            $args->submenu_width = $item->submenu_width;
            $args->menu_content_width = $item->menu_content_width;
            $args->content_type = $item->content_type;
            $args->icon_img = $item->icon_img;
            $args->background_img = $item->background_img;
            $args->background_position = $item->background_position;
            $args->background_repeat = $item->background_repeat;
            $args->background_size = $item->background_size;
            $args->display_submenu_on = $item->display_submenu_on;
            $args->display_on_mobile = $item->display_on_mobile;
            $args->classes = $item->classes;
            $args->title = $item->title;


            if($item->content_type != 1 || $depth == 0){


                $sub = "";
                $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
                if ($depth == 0 && ($args->has_children || $item->content_type == 2)) {
                    $sub = ' with-sub-menu ';

                    if ($item->display_submenu_on == 2) {
                        $sub .= ' click ';
                    } else {
                        $sub .= ' hover ';
                    }

                }

                if ($depth >= 1 && $args->has_children)
                    $sub = ' with-submenu ';


                $active = "";


                // passed classes
                $classes = empty($item->classes) ? array() : (array)$item->classes;

                if($item->searchbar){
                    $classes[] = 'search';
                }


                $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

                $menu_type = "";


                if ($depth == 0) {
                    $menu_type = " narrow";
                }


                $current_a = "";

                $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->title) . '"' : '';
                $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
                $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
                $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

                if (($item->current && $depth == 0) || ($item->current_item_ancestor && $depth == 0))
                    $current_a .= ' current ';

                if(!$this->submenu_links_status) {
                    $current_a .= 'main-menu ';
                }

                $attributes .= ' class="' . $current_a . ' '.$sub.'"';

//                if($depth == 0 && $item->background_img && $item->content_type == 0){
//                    $attributes .= 'style="'. ($item->background_img ? "background-image: url('". $args->background_img ."'); background-repeat: $item->background_repeat; background-position: $item->background_position" : '') .'"';
//                }

                $item_output = $args->before;

                if ($item->nolink == "") {
                    $item_output .= '<a' . $attributes . '>';
                } else {
                    $item_output .= '<a href="#">';
                }

                if($depth == 0){
                    $item_output .= '<span><strong>';
                }

                if($args->icon_img){
                    $item_output .= '<img src="'. $args->icon_img .'" alt="" />';
                }

                $item_output .= $args->link_before;

                if (!empty($item->attr_title))
                    $item_output .= '<span class="menu-icon ' . esc_attr($item->attr_title) . '"></span>';

                if ($item->hide == "") {
                    $item_output .= apply_filters('the_title', $item->title, esc_html($item->ID));
                }



                $item_output .= $args->link_after;

                if ($item->tip_label) {
                    $item_style = '';
                    if ($item->tip_color)
                        $item_style .= 'color:' . esc_html($item->tip_color) . ';';
                    if ($item->tip_bg)
                        $item_style .= 'border-color:' . esc_html($item->tip_bg) . '; background:' . esc_html($item->tip_bg) . ';';
                    $item_output .= '<span class="megamenu-label" style="' . esc_html($item_style) . '"><span style="' . esc_html($item_style) . '"></span>' . $item->tip_label . '</span>';
                }



                if($depth == 0){
                    $item_output .= '</strong></span>';
                }






                if ($item->nolink == "") {
                    $item_output .= '</a>';
                } else {
                    $item_output .= '</a>';
                }


                if ($depth >= 1 && $args->has_children) {
                    $item_output .= '<div class="open-categories"></div><div class="close-categories"></div>';
                }

                $item_output .= $args->after;


                if ($item->object != 'custom_block') {
                    $output .= $indent . '<li class="' . esc_attr($class_names) . ' ' . esc_attr($active)  . $menu_type  . ($depth == 0 ? $sub : '').'">';

                    if ($depth == 0 && ($args->has_children)) {
                        $output .= '<span class="close-menu"></span><span class="open-menu"></span>';
                    }


                    if($item->searchbar){
                        $item_output = fastor_search_form_get_content();
                    }

                   $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);


                }


                if($item->object == 'custom_block'){
                    if($depth == 0){
                        $output .= $indent . '<li class="' . esc_attr($class_names) . ' ' . esc_attr($active)  . esc_attr($menu_type)  . ($depth == 0 ? $sub : '').'">'.
                            do_shortcode('[custom_block id="'.esc_attr($item->object_id).'"]');

                    }else{
                        $output .=
                            '<div class="row">
                                <div class="col-sm-'.esc_attr($item->menu_content_width).' ' .($item->display_on_mobile == 2 ? 'mobile-disabled' : 'mobile-enabled') . '">';
                        $output .= do_shortcode('[custom_block id="'.esc_attr($item->object_id).'"]');
                        $output .= '</div></div>';
                    }

                }


            }

        }


        public function end_el(&$output, $item, $depth = 0, $args = array())
        {
            if($item->content_type != 2 || $depth == 0 || ($item->object == 'custom_block' && $depth == 0)){

                $indent = ($depth) ? str_repeat("\t", $depth) : '';
                $output .= "</li>\n";
            }


        }
    }
}

class Fastor_WC_Blog_Cat_List_Walker extends Walker_Category {

    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of category. Used for tab indentation.
     * @param array $args Will only append content if style argument value is 'list'.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' != $args['style'] )
            return;

        $indent = str_repeat("\t", $depth);
        $output .= "$indent<ul class='children'>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of category. Used for tab indentation.
     * @param array $args Will only append content if style argument value is 'list'.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        if ( 'list' != $args['style'] )
            return;

        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     * @access public
     *
     * @see Walker::start_el()
     *
     * @param string $output   Passed by reference. Used to append additional content.
     * @param object $category Category data object.
     * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int    $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );

        $collapsed = false;

        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }

        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';


        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }

        $css_classes = array();

        if ( 'list' == $args['style'] ) {


            $css_classes = array(
                'cat-item',
                'cat-item-' . esc_attr($category->term_id),
            );

            if (!empty($args['current_category'])) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms($category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ));

                foreach ($_current_terms as $_current_term) {
                    if ($category->term_id == $_current_term->term_id) {
                        $css_classes[] = 'current-cat active';
                        $collapsed = true;
                    } elseif ($category->term_id == $_current_term->parent) {
                        $css_classes[] = 'current-cat-parent active';
                        $collapsed = true;
                    }
                    while ($_current_term->parent) {
                        if ($category->term_id == $_current_term->parent) {
                            $css_classes[] = 'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term($_current_term->parent, $category->taxonomy);
                    }
                }
            }
        }

        /**
         * Filters the list of CSS classes to include with each category in the list.
         *
         * @since 4.2.0
         *
         * @see wp_list_categories()
         *
         * @param array  $css_classes An array of CSS classes to be applied to each list item.
         * @param object $category    Category data object.
         * @param int    $depth       Depth of page, used for padding.
         * @param array  $args        An array of wp_list_categories() arguments.
         */

        $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

        $link .=  ' class="' . $css_classes . '"';

        $link .= '>' . $cat_name;

        if ( ! empty( $args['show_count'] ) ) {
            $link .= ' <span class="count">(' . number_format_i18n( $category->count ) . ')</span>';
        }

        $link .= '</a>';

        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';

            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }

            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

            if ( empty( $args['feed'] ) ) {
                $alt = ' alt="' . sprintf(esc_html__( 'Feed for all posts filed under %s', 'fastor' ), $cat_name ) . '"';
            } else {
                $alt = ' alt="' . $args['feed'] . '"';
                $name = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : esc_html($args['title']);
            }

            $link .= '>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . esc_url($args['feed_image']) . "' " . ' />';
            }
            $link .= '</a>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }


        if ( 'list' == $args['style'] ) {



            $output .= "\t<li";

            $output .= ">$link\n";

            if ( $args['has_children'] && $args['hierarchical'] ) {

            $output .= '
                <span class="head">
                <a class="accordion-toggle'.(!$collapsed ? ' collapsed' : '').'" data-toggle="collapse" data-parent="#accordion-category" href="#category'.$category->term_id.'">
                <span class="plus">+</span><span class="minus">-</span>
                </a>
                </span>
                <div id="category'.esc_attr($category->term_id).'" class="panel-collapse collapse '.($args['current_category'] == $category->term_id || ($collapsed) ? ' in' : '').'" style="clear:both">
                ';
            }

        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . esc_html($args['separator']) . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
        

    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of category. Not used.
     * @param array $args Only uses 'list' for whether should append to output.
     */
    public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }

}

if ( class_exists( 'Woocommerce' ) ) {
 
include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

class Fastor_WC_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker {
    public $tree_type = 'product_cat';
    public $db_fields = array ( 'parent' => 'parent', 'id' => 'term_id', 'slug' => 'slug' );


	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args Will only append content if style argument value is 'list'.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args Will only append content if style argument value is 'list'.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category in reference to parents.
	 * @param integer $current_object_id
	 */
	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$output .= '<li class="panel cat-item cat-item-' . $cat->term_id;

		$output .=  '"><a href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '" class="';
		
        if ( $args['current_category'] == $cat->term_id ) {
			$output .= ' active current-cat';
		}

		if ( $args['has_children'] && $args['hierarchical'] ) {
			$output .= ' cat-parent';
		}

		if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
			$output .= ' active current-cat-parent';
		}
        
        $output .=  '">'.esc_html($cat->name);

		if ( $args['show_count'] ) {
			$output .= ' <span class="count">(' . esc_html($cat->count) . ')</span>';
		}

        $output .=  '</a>';
        
        if ( $args['has_children'] && $args['hierarchical'] ) {
            
            $output .= '
                <span class="head">
                <a class="accordion-toggle'.($args['current_category'] != $cat->term_id && !($args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'])) ? ' collapsed' : '').'" data-toggle="collapse" data-parent="#accordion-category" href="#category'.$cat->term_id.'">
                <span class="plus">+</span><span class="minus">-</span>
                </a>
                </span>
                <div id="category'.$cat->term_id.'" class="panel-collapse collapse '.($args['current_category'] == $cat->term_id || ($args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors']))? ' in' : '').'" style="clear:both">
                ';
        }
        
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Not used.
	 * @param array $args Only uses 'list' for whether should append to output.
	 */
	public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

}

}

