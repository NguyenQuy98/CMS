
jQuery(function($) {

    var form = jQuery('<div id="custom_block-form"><table id="custom_block-table" class="form-table">\
            <tr>\
				<th colspan="2"><strong>Input block id or name.</strong></th>\
			</tr>\
			<tr>\
				<th><label for="block-id">Custom Block ID *</label></th>\
				<td><input type="text" name="id" id="block-id" value="" />\
				<br/><small>numerical value</small></td>\
			</tr>\
			<tr>\
				<th><label for="block-name">Custom Block Name *</label></th>\
				<td><input type="text" name="name" id="block-name" value="" /></td>\
			</tr>\
            <tr>\
				<th><label for="block-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="block-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="block-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#custom_block-submit').click(function(){

        var options = {
            'title'               : '',
            'desc'               : '',
            'class'              : ''
        };

        var shortcode = '[custom_block';

        for( var index in options) {
            var value = table.find('#custom-block-' + index).val();

            if ( value !== options[index] && (typeof value !== 'undefined'))
                shortcode += ' ' + index + '="' + value + '"';
        }

        shortcode += ']';

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        tb_remove();
    });
});
