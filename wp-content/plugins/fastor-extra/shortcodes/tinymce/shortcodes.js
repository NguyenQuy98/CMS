(function() {    
    
    tinymce.create('tinymce.plugins.ShortcodeMce', {
        init : function(ed, url){
            tinymce.plugins.ShortcodeMce.theurl = url;
        },
        createControl : function(btn, e) {
            if ( btn == "shortcodes_button" ) {
                var a = this;    
                var btn = e.createSplitButton('button', {
                    title: "Fastor Shortcode",
                    image: tinymce.plugins.ShortcodeMce.theurl +"/shortcodes.png",
                    icons: false,
                });
                btn.onRenderMenu.add(function (c, b) {
                    
                    a.render( b, "Custom Block", "custom_block" );
                    a.render( b, "Content Block", "content_block" );
                    a.render( b, "Brands", "brands" );
                    a.render( b, "Brand", "brand" );
                    a.render( b, "Camera Slider", "camera_slider" );
                    a.render( b, "Camera Slide", "camera_slide" );
                    a.render( b, "Filter Products", "filter_products" );
                    a.render( b, "Filter Products Tab", "filter_products_tab" );
                    a.render( b, "Bestseller Products", "sw_bestseller_products" );
                    a.render( b, "Featured Products", "sw_featured_products");
                    a.render( b, "Sale Products", "sw_sale_products");
                    a.render( b, "Latest Products", "sw_latest_products");
                });
                
              return btn;
            }
            return null;               
        },
        render : function(ed, title, id) {
            ed.add({
                title: title,
                onclick: function () {
              
                    fastor_shortcode_open(title, id);
                    return false;
                }
            })
        }
    
    });
    tinymce.PluginManager.add("shortcodes", tinymce.plugins.ShortcodeMce);
    
})();  
