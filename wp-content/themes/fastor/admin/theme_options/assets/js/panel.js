/* global redux, confirm, relid:true, jsonView */

(function( $ ) {
    'use strict';

    $('input[name="fastor_options[banners-hover-type]"]:checked').next().find('.hover_effect_type').addClass('active')
    $('.hover_effect_type').click(function(){
        $('.banners-hover-type .hover_effect_type').removeClass('active');
        $(this).addClass('active');
        $('.banners-hover-type').parent().parent().find('input').attr('checked', false);
        $(this).parent().parent().find('input').attr('checked', true);
    })


})( jQuery );