<?php

// Register Static Block Content Type
add_action('init', 'fastor_custom_block_init');

function fastor_custom_block_init() {
    
    register_post_type(         
        'custom_block',
        array(
            'labels' => fastor_labels('Custom Block', 'Custom Blocks'),
            'exclude_from_search' => true,
            'has_archive' => false,
            'public' => true,
            'rewrite' => array('slug' => 'custom-blocks'),
            'supports' => array('title', 'editor'),
            'can_export' => true
        )
    );
}

?>
