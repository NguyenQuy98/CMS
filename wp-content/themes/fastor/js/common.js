(function($) {
    "use strict";

    // lazy load images
    if($('body').hasClass('lazy-images')){
        $('img[data-src]').lazy({
            effect: "fadeIn",
            effectTime: 300,
            threshold: 0
        });

        // WooCommerce layered nav reload event
        $( 'body' ).on( "aln_reloaded", function(){
            setTimeout(function(){
                $('img[data-src]').each(function(){
                    $(this).attr('src', $(this).attr('data-src'));
                })
            }, 1000);
        } );

        $( document ).on('yith-wcan-ajax-filtered', function(event, response){
            setTimeout(function(){
                $('img[data-src]').each(function(){
                    $(this).attr('src', $(this).attr('data-src'));
                })
            }, 1000);
        })
    }


    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    if( isMobile.any() && responsive_design == 'yes' && $(window).width() <= 991) {
        var i = 0;
        var produkty = [];

        $( ".box-product .carousel .item" ).each(function() {
            $( this ).find( ".product-grid .row > div" ).each(function() {
                if(i > 1) {
                    produkty.push($(this).html());
                }

                i++;
            });
            for ( var s = i-3; s >= 0; s--, s-- ) {
                var html = "<div class='item'><div class='product-grid'><div class='row'>";
                if (produkty[s-1] != undefined) {
                    html += "<div class='col-xs-6'>" + produkty[s-1] + "</div>";
                } else {
                    html += "<div class='col-xs-6'>" + produkty[s+1] + "</div>";
                }

                if (produkty[s] != undefined) {
                    html += "<div class='col-xs-6'>" + produkty[s] + "</div>";
                } else {
                    html += "<div class='col-xs-6'>" + produkty[s+1] + "</div>";
                }
                html += "</div></div></div>";

                $( this ).after( html );
            }

            produkty = [];
            i = 0;
        });

        $('.box-with-categories .box-heading').click(function(){
            $(this).parent().find('.box-content').slideToggle();
        })


    }

    $(window).load(function(){


        $('.product-price-countdown').each(function(){
            var date = $(this).data('date-end');
            var austDay = new Date(date*1000);
            $(this).countdown({until: austDay});
        })


        if(!isMobile.any() && $('#widget-facebook').length > 0){

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            $(".facebook_right").hover(function() {
                $(".facebook_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');
            }, function() {
                $(".facebook_right").stop(true, false).animate({right: "-308"}, 800, 'easeInQuint');
            }, 1000);

            $(".facebook_left").hover(function() {
                $(".facebook_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');
            }, function() {
                $(".facebook_left").stop(true, false).animate({left: "-308"}, 800, 'easeInQuint');
            }, 1000);
        }

        if(!isMobile.any() && $('#widget-twitter').length > 0){
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
            $(".twitter_right").hover(function() {
                $(".twitter_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');
            }, function() {
                $(".twitter_right").stop(true, false).animate({right: "-308"}, 800, 'easeInQuint');
            }, 1000);

            $(".twitter_left").hover(function() {
                $(".twitter_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');
            }, function() {
                $(".twitter_left").stop(true, false).animate({left: "-308"}, 800, 'easeInQuint');
            }, 1000);
        }

        if(!isMobile.any() && $('#widget-custom-content').length > 0){
            $(".custom_right").hover(function() {
                $(".custom_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');
            }, function() {
                $(".custom_right").stop(true, false).animate({right: "-308"}, 800, 'easeInQuint');
            }, 1000);

            $(".custom_left").hover(function() {
                $(".custom_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');
            }, function() {
                $(".custom_left").stop(true, false).animate({left: "-308"}, 800, 'easeInQuint');
            }, 1000);
        }

        // Twitter custom_footer
        if( $('.twitter-feed').length > 0) {
            var config = {
                "likes": {"screenName": $('.twitter-feed').data('id')},
                "domId": 'twitterFeed',
                "dataOnly": false,
                "maxTweets": $('.twitter-feed').data('max-tweets'),
            };
            twitterFetcher.fetch(config);
        }


    })


    $(document).ready(function() {

        if($('#popup').length > 0) {
            $('#popup').find('.newsletter input[type="submit"]').addClass('button');
            var show_after = parseInt('750', 20);
            var autoclose_after = parseInt('', 20);
            if ($.cookie('popup-disabled') != '1') {
                setTimeout(function () {
                    $.magnificPopup.open({
                        items: {
                            src: '#popup',
                            type: 'inline'
                        },
                        tLoading: '',
                        mainClass: 'popup-module mfp-with-zoom popup-type',
                        removalDelay: 200,
                    });

                    if (autoclose_after > 0) {
                        setTimeout(function () {
                            $.magnificPopup.close();
                        }, autoclose_after);
                    }
                }, show_after);
            }

            if ($('#popup').hasClass('onlyonce')) {
                $.cookie('popup-disabled', '1', {expires: 30, path: '/'});
            }

            $('#popup .dont-show-me').change(function () {
                if ($(this).prop('checked')) {
                    $.cookie('popup-disabled', '1', {expires: 30, path: '/'});
                } else {
                    $.removeCookie('popup-disabled');
                }
            })
        }

        if($('#product-enquiry-button').length > 0) {

            $('body').on('click', '#product-enquiry-button', function(){
                var productName = $(this).data('product-name');
                $('#product-enquiry-wrapper').find('input[name="product-name"]').val(productName);

                $.magnificPopup.open({
                    items: {
                        src: '#product-enquiry-wrapper',
                        type: 'inline'
                    },
                    tLoading: '',
                    mainClass: 'popup-module mfp-with-zoom popup-type',
                    removalDelay: 200,
                });

            });

        }

    });

    // Header notice
    if($('#header-notice').length > 0) {

        if(($('#header-notice').hasClass('onlyonce') && localStorage.getItem('displayed-header-notice') != 'yes') || !$('#header-notice').hasClass('onlyonce')) {
            $("#header-notice").show();
        }

        $('#header-notice .close-notice').on('click', function () {
            if ($(this).parent().hasClass('onlyonce')) {
                localStorage.setItem('displayed-header-notice', 'yes');
            }
            $(this).parent().hide();
            return false;
        });

    }

    // Cookie
    if ($.cookie('cookie-accepted') != '1') {
        $('#cookie').fadeIn();
    }
    $(document).ready(function() {
        if($('#cookie').length > 0) {
            $('#cookie .button').click(function () {
                if ($('#cookie .dont-show-me').is(':checked')) {
                    var now = new Date();
                    var time = now.getTime();
                    time += 3600 * 24 * 1000 * 365;
                    now.setTime(time);
                    $.cookie('cookie-accepted', '1', {expires: 30, path: '/'} );
                } else if(!$('#cookie .dont-show-me').length){
                    var now = new Date();
                    var time = now.getTime();
                    time += 3600 * 24 * 1000 * 365;
                    now.setTime(time);
                    $.cookie('cookie-accepted', '1', {expires: 30, path: '/'} );
                }
                $('#cookie').fadeOut('slow');
            });
        }
    });


    $(document).ready(function() {
        // Highlight any found errors
        $('.text-danger').each(function() {
            var element = $(this).parent().parent();

            if (element.hasClass('form-group')) {
                element.addClass('has-error');
            }
        });
        
        if($('.posts').length > 0 && $('.posts').hasClass('posts-grid')){
            var $grid = $('.posts').masonry({
               itemSelector: '.post',
            })
        }



        $(window).scroll(function(){
            if ($(this).scrollTop() > 300) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        }); 

        $('.scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });

        /* Search MegaMenu */
        $('.button-search2').bind('click', function() {
            var url = $('base').attr('href') + 'index.php?route=product/search';

            var search = $('.container-megamenu input[name=\'search2\']').val();

            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }

            window.location = url;
        });

        $('.container-megamenu input[name=\'search2\']').bind('keydown', function(e) {
            if (e.keyCode == 13) {
                var url = $('base').attr('href') + 'index.php?route=product/search';

                var search = $('.container-megamenu input[name=\'search2\']').val();

                if (search) {
                    url += '&search=' + encodeURIComponent(search);
                }

                var location = url;
            }
        });


        // tooltips on hover
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

        // Makes tooltips work on ajax generated content
        $(document).ajaxStop(function() {
            $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
        });

        $(window).scroll(function(){
            if ($(this).scrollTop() > 300) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });

        $('.scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });

        /* Search MegaMenu */
        $('.button-search2').bind('click', function() {
            var url = $('base').attr('href') + 'index.php?route=product/search';

            var search = $('.container-megamenu input[name=\'search2\']').val();

            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }

            window.location = url;
        });

        $('.container-megamenu input[name=\'search2\']').bind('keydown', function(e) {
            if (e.keyCode == 13) {
                var url = $('base').attr('href') + 'index.php?route=product/search';

                var search = $('.container-megamenu input[name=\'search2\']').val();

                if (search) {
                    url += '&search=' + encodeURIComponent(search);
                }

                window.location = url;
            }
        });

        /* Quantity buttons */
        $('body').on('click', '#q_up', function(){
            var q_val_up=parseInt($("input#quantity_wanted").val());
            if(isNaN(q_val_up)) {
                q_val_up=0;
            }
            $("input#quantity_wanted").val(q_val_up+1).keyup();
            $( this ).parent( '.quantity' ).parent().find( '.add_to_cart_button' ).attr( 'data-quantity', $( this ).parent('.quantity').find('.qty ').val() );
            return false;
        });

        $('body').on('click', '#q_down', function(){
            var q_val_up=parseInt($("input#quantity_wanted").val());
            if(isNaN(q_val_up)) {
                q_val_up=0;
            }

            if(q_val_up>1) {
                $("input#quantity_wanted").val(q_val_up-1).keyup();
            }
            $( this ).parent( '.quantity' ).parent().find( '.add_to_cart_button' ).attr( 'data-quantity', $( this ).parent('.quantity').find('.qty ').val() );
            return false;
        });


        $( document ).on( 'change', '.quantity .qty', function() {
            $( this ).parent( '.quantity' ).parent().find( '.add_to_cart_button' ).attr( 'data-quantity', $( this ).val() );
        });

        // tooltips on hover
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

        // Makes tooltips work on ajax generated content
        $(document).ajaxStop(function() {
            $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
        });

        FixedTop();


        $('.sticky-search > i').bind('click', function() {
            $(".sticky-header").addClass("sticky-bg");
            $("body").addClass("with-sticky-bg");
            $(".sticky-header .quick-search").addClass("showing");
        });

        $('.sticky-search .quick-search .icon_close').bind('click', function() {
            $(".sticky-header").removeClass("sticky-bg");
            $("body").removeClass("with-sticky-bg");
            $(".sticky-header .quick-search").removeClass("showing");
        });


        $(".box-home-watches .owl-carousel").trigger('owl.jumpTo', 2)

    });


    // Cart add remove functions	
    window.cart = {
        'add': function(product_id, quantity) {
            $.ajax({
                url: 'index.php?route=checkout/cart/add',
                type: 'post',
                data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
                dataType: 'json',
                success: function(json) {			
                    if (json['redirect']) {
                        window.location = json['redirect'];
                    }

                    if (json['success']) {
                         $.notify({
                            message: json['success'],
                            target: '_blank'
                         },{
                            // settings
                            element: 'body',
                            position: null,
                            type: "info",
                            allow_dismiss: true,
                            newest_on_top: false,
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 2031,
                            delay: 5000,
                            timer: 1000,
                            url_target: '_blank',
                            mouse_over: null,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                            onShow: null,
                            onShown: null,
                            onClose: null,
                            onClosed: null,
                            icon_type: 'class',
                            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
                                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                '<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
                                '<div class="progress" data-notify="progressbar">' +
                                    '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                                '</div>' +
                                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                            '</div>' 
                         });

                        $('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
                        $('#cart-total').html(json['total']);
                    }
                }
            });
        },
        'update': function(key, quantity) {
            $.ajax({
                url: 'index.php?route=checkout/cart/edit',
                type: 'post',
                data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
                dataType: 'json',
                success: function(json) {
                    if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                        window.location = 'index.php?route=checkout/cart';
                    } else {
                        $('#cart_block #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
                        $('#cart-total').html(json['total']);
                    }			
                }
            });			
        },
        'remove': function(key) {
                var cart_id = key;

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: js_fastor_vars.ajax_url,
                    data: { action: "fastor_product_remove",
                        cart_id: cart_id
                    },success: function( response ) {
                        var fragments = response.fragments;
                        var cart_hash = response.cart_hash;

                        if ( fragments ) {
                            $.each(fragments, function(key, value) {
                                $(key).replaceWith(value);
                            });
                        }

                    }
                });
                return false;
        }
    }


        $(document).on('adding_to_cart', function(event, data){

            $.notify({
                message: js_fastor_vars.add_to_cart_msg_success,
                target: '_blank'
             },{
                // settings
                element: 'body',
                position: null,
                type: "info",
                allow_dismiss: true,
                newest_on_top: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 2031,
                delay: 3000,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>' 
             });

        })
        $(document).on('added_to_wishlist', function(event, data){
            var add = $.notify({
                message: js_fastor_vars.add_to_wishlist_msg_success,
                target: '_blank'
             },{
                // settings
                element: 'body',
                position: null,
                type: "info",
                allow_dismiss: true,
                newest_on_top: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 2031,
                delay: 3000,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>' 
             });

        })



    function openPopup(module_id, product_id) {
         product_id = product_id || undefined;
         $.magnificPopup.open({
              items: {
                   src: 'index.php?route=module/popup/show&module_id=' + module_id + (product_id ? '&product_id=' + product_id : '')
              },
              mainClass: 'popup-module mfp-with-zoom',
              type: 'ajax',
              removalDelay: 200
         });
    }

})(jQuery);

(function($) {
    "use strict";
    $(window).resize(function() {
        FixedTop();
    });
})(jQuery);

(function($) {
    "use strict";
    $(window).scroll(function() {
        FixedTop();
    });
})(jQuery);

function FixedTop() {
    "use strict";
    (function($) {
        var width = $('header #top').width();
        var width3 = $('header #top .background').width();
        var width2 = $('header').width();
        if(width3 != width2) {
            $('.sticky-header').css("background", "none");
        }
        $('.sticky-header').css("width", width).css("left", "50%").css("right", "auto").css("margin-left",  "-" + Math.ceil(width/2) + "px").css("margin-right",  "-" + Math.ceil(width/2) + "px");

        if($(window).width() >= 1160 && $(window).scrollTop() > 280) {
            $('.sticky-header').addClass('fixed-header');
        } else {
            $('.sticky-header').removeClass('fixed-header');
        }
    })(jQuery);
}



function display(view) {
    if (view == 'list') {
        (function($) {
            $('.product-grid').removeClass("active");
            $('.product-list').addClass("active");

            $('.display').html('<button id="grid" rel="tooltip" title="Grid" onclick="display(\'grid\');"><i class="fa fa-th-large"></i></button> <button class="active" id="list" rel="tooltip" title="List" onclick="display(\'list\');"><i class="fa fa-th-list"></i></button>');

            localStorage.setItem('display', 'list');
        })(jQuery);
    } else {
        (function($) {
            $('.product-grid').addClass("active");
            $('.product-list').removeClass("active");

            $('.display').html('<button class="active" id="grid" rel="tooltip" title="Grid" onclick="display(\'grid\');"><i class="fa fa-th-large"></i></button> <button id="list" rel="tooltip" title="List" onclick="display(\'list\');"><i class="fa fa-th-list"></i></button>');

            localStorage.setItem('display', 'grid');
        })(jQuery);
    }
}


(function($) {
    "use strict";


    function force_full_width() {

        var rtl = $('body').hasClass('rtl');

        var p = $(".standard-body .full-width .force-full-width");


        if(!rtl) {
            if (p.size() > 0) {
                p.width($('body').width());
                p.css("left", "0px");
                var position = p.offset();
                p.css("left", "-" + position.left + "px");
                p.find(".container").css("padding-left", position.left);
                p.find(".container").css("padding-right", position.left);

            }
        }else{
            if(p.size() > 0) {
                p.width($('body').width());
                p.css("right", "0px");
                var position = p.offset();
                p.css("right", "-" + position.left * -1 + "px");
                p.find(".container").css("padding-left", position.left * -1);
                p.find(".container").css("padding-right", position.left * -1);
            }
        }
        var s = $(".standard-body .fixed .force-full-width");

        if(!rtl) {
            if (s.size() > 0) {
                s.width($('.standard-body .fixed .pattern').width());
                s.css("left", "0px");
                var position = s.offset();
                var position2 = $('.standard-body .fixed .pattern').offset();
                var position3 = position.left - position2.left;
                s.css("left", "-" + position3 + "px");
                s.find(".container").css("padding-left", position3);
                s.find(".container").css("padding-right", position3);
            }
        } else{
            if(s.size() > 0) {
                s.width($('.standard-body .fixed .pattern').width());
                s.css("right", "0px");
                var position = s.offset();
                var position2 = $('.standard-body .fixed .pattern').offset();
                var position3 = position.left-position2.left;
                s.css("right", "-" + position3 * -1 + "px");
                s.find(".container").css("padding-left", position3 * -1);
                s.find(".container").css("padding-right", position3 * -1);
            }
        }


        var c = $(".fixed-body .force-full-width");

        if(!rtl) {
            if (c.size() > 0) {
                c.width($('.fixed-body .main-fixed').width());
                c.css("left", "0px");
                var position = c.offset();
                var position2 = $('.fixed-body .main-fixed').offset();
                var position3 = position.left - position2.left;
                c.css("left", "-" + position3 + "px");
                c.find(".container").css("padding-left", position3);
                c.find(".container").css("padding-right", position3);
            }
        }else{
            if(c.size() > 0) {
                c.width($('.fixed-body .main-fixed').width());
                c.css("right", "0px");
                var position = c.offset();
                var position2 = $('.fixed-body .main-fixed').offset();
                var position3 = position.left-position2.left;
                c.css("right", "-" + position3 * -1 + "px");
                c.find(".container").css("padding-left", position3 * -1);
                c.find(".container").css("padding-right", position3 * -1);
            }
        }
    }

    force_full_width();

    $(window).resize(function() {
        force_full_width();
    });


})(jQuery);

// AJAX SEARCH
(function($) {
    if($('.search_form #s.auto-suggest').length > 0){
        $('.search_form #s.auto-suggest').autocomplete({
            delay: 0,
            appendTo: "#autocomplete-results",
            source: function(request, response) {

                var product_cat = '';
                if($('.search_form select[name="product_category"]').val()){
                    product_cat = $('.search_form select[name="product_category"]').val().trim()
                }

                $.ajax({
                    url: js_fastor_vars.ajax_url + '?action=fastor_ajax_search&term=' +  encodeURIComponent(request.term) + (product_cat ? '&product_category='+ product_cat : ''),
                    dataType: 'json',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return {
                                label: item.label,
                                value: item.label,
                                href: item.href,
                                // thumb: item.thumb,
                                // desc: item.desc,
                                // price: item.price
                            }
                        }));
                    }
                });
            },
            select: function(event, ui) {
                document.location.href = ui.item.href;

                return false;
            },
            focus: function(event, ui) {
                return false;
            },
            minLength: 2
        })
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<a>" + item.label + "</a>" )
                .appendTo( ul );
        };
    }



})(jQuery);






