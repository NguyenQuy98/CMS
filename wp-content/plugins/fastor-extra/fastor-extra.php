<?php
/*
Plugin Name: Fastor Extra
Description: Provides shortcodes and content types for Fastor theme
Version: 2.0.0

*/ 

function fastor_extra_shortcodes(){
    include 'shortcodes.php';
}

add_action('fastor_shortcodes', 'fastor_extra_shortcodes');

function fastor_extra_content_types(){
    include 'content_types.php';
}

add_action('fastor_content_types', 'fastor_extra_content_types');


?>
