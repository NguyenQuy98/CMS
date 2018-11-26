(function() {
	tinymce.PluginManager.add('shortcodes', function(editor, url) {
		editor.addButton('shortcodes_button', {
		    type: 'menubutton',
            icon: 'fastor',
            tooltip: 'Fastor Shortcode',
            menu: [
			
                {
                    text: 'Custom Block',
                    value: 'custom_block',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
			
                {
                    text: 'Content Block',
                    value: 'content_block',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Brands',
                    value: 'brands',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Brand',
                    value: 'brand',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Camera Slider',
                    value: 'camera_slider',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Camera Slide',
                    value: 'camera_slide',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                    
                {
                    text: 'Filter products',
                    value: 'filter_products',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Filter Products Tab',
                    value: 'filter_products_tab',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
              
                {
                    text: 'Bestseller Products',
                    value: 'sw_bestseller_products',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Featured Products',
                    value: 'sw_featured_products',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Sale Products',
                    value: 'sw_sale_products',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
                    
                {
                    text: 'Latest Products',
                    value: 'sw_latest_products',
                    onclick: function() {
                        fastor_shortcode_open(this.text(), this.value());
                    }
                },
               
		    ]
		});
	});

})();
