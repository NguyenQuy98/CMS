
jQuery(function($) {

    var form = jQuery('<div id="camera_slider-form"><table id="camera_slider-table" class="form-table">\
			<tr>\
				<th><label for="camera_slider-pagination">Pagination</label></th>\
                <td><select name="pagination" id="camera_slider-pagination">\
                ' + fastor_shortcode_boolean_false() + '\
				</select></td>\
            </tr>\
			<tr>\
				<th><label for="camera_slider-navigation">Navigation</label></th>\
                <td><select name="navigation" id="camera_slider-navigation">\
                ' + fastor_shortcode_boolean_true() + '\
				</select></td>\
            </tr>\
			<tr>\
				<th><label for="camera_slider-layout_type">Layout Type</label></th>\
                <td><select name="layout_type" id="camera_slider-layout_type">\
                ' + fastor_shortcode_layout_type() + '\
				</select></td>\
            </tr>\
            <tr>\
				<th><label for="camera_slider-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="camera_slider-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="camera_slider-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#camera_slider-submit').click(function(){

        var options = {
            'pagination'         : 'false',
            'navigation'         : 'true',
            'layout_type'     : '',
            'class'              : ''
        };

        var shortcode = '[camera_slider';

        for( var index in options) {
            var value = table.find('#camera_slider-' + index).val();

            if ( value !== options[index] && (typeof value !== 'undefined'))
                shortcode += ' ' + index + '="' + value + '"';
        }

        shortcode += ']Insert Camera Slide Shortcodes[/camera_slider]';

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        tb_remove();
    });
});


jQuery(function($) {

    var form = jQuery('<div id="camera_slide-form"><table id="camera_slide-table" class="form-table">\
			<tr>\
				<th><label for="camera_slide-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="camera_slide-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="camera_slide-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#camera_slide-submit').click(function(){

        var options = {
            'class'              : ''
        };

        var shortcode = '[camera_slide';

        for( var index in options) {
            var value = table.find('#camera_slide-' + index).val();

            if ( value !== options[index] && (typeof value !== 'undefined'))
                shortcode += ' ' + index + '="' + value + '"';
        }

        shortcode += ']Insert Content[/camera_slide]';

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        tb_remove();
    });
});
