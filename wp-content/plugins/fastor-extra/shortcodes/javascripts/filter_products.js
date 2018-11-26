
jQuery(function($) {

    var form = jQuery('<div id="filter_products-form"><table id="filter_products-table" class="form-table">\
			<tr>\
				<th><label for="filter_products-title">Title</label></th>\
				<td><input type="text" name="title" id="filter_products-title" value="" /></td>\
			</tr>\
            <tr>\
				<th><label for="filter_products-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="filter_products-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="filter_products-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#filter_products-submit').click(function(){

        var options = {
            'title'              : '',
            'class'              : ''
        };

        var shortcode = '[filter_products';

        for( var index in options) {
            var value = table.find('#filter_products-' + index).val();

            if ( value !== options[index] && (typeof value !== 'undefined'))
                shortcode += ' ' + index + '="' + value + '"';
        }

        shortcode += ']Insert Filter Products Tab Shortcodes[/filter_products]';

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        tb_remove();
    });
});



jQuery(function($) {

    var form = jQuery('<div id="filter_products_tab-form"><table id="filter_products_tab-table" class="form-table">\
            <tr>\
				<th><label for="filter_products_tab-title">Title</label></th>\
				<td><input type="text" name="title" id="filter_products_tab-title" value="" /></td>\
			</tr>\
            <tr>\
				<th><label for="filter_products_tab-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="filter_products_tab-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
            <tr>\
				<th><label for="filter_products_tab-active">Active</label></th>\
				<td><select name="active" id="filter_products_tab-active">\
                ' + fastor_shortcode_yes_no() + '\
				</select></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="filter_products_tab-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#filter_products_tab-submit').click(function(){

        var options = {
            'title'              : '',
            'active'              : '',
            'class'              : ''
        };

        var shortcode = '[filter_products_tab';

        for( var index in options) {
            var value = table.find('#filter_products_tab-' + index).val();

            if ( value !== options[index] && (typeof value !== 'undefined'))
                shortcode += ' ' + index + '="' + value + '"';
        }

        shortcode += ']';

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        tb_remove();
    });
});
