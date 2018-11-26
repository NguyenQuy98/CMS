
(function ($) {



    // Redux background preview fix
    if(typeof redux !== 'undefined'){
        redux.field_objects.background.preview = function( selector ) {
            var parent = $( selector ).parents( '.redux-container-background:first' );
            var preview = $( parent ).find( '.background-preview' );

            if ( !preview ) { // No preview present
                return;
            }
            var hide = true;

            var css = 'height:' + preview.height() + 'px;';
            $( parent ).find( '.redux-background-input' ).each(
                function() {
                    var data = $( this ).serializeArray();
                    data = data[0];
                    if ( data && data.name.indexOf( '[background-' ) != -1 ) {
                        if ( data.value !== "" ) {
                            hide = false;
                            data.name = data.name.split( '[background-' );
                            data.name = 'background-' + data.name[data.name.length-1].replace( ']', '' );
                            if ( data.name == "background-image" ) {
                                css += data.name + ':url("' + data.value + '");';
                            } else {
                                css += data.name + ':' + data.value + ';';
                            }
                        }
                    }
                }
            );
            if ( !hide ) {
                preview.attr( 'style', css ).fadeIn();
            } else {
                preview.slideUp();
            }


        };
    }



    $.fn.extend({
        easyResponsiveTabs: function (options) {
            //Set the default values, use comma to separate the settings, example:
            var defaults = {
                type: 'default', //default, vertical, accordion;
                width: 'auto',
                fit: true,
                closed: false,
                activate: function(){}
            }
            //Variables
            var options = $.extend(defaults, options);
            var opt = options, jtype = opt.type, jfit = opt.fit, jwidth = opt.width, vtabs = 'vertical', accord = 'accordion';
            var hash = window.location.hash;
            var historyApi = !!(window.history && history.replaceState);
            //Events
            $(this).bind('tabactivate', function(e, currentTab) {
                if(typeof options.activate === 'function') {
                    options.activate.call(currentTab, e)
                }
            });
            //Main function
            this.each(function () {
                var $respTabs = $(this);
                var $respTabsList = $respTabs.find('ul.resp-tabs-list');
                var respTabsId = $respTabs.attr('id');
                $respTabs.find('ul.resp-tabs-list li').addClass('resp-tab-item');
                $respTabs.css({
                    'display': 'block',
                    'width': jwidth
                });
                $respTabs.find('.resp-tabs-container > div').addClass('resp-tab-content');
                jtab_options();
                //Properties Function
                function jtab_options() {
                    if (jtype == vtabs) {
                        $respTabs.addClass('resp-vtabs');
                    }
                    if (jfit == true) {
                        $respTabs.css({ width: '100%' });
                    }
                    if (jtype == accord) {
                        $respTabs.addClass('resp-easy-accordion');
                        $respTabs.find('.resp-tabs-list').css('display', 'none');
                    }
                }
                //Assigning the h2 markup to accordion title
                var $tabItemh2;
                $respTabs.find('.resp-tab-content').before("<h2 class='resp-accordion' role='tab'><span class='resp-arrow'></span></h2>");
                var itemCount = 0;
                $respTabs.find('.resp-accordion').each(function () {
                    $tabItemh2 = $(this);
                    var $tabItem = $respTabs.find('.resp-tab-item:eq(' + itemCount + ')');
                    var $accItem = $respTabs.find('.resp-accordion:eq(' + itemCount + ')');
                    $accItem.append($tabItem.html());
                    $accItem.data($tabItem.data());
                    $tabItemh2.attr('aria-controls', 'tab_item-' + (itemCount));
                    itemCount++;
                });
                //Assigning the 'aria-controls' to Tab items
                var count = 0,
                    $tabContent;
                $respTabs.find('.resp-tab-item').each(function () {
                    $tabItem = $(this);
                    $tabItem.attr('aria-controls', 'tab_item-' + (count));
                    $tabItem.attr('role', 'tab');
                    //Assigning the 'aria-labelledby' attr to tab-content
                    var tabcount = 0;
                    $respTabs.find('.resp-tab-content').each(function () {
                        $tabContent = $(this);
                        $tabContent.attr('aria-labelledby', 'tab_item-' + (tabcount));
                        tabcount++;
                    });
                    count++;
                });
                // Show correct content area
                var tabNum = 0;
                if(hash!='') {
                    var matches = hash.match(new RegExp(respTabsId+"([0-9]+)"));
                    if (matches!==null && matches.length===2) {
                        tabNum = parseInt(matches[1],10)-1;
                        if (tabNum > count) {
                            tabNum = 0;
                        }
                    }
                }
                //Active correct tab
                $($respTabs.find('.resp-tab-item')[tabNum]).addClass('resp-tab-active');
                //keep closed if option = 'closed' or option is 'accordion' and the element is in accordion mode
                if(options.closed !== true && !(options.closed === 'accordion' && !$respTabsList.is(':visible')) && !(options.closed === 'tabs' && $respTabsList.is(':visible'))) {
                    $($respTabs.find('.resp-accordion')[tabNum]).addClass('resp-tab-active');
                    $($respTabs.find('.resp-tab-content')[tabNum]).addClass('resp-tab-content-active').attr('style', 'display:block');
                }
                //assign proper classes for when tabs mode is activated before making a selection in accordion mode
                else {
                    $($respTabs.find('.resp-tab-content')[tabNum]).addClass('resp-tab-content-active resp-accordion-closed')
                }
                //Tab Click action function
                $respTabs.find("[role=tab]").each(function () {
                    var $currentTab = $(this);
                    $currentTab.click(function () {
                        var $currentTab = $(this);
                        var $tabAria = $currentTab.attr('aria-controls');
                        if ($currentTab.hasClass('resp-accordion') && $currentTab.hasClass('resp-tab-active')) {
                            $respTabs.find('.resp-tab-content-active').slideUp('', function () { $(this).addClass('resp-accordion-closed'); });
                            $currentTab.removeClass('resp-tab-active');
                            return false;
                        }
                        if (!$currentTab.hasClass('resp-tab-active') && $currentTab.hasClass('resp-accordion')) {
                            $respTabs.find('.resp-tab-active').removeClass('resp-tab-active');
                            $respTabs.find('.resp-tab-content-active').slideUp().removeClass('resp-tab-content-active resp-accordion-closed');
                            $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('resp-tab-active');
                            $respTabs.find('.resp-tab-content[aria-labelledby = ' + $tabAria + ']').slideDown().addClass('resp-tab-content-active');
                        } else {
                            $respTabs.find('.resp-tab-active').removeClass('resp-tab-active');
                            $respTabs.find('.resp-tab-content-active').removeAttr('style').removeClass('resp-tab-content-active').removeClass('resp-accordion-closed');
                            $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('resp-tab-active');
                            $respTabs.find('.resp-tab-content[aria-labelledby = ' + $tabAria + ']').addClass('resp-tab-content-active').attr('style', 'display:block');
                        }
                        //Trigger tab activation event
                        $currentTab.trigger('tabactivate', $currentTab);
                    });
                });
                //Window resize function
                $(window).resize(function () {
                    $respTabs.find('.resp-accordion-closed').removeAttr('style');
                });
            });
        }
    });
})(jQuery);
jQuery(document).ready(function($) {
    // content type meta tab
    $('.fastor-meta-tab').easyResponsiveTabs({
        type: 'vertical'//, //default, vertical, accordion;
    });
    // taxonomy meta tab
    $('.fastor-tab-row').hide();
    $('.fastor-tax-meta-tab').on('click', function(e) {
        e.preventDefault();
        var tab = $(this).attr('data-tab');
        $('.fastor-tab-row[data-tab="' + tab + '"]').toggle();
        return false;
    });
    // color field
    $('.fastor-meta-color').each(function() {
        var $el = $(this),
            $c = $el.find('.fastor-color-field'),
            $t = $el.find('.fastor-color-transparency');
        $c.wpColorPicker({
            change: function( e, ui ) {
                $( this ).val( ui.color.toString() );
                $t.removeAttr( 'checked' );
            },
            clear: function( e, ui ) {
                $t.removeAttr( 'checked' );
            }
        });
        $t.on('click', function() {
            if ( $( this ).is( ":checked" ) ) {
                $c.attr('data-old-color', $c.val());
                $c.val( 'transparent' );
                $el.find( '.wp-color-result' ).css('background-color', 'transparent');
            } else {
                if ( $c.val() === 'transparent' ) {
                    var oc = $c.attr('data-old-color');
                    $el.find( '.wp-color-result' ).css('background-color', oc);
                    $c.val(oc);
                }
            }
        });
    });
    // meta required filter
    var filters = ['.postoptions .metabox', '.form-table .form-field'];
    $.each(filters, function(index, filter) {
        $(filter + '[data-required]').each(function() {
            var $el = $(this),
                id = $el.data('required'),
                value = $el.data('value'),
                $required = $(filter + ' [name="' + id + '"]'),
                type = $required.attr('type');
            if ($required.prop('type') == 'select-one') {
                $required.change(function() {
                    if ($required.val() == value) {
                        $el.show();
                    } else {
                        $el.hide();
                    }
                });
                $required.change();
            } else {
                if (type == 'checkbox') {
                    $required.change(function() {
                        if ($(this).is(':checked')) {
                            if (value) {
                                $el.show();
                            } else {
                                $el.hide();
                            }
                        } else {
                            if (!value) {
                                $el.show();
                            } else {
                                $el.hide();
                            }
                        }
                    });
                    $required.change();
                } else if (type == 'radio') {
                    $required.click(function() {
                        if ($(this).is(':checked')) {
                            if (value == $(this).val()) {
                                $el.show();
                            } else {
                                $el.hide();
                            }
                        }
                    });
                    $(filter + ' [name="' + id + '"]:checked').click();
                }
            }
        });
    });
    // codemirror
    if (typeof CodeMirror != 'undefined') {
        if (document.getElementById("custom_css")) CodeMirror.fromTextArea(document.getElementById("custom_css"), { lineNumbers: true, mode: 'css' });
        if (document.getElementById("custom_js_head")) CodeMirror.fromTextArea(document.getElementById("custom_js_head"), { lineNumbers: true, mode: 'javascript' });
        if (document.getElementById("custom_js_body")) CodeMirror.fromTextArea(document.getElementById("custom_js_body"), { lineNumbers: true, mode: 'javascript' });
    }
});
// Uploading files
var file_frame;
var clickedID;
var errorCounter = 0;
jQuery(document).off( 'click', '.button_upload_image').on( 'click', '.button_upload_image', function( event ){
    event.preventDefault();
    // If the media frame already exists, reopen it.
    if ( !file_frame ) {
        // Create the media frame.
        file_frame = wp.media.frames.downloadable_file = wp.media({
            title: 'Choose an image',
            button: {
                text: 'Use image'
            },
            multiple: false
        });
    }
    file_frame.open();
    clickedID = jQuery(this).attr('id');
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
        attachment = file_frame.state().get('selection').first().toJSON();
        jQuery('#' + clickedID).val( attachment.url );
        if (jQuery('#' + clickedID).attr('data-name'))
            jQuery('#' + clickedID).attr('name', jQuery('#' + clickedID).attr('data-name'));
        file_frame.close();
    });
});
jQuery(document).off( 'click', '.button_attach_image').on( 'click', '.button_attach_image', function( event ){
    event.preventDefault();
    // If the media frame already exists, reopen it.
    if ( !file_frame ) {
        // Create the media frame.
        file_frame = wp.media.frames.downloadable_file = wp.media({
            title: 'Choose an image',
            button: {
                text: 'Use image'
            },
            multiple: false
        });
    }
    file_frame.open();
    clickedID = jQuery(this).attr('id');
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
        attachment = file_frame.state().get('selection').first().toJSON();
        jQuery('#' + clickedID).val( attachment.id );
        jQuery('#' + clickedID + '_thumb').html('<img src="' + attachment.url + '"/>');
        if (jQuery('#' + clickedID).attr('data-name'))
            jQuery('#' + clickedID).attr('name', jQuery('#' + clickedID).attr('data-name'));
        file_frame.close();
    });
});
jQuery(document).on( 'click', '.button_remove_image', function( event ){
    var clickedID = jQuery(this).attr('id');
    jQuery('#' + clickedID).val( '' );
    jQuery('#' + clickedID + '_thumb').html('');
    return false;
});
jQuery(function($) {
    // Remove import success values
    if ($('#redux-form-wrapper').length) {
        var $referer = $('#redux-form-wrapper input[name="_wp_http_referer"]');
        var value = $referer.val();
        value = value.replace('&import_success=true', '');
        value = value.replace('&import_masterslider_success=true', '');
        value = value.replace('&import_widget_success=true', '');
        value = value.replace('&import_options_success=true', '');
        value = value.replace('&compile_theme_success=true', '');
        value = value.replace('&compile_theme_rtl_success=true', '');
        value = value.replace('&compile_plugins_success=true', '');
        value = value.replace('&compile_plugins_rtl_success=true', '');
        $referer.val(value);
    }
    function alertLeavePage(e) {
        var dialogText = "Are you sure you want to leave?";
        e.returnValue = dialogText;
        return dialogText;
    }
    function addAlertLeavePage() {
        $('.fastor-install-demos .button-install-demo').attr('disabled', 'disabled');
        $(window).bind('beforeunload', alertLeavePage);
    }
    function removeAlertLeavePage() {
        $('.fastor-install-demos .button-install-demo').removeAttr('disabled');
        $(window).unbind('beforeunload', alertLeavePage);
        setTimeout(function() {
            $('.fastor-install-demos #import-status').slideUp().html('');
        }, 3000);
    }
    function showImportMessage(selected_demo, message, count, index) {
        html = '';
        if (selected_demo) {
            html += '<h3>Installing ' + $('#' + selected_demo).html() + '</h3>';
        }
        if (message) {
            html += '<strong>' + message + '</strong>';
        }
        if (count && index) {
            percent = index / count * 100;
            if (percent > 100)
                percent = 100;
            html += '<div class="import-progress-bar"><div style="width:' + percent + '%;"></div></div>';
        }
        $('.fastor-install-demos #import-status').stop().show().html(html);
    }
    // filter demos
    if ($('#theme-install-demos').length) {
        var $install_demos = $('#theme-install-demos').isotope(),
            $demos_filter = $('.demo-sort-filters');
        $demos_filter.find('.sort-source li').click(function(e) {
            e.preventDefault();
            var $this = $(this),
                filter = $this.data('filter-by');
            $install_demos.isotope({
                filter: (filter == '*' ? filter : ('.' + filter))
            });
            $demos_filter.find('.sort-source li').removeClass('active');
            $this.addClass('active');
            return false;
        });
        $demos_filter.find('.sort-source li[data-active="true"]').click();
    }
    // install demo
    $( '.button-install-demo' ).live( 'click', function(e) {
        e.preventDefault();
        var $this = $(this),
            selected_demo = $this.data( 'demo-id' ),
            disabled = $this.attr('disabled');
        if (disabled)
            return;
        addAlertLeavePage();
        $('#fastor-install-demo-type').val(selected_demo);
        $('#fastor-install-options .theme-name').html($this.closest('.theme-wrapper').find('.theme-name').html());
        $('#fastor-install-options').slideDown();
        $('html, body').stop().animate({
            scrollTop: $('#fastor-install-options').offset().top - 50
        }, 600);
    });
    // cancel import button
    $('#fastor-import-no').click(function() {
        $('#fastor-install-options').slideUp();
        removeAlertLeavePage();
    });
    // import
    $('#fastor-import-yes').click(function() {
        var actions_count = 0;
        if($('#fastor-reset-menus').is(':checked')){
            actions_count++;
        }
        if($('#fastor-reset-widgets').is(':checked')){
            actions_count++;
        }
        if($('#fastor-import-dummy').is(':checked')){
            actions_count++;
        }
        if($('#fastor-import-shortcodes').is(':checked')){
            actions_count++;
        }
        if($('#fastor-import-widgets').is(':checked')){
            actions_count++;
        }


        var demo = $('#fastor-install-demo-type').val(),
            options = {
                demo: demo,
                reset_menus: $('#fastor-reset-menus').is(':checked'),
                reset_widgets: $('#fastor-reset-widgets').is(':checked'),
                import_dummy: $('#fastor-import-dummy').is(':checked'),
                import_shortcodes: $('#fastor-import-shortcodes').is(':checked'),
                import_widgets: $('#fastor-import-widgets').is(':checked'),
                actions_count: actions_count,
                action_index: 0
            };
        if (options.demo) {
            showImportMessage(demo, '');
            fastor_reset_menus(options);
        }
        $('#fastor-install-options').slideUp();
    });
    // reset_menus
    function fastor_reset_menus(options) {
        if (!options.demo) {
            removeAlertLeavePage();
            return;
        }
        if (options.reset_menus) {
            var demo = options.demo,
                data = {'action': 'fastor_reset_menus', 'import_shortcodes': options.import_shortcodes};
            $.post(ajaxurl, data, function(response) {
                options.action_index++;
                if (response) showImportMessage(demo, response, options.actions_count, options.action_index);
                fastor_reset_widgets(options);
            }).fail(function(response) {
                fastor_reset_widgets(options);
            });
        } else {
            fastor_reset_widgets(options);
        }
    }
    // reset widgets
    function fastor_reset_widgets(options) {
        if (!options.demo) {
            removeAlertLeavePage();
            return;
        }
        if (options.reset_widgets) {
            var demo = options.demo,
                data = {'action': 'fastor_reset_widgets'};
            $.post(ajaxurl, data, function(response) {
                options.action_index++;
                if (response) showImportMessage(demo, response, options.actions_count, options.action_index);
                fastor_import_dummy(options);
            }).fail(function(response) {
                fastor_import_dummy(options);
            });
        } else {
            fastor_import_dummy(options);
        }
    }
    // import dummy content
    var dummy_index = 0, dummy_count = 0, dummy_process = 'import_start';
    function fastor_import_dummy(options) {
        if (!options.demo) {
            removeAlertLeavePage();
            return;
        }
        if (options.import_dummy) {
            var demo = options.demo,
                data = {'action': 'fastor_import_dummy', 'process':'import_start', 'demo': demo};
            dummy_index = 0;
            dummy_count = 0;
            dummy_process = 'import_start';
            options.action_index++;
            fastor_import_dummy_process(options, data, options.actions_count, options.action_index);
        } else {
            fastor_import_widgets(options);
        }
    }
    // import dummy content process
    function fastor_import_dummy_process(options, args) {
        var demo = options.demo;
        $.post(ajaxurl, args, function(response) {
            if (response && /^[\],:{}\s]*$/.test(response.replace(/\\["\\\/bfnrtu]/g, '@').
                replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
                replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                response = $.parseJSON(response);
                if (response.process != 'complete') {
                    var requests = {'action': 'fastor_import_dummy'};
                    if (response.process) requests.process = response.process;
                    if (response.index) requests.index = response.index;
                    requests.demo = demo;
                    //  fastor_import_dummy_process(options, requests);
                    dummy_index = response.index;
                    dummy_count = response.count;
                    dummy_process = response.process;
                    showImportMessage(demo, response.message, dummy_count, dummy_index);
                } else {
                    options.action_index++;
                    showImportMessage(demo, response.message, options.actions_count, options.action_index);
                    fastor_import_widgets(options);
                }
            } else {
                showImportMessage(demo, 'Failed importing! Please check the "System Status" tab to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red.');
                fastor_import_widgets(options);
            }
        }).fail(function(response) {
            if(errorCounter >= 3){
                showImportMessage(demo, '<span style="color: red">Failed importing! </span><br><a target="_blank" href="http://fastordocs.cleventhemes.net/setup/demo-content">TRY TO ALTERNATIVE WAY OF INSTALLATION DEMO CONTENT</a> '
                + '<br> Please check also the "System Status" tab to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red.');
               return;
            }

            if (dummy_index < dummy_count) {
                var requests = {'action': 'fastor_import_dummy'};
                requests.process = dummy_process;
                requests.index = ++dummy_index;
                requests.demo = demo;
                fastor_import_dummy_process(options, requests);
            } else {
                var requests = {'action': 'fastor_import_dummy'};
                requests.process = dummy_process;
                requests.demo = demo;
                fastor_import_dummy_process(options, requests);
            }
            errorCounter++;
        });
    }
    // import widgets
    function fastor_import_widgets(options) {
        if (!options.demo) {
            removeAlertLeavePage();
            return;
        }
        if (options.import_widgets) {
            var demo = options.demo,
                data = {'action': 'fastor_import_widgets', 'demo': demo};
            showImportMessage(demo, 'Importing widgets', options.actions_count, options.action_index);
            $.post(ajaxurl, data, function(response) {
                options.action_index++;
                if (response) showImportMessage(demo, response, options.actions_count, options.action_index);
                fastor_import_finished(options);
            }).fail(function(response) {
                fastor_import_finished(options);
            });
        }
    }
    // import finished
    function fastor_import_finished(options) {
        if (!options.demo) {
            removeAlertLeavePage();
            return;
        }
        var demo = options.demo;
        setTimeout(function() {
            showImportMessage(demo, 'Finished! Please visit your site.');
            setTimeout(removeAlertLeavePage, 3000);
        }, 3000);
    }
});
