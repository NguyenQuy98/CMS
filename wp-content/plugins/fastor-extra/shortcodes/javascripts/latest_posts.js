
jQuery(function($) {

    var form = jQuery('<div id="latest_posts-form"><table id="latest_posts-table" class="form-table">\
            <tr>\
				<th colspan="2"><strong>Input block id or name.</strong></th>\
			</tr>\
			<tr>\
				<th><label for="block-title">Title *</label></th>\
				<td><input type="text" name="title" id="block-title" value="" /></td>\
			</tr>\
			<tr>\
				<th><label for="block-limit">Limit</label></th>\
				<td><input type="text" name="title" id="block-limit" value="" /></td>\
			</tr>\
			<tr>\
				<th><label for="latest_posts-layout_type">Layout Type</label></th>\
                <td><select name="layout_type" id="latest_posts-layout_type">\
                ' + fastor_shortcode_posts_layout_type() + '\
				</select></td>\
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

    form.find('#latest_posts-submit').click(function(){

        var options = {
            'title'               : '',
            'limit'               : '3',
            'layout_type'            : 'default',
            'class'              : ''
        };

        var shortcode = '[latest_posts';

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
