<?php

function fastor_check_theme_options() {
    // check default options
    global $fastor_settings;
    ob_start();
    include(get_template_directory().'/admin/theme_options/default_options.php');
    $options = ob_get_clean();
    $fastor_default_settings = json_decode($options, true);
    foreach ($fastor_default_settings as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $key1 => $value1) {
                if ($key1 != 'google' && (!isset($fastor_settings[$key][$key1]) || !$fastor_settings[$key][$key1])) {
                    $fastor_settings[$key][$key1] = $fastor_default_settings[$key][$key1];
                }
            }
        } else {
            if (!isset($fastor_settings[$key])) {
                $fastor_settings[$key] = $fastor_default_settings[$key];
            }
        }
    }
    return $fastor_settings;
}



function fastor_options_header_types() {
    return array(
        '1' => array('alt' => 'Header Type 1', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_01.jpg'),
        '2' => array('alt' => 'Header Type 2', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_02.jpg'),
        '3' => array('alt' => 'Header Type 3', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_03.jpg'),
        '4' => array('alt' => 'Header Type 4', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_04.jpg'),
        '5' => array('alt' => 'Header Type 5', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_05.jpg'),
        '6' => array('alt' => 'Header Type 6', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_06.jpg'),
        '7' => array('alt' => 'Header Type 7', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_07.jpg'),
        '8' => array('alt' => 'Header Type 8', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_08.jpg'),
        '9' => array('alt' => 'Header Type 9', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_09.jpg'),
        '10' => array('alt' => 'Header Type 10', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_10.jpg'),
        '11' => array('alt' => 'Header Type 11', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_11.jpg'),
        '12' => array('alt' => 'Header Type 12', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_12.jpg'),
        '13' => array('alt' => 'Header Type 13', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_13.jpg'),
        '14' => array('alt' => 'Header Type 14', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_14.jpg'),
        '15' => array('alt' => 'Header Type 15', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_15.jpg'),
        '16' => array('alt' => 'Header Type 16', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_16.jpg'),
        '17' => array('alt' => 'Header Type 17', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_17.jpg'),
		
		'18' => array('alt' => 'Header Type 18', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_18.jpg'),
        'side' => array('alt' => 'Header Type(Side Navigation)', 'img' => get_template_directory_uri() . '/admin/theme_options/headers/header_side.jpg'),
    );
}
function fastor_options_footer_types() {
    return array(
        '1' => array('alt' => 'Footer Type 1', 'img' => get_template_directory_uri() . '/admin/theme_options/footers/footer_01.jpg'),
        '2' => array('alt' => 'Footer Type 2', 'img' => get_template_directory_uri() . '/admin/theme_options/footers/footer_02.jpg'),
        '3' => array('alt' => 'Footer Type 3', 'img' => get_template_directory_uri() . '/admin/theme_options/footers/footer_03.jpg')
    );
}
function fastor_demo_filters() {
    return array(
        '*' => 'All',
        'beauty' => 'Beauty',
        'electronics' => 'Electronics',
        'fashion' => 'Fashion',
        'food' => 'Food',
        'homefurniture' => 'Home & Furniture',
        'toolsparts' => 'Tools & Parts',
        'other' => 'Other',
    );
}
function fastor_demo_types() {
    return array(
        'default' => array(
            'alt' => 'Default', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/default.png', 'filter' => 'fashion'
        ),
        'default2' => array(
            'alt' => 'Default v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/default2.png', 'filter' => 'fashion'
        ),
        'fullwidth' => array(
            'alt' => 'Default Full Width', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/default_full_width.png', 'filter' => 'fashion'
        ),
        'stationery' => array(
            'alt' => 'Stationery', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/stationery.png', 'filter' => 'homefurniture other'
        ),
        'stationery2' => array(
            'alt' => 'Stationery2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/stationery2.png', 'filter' => 'homefurniture other'
        ),
        'petshop' => array(
            'alt' => 'Petshop', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/petshop.png', 'filter' => 'other food'
        ),
        'antique' => array(
            'alt' => 'Antique', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/antique.png', 'filter' => 'other'
        ),
        'architecture' => array(
            'alt' => 'Architecture', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/architecture.png', 'filter' => 'homefurniture'
        ),
        'bakery' => array(
            'alt' => 'Bakery', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/bakery.png', 'filter' => 'food'
        ),
        'barber' => array(
            'alt' => 'Barber', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/barber.png', 'filter' => 'beauty'
        ),
        'books' => array(
            'alt' => 'Books', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/books.png', 'filter' => 'other'
        ),
        'cameras' => array(
            'alt' => 'Cameras', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/cameras.png', 'filter' => 'electronics'
        ),
        'carparts' => array(
            'alt' => 'Car Parts', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/carparts.png', 'filter' => 'toolsparts'
        ),
        'carparts2' => array(
            'alt' => 'Car Parts v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/carparts2.png', 'filter' => 'toolsparts'
        ),
        'ceramica' => array(
            'alt' => 'Ceramica', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/ceramica.png', 'filter' => 'homefurniture'
        ),
        'coffeetea' => array(
            'alt' => 'Coffee & Tea', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/coffeetea.png', 'filter' => 'food'
        ),
        'computer' => array(
            'alt' => 'Computer', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/computer.png', 'filter' => 'electronics'
        ),
        'computer2' => array(
            'alt' => 'Computer v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/computer2.png', 'filter' => 'electronics'
        ),
        'computer3' => array(
            'alt' => 'Computer v3', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/computer3.png', 'filter' => 'electronics'
        ),
        'computer4' => array(
            'alt' => 'Computer v4', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/computer4.png', 'filter' => 'electronics'
        ),
        'computer5' => array(
            'alt' => 'Computer v5', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/computer5.png', 'filter' => 'electronics'
        ),
        'computer6' => array(
            'alt' => 'Computer v6', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/computer6.png', 'filter' => 'electronics'
        ),
        'cosmetics' => array(
            'alt' => 'Cosmetics', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/cosmetics.png', 'filter' => 'beauty'
        ),
        'cosmetics2' => array(
            'alt' => 'Cosmetics v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/cosmetics2.png', 'filter' => 'beauty'
        ),
        'exclusive' => array(
            'alt' => 'Exclusive', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/exclusive.png', 'filter' => 'beauty'
        ),
        'fashion2' => array(
            'alt' => 'Fashion v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/fashion2.png', 'filter' => 'fashion'
        ),
        'fashion3' => array(
            'alt' => 'Fashion v3', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/fashion3.png', 'filter' => 'fashion'
        ),
        'fashion4' => array(
            'alt' => 'Fashion v4', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/fashion4.png', 'filter' => 'fashion'
        ),
        'fashion5' => array(
            'alt' => 'Fashion v5', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/fashion5.png', 'filter' => 'fashion'
        ),
        'fashionsimple' => array(
            'alt' => 'Fashion Simple', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/fashionsimple.png', 'filter' => 'fashion'
        ),
        'games' => array(
            'alt' => 'Games', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/games.png', 'filter' => 'electronics'
        ),
        'games2' => array(
            'alt' => 'Games v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/games2.png', 'filter' => 'electronics'
        ),
        'games3' => array(
            'alt' => 'Games v3', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/games3.png', 'filter' => 'electronics'
        ),
        'gardentools' => array(
            'alt' => 'Garden', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/gardentools.png', 'filter' => 'homefurniture toolsparts'
        ),
        'gardentools2' => array(
            'alt' => 'Garden v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/gardentools2.png', 'filter' => 'homefurniture toolsparts'
        ),
        'glamshop' => array(
            'alt' => 'Glamshop', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/glamshop.png', 'filter' => 'fashion'
        ),
        'grocery' => array(
            'alt' => 'Grocery', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/grocery.png', 'filter' => 'food'
        ),
        'jewelry' => array(
            'alt' => 'Jewelry', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/jewelry.png', 'filter' => 'fashion'
        ),
        'jewelry2' => array(
            'alt' => 'Jewelry v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/jewelry2.png', 'filter' => 'fashion'
        ),
        'jewelryblack' => array(
            'alt' => 'Jewelry Black', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/jewelryblack.png', 'filter' => 'fashion'
        ),
        'jewelryblack2' => array(
            'alt' => 'Jewelry Black v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/jewelryblack2.png', 'filter' => 'fashion'
        ),
        'market' => array(
            'alt' => 'Market', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/market.png', 'filter' => 'electornics'
        ),
        'medic' => array(
            'alt' => 'Medic', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/medic.png', 'filter' => 'other'
        ),
        'military' => array(
            'alt' => 'Military', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/military.png', 'filter' => 'other'
        ),
        'naturalcosmetics' => array(
            'alt' => 'Natural cosmetics', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/naturalcosmetics.png', 'filter' => 'beauty'
        ),
        'perfume' => array(
            'alt' => 'Perfumes', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/perfume.png', 'filter' => 'beauty'
        ),
        'shoes' => array(
            'alt' => 'Shoes', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/shoes.png', 'filter' => 'fashion'
        ),
        'shoes2' => array(
            'alt' => 'Shoes v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/shoes2.png', 'filter' => 'fashion'
        ),
        'shoes3' => array(
            'alt' => 'Shoes v3', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/shoes3.png', 'filter' => 'fashion'
        ),
        'spices' => array(
            'alt' => 'Spices', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/spices.png', 'filter' => 'food'
        ),
        'sport' => array(
            'alt' => 'Sport', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/sport.png', 'filter' => 'fashion other'
        ),
        'sport2' => array(
            'alt' => 'Sport v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/sport2.jpg', 'filter' => 'fashion other'
        ),
        'sportwinter' => array(
            'alt' => 'Sport Winter', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/sportwinter.png', 'filter' => 'other'
        ),
        'tools' => array(
            'alt' => 'Tools', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/tools.png', 'filter' => 'toolsparts'
        ),
        'tools2' => array(
            'alt' => 'Tools v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/tools2.jpg', 'filter' => 'toolsparts'
        ),
        'toys' => array(
            'alt' => 'Toys', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/toys.png', 'filter' => 'homefurniture'
        ),
        'toys2' => array(
            'alt' => 'Toys v2', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/toys2.png', 'filter' => 'homefurniture'
        ),
        'wine' => array(
            'alt' => 'Wine', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/wine.png', 'filter' => 'other'
        ),
        'cleaning' => array(
            'alt' => 'Cleaning', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/cleaning.png', 'filter' => 'homefurniture'
        ),
        'fishing' => array(
            'alt' => 'Fishing', 'img' => get_template_directory_uri() . '/admin/theme_options/skins/fishing.png', 'filter' => 'other'
        ),

    );
}

/*Import content data*/
if ( ! function_exists( 'dgwork_import_files' ) ):

    function dgwork_import_files()
    {
        $demos = fastor_demo_types();
        $to_install = array();
        if(!empty($demos)){
            foreach ($demos as $key => $skin) {
                $to_install[] = array(
                    'import_file_name' => $skin['alt'],
                    'local_import_file' => trailingslashit(get_template_directory()) . '/inc/plugins/importer/sample_data/'.$key.'/sample_data.xml',
                    'local_import_widget_file' => trailingslashit(get_template_directory()) . '/inc/plugins/importer/sample_data/'.$key.'/widget_data.js',
                    'import_preview_image_url' => $skin['img'],
                    'import_notice' => __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'fastor'),
                );
            }

        }

        return $to_install;
    }
    add_filter( 'pt-ocdi/import_files', 'dgwork_import_files' );
endif;
