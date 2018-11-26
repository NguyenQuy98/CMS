(function($) {
    "use strict";
    $('.portfolio-page .portfolio-slick').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        asNavFor: '.portfolio-slick-nav',
        nextArrow: '<div class="slick-arrow-wrap slick-next"><i class="fa fa-chevron-right"></i></div>',
        prevArrow: '<div class="slick-arrow-wrap slick-prev"><i class="fa fa-chevron-left"></i></div>',
    });

    $('.portfolio-page .portfolio-slick-nav').slick({
        slidesToShow:4,
        slidesToScroll: 1,
        asNavFor: '.portfolio-slick',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        nextArrow: '<div class="slick-arrow-wrap slick-next">'+ $('.portfolio-page .portfolio-slick-nav').attr('data-next-text') +'<i class="fa fa-arrow-right"></i></div>',
        prevArrow: '<div class="slick-arrow-wrap slick-prev"><i class="fa fa-arrow-left"></i>'+ $('.portfolio-page .portfolio-slick-nav').attr('data-prev-text') +'</div>',
    });

    $('.portfolio-page .portfolio-slick a').prettyPhoto();

    var $portfolioGrid = $('#template-portfolio .portfolio-list-wrapper.masonry-wrapper').masonry({
        itemSelector: '.masonry-item',
        columnWidth: 0,
    })

    $portfolioGrid.imagesLoaded().progress( function() {
        $portfolioGrid.masonry('layout');
    });

    $('.portfolio-filters li').click(function(){
        $('.portfolio-filters li').removeClass('selected');
        $(this).addClass('selected');

        var category = $(this).data('filter');

        if(category == '*'){
            $('.portfolio-list-wrapper .portfolio-item').show();
        }else{
            $('.portfolio-list-wrapper .portfolio-item').hide();
            $('.portfolio-list-wrapper .portfolio-item' + category).show();

        }
        $portfolioGrid.masonry('layout');

    })

    // add listener for load more click
    $('#portfolio-load-more').on('click', function(e) {

        e.preventDefault();

        var clicks, me = $(this), oMsg;

        if (me.hasClass('cbp-l-loadMore-button-stop')) return;


        // get the number of times the loadMore link has been clicked
        clicks = $.data(this, 'numberOfClicks');
        clicks = (clicks)? ++clicks : 1;
        $.data(this, 'numberOfClicks', clicks);

        // set loading status
        oMsg = me.text();
        me.text(me.data('loading-label'));
        // perform ajax request
        $.ajax({
            url: fastor_loadmoreportfolio.ajaxurl,
            data: {
                action:'fastor_portfolio_ajaxloader',
                click: clicks,
                limit: $('#template-portfolio').data('portfolio-limit'),
                category: $('#template-portfolio').data('portfolio-category'),
                template: $('#template-portfolio').data('portfolio-template'),
            },
            type: 'POST',
            dataType: 'HTML'
        })
            .done( function (result) {
                var items;
                // // find current container
                items = $(result).filter( function () {
                    return $(this).is('div' + '.cbp-loadMore-block');
                });

                // put the original message back
                me.text(oMsg);

                if($portfolioGrid.length){
                    items.find('.portfolio-item').each(function(){
                        $(this).addClass('new-item').hide();
                        $portfolioGrid.append( $(this) )
                            .masonry( 'appended', $(this) );
                    })

                    setTimeout(function(){
                        if (items.length == 0) {
                            me.text(me.data('nomore-label'));
                            me.addClass('cbp-l-loadMore-button-stop');
                        }

                        $('.portfolio-list-wrapper .portfolio-item.new-item').show().removeClass('new-item')
                        $portfolioGrid.masonry('layout');
                        $('.portfolio-filters li.selected').trigger('click')
                    }, 300)
                }else{
                    if (items.length == 0) {
                        me.text(me.data('nomore-label'));
                        me.addClass('cbp-l-loadMore-button-stop');
                    }
                    $('.portfolio-category-list-wrapper').append(items.html())
                }




            })
            .fail(function() {
                // error
            });

    });

})(jQuery);


