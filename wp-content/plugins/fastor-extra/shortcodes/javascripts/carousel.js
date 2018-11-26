
jQuery(function($) {

    var form = jQuery('<div id="carousel-form"><table id="carousel-table" class="form-table">\
			<tr>\
				<th><label for="carousel-title">Title</label></th>\
				<td><input type="text" name="title" id="carousel-title" value="" /></td>\
			</tr>\
            <tr>\
				<th><label for="carousel-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="carousel-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="carousel-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#carousel-submit').click(function(){

        var options = {
            'title'              : '',
            'class'              : ''
        };

        var shortcode = '[carousel';

        for( var index in options) {
            var value = table.find('#carousel-' + index).val();

            if ( value !== options[index] && (typeof value !== 'undefined'))
                shortcode += ' ' + index + '="' + value + '"';
        }

        shortcode += ']Insert Carousel Shortcodes[/carousel]';

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        tb_remove();
    });
});



jQuery(function($) {

    var form = jQuery('<div id="carousel_item-form"><table id="carousel_item-table" class="form-table">\
            <tr>\
				<th><label for="carousel_item-desc">Content</label></th>\
				<td><textarea name="desc" id="carousel_item-desc"></textarea></td>\
			</tr>\
            <tr>\
				<th><label for="carousel_item-class">Custom Class</label></th>\
				<td><input type="text" name="class" id="carousel_item-class" value="" />\
				<br/><small>can add margin classes like "m-t-xxl m-b-xxl"</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="carousel_item-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();

    form.find('#carousel_item-submit').click(function(){

        var options = {
            'desc'              : '',
            'class'              : ''
        };

        var shortcode = '[carousel_item';

        for( var index in options) {
            var value = table.find('#carousel_item-' + index).val();

            if ( value !== options[index] && (typeof value !== 'undefined'))
                shortcode += ' ' + index + '="' + value + '"';
        }

        shortcode += ']';

        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        tb_remove();
    });
});
