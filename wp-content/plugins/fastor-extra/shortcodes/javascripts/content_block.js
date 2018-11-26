
jQuery(function($) {

    var form = jQuery('<div id="content_block-form"><table id="content_block-table" class="form-table">\
            <tr>\
				<th colspan="2"><strong>Input block id or name.</strong></th>\
			</tr>\
			<tr>\
				<th><label for="block-title">Title *</label></th>\
				<td><input type="text" name="title" id="content_block-title" value="" />\
			</tr>\
			<tr>\
				<th><label for="block-desc">Content*</label></th>\
				<td><textarea type="text" name="desc" id="content_block-desc" ></textarea></td>\
			</tr>\
            <tr>\
				<th><label for="content_block-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="content_block-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="content_block-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#content_block-submit').click(function(){

        var options = {
            'id'                 : '',
            'title'               : '',
            'desc'               : '',
            'class'              : ''
        };

        var shortcode = '[content_block';

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
