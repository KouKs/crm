

$.fn.editor = function() {

    /**
     * Hiding actual textarea
     */
    $(this).hide();
    
    /**
     * Generating div with editable content
     */
    $(this).after(
        '<div class="editor">' + 
        	'<div class="row">' + 
        		'<div class="col-12 area-2">' +
        			'<p contenteditable="true"></p>' + 
        		'</div>' +
            '</div>' +
    	'</div>'
    );

    /**
     * Generating menu
     */
    $('.editor').menu();
};


$.fn.menu = function() {

    /**
     * Generating the element
     */
    $(this).before('<ul class="editor-menu"></ul>');

    /**
     * Adding menu items
     */
    $('.editor-menu')
        .item('+ section'       , 'new-section')
        .item('+ paragraph'     , 'new-paragraph')

        .item('red-bg'          , 'major-class'     , 'theme-bg'        , /-bg$/)
        .item('white-bg'        , 'major-class'     , 'white-bg'        , /-bg$/)
        .item('dark-grey-bg'    , 'major-class'     , 'dark-grey-bg'    , /-bg$/)
        .item('light-grey-bg'   , 'major-class'     , 'light-grey-bg'   , /-bg$/)

        .item('justify'         , 'minor-class'     , 'justify'         , ['center', 'right', 'left'])
        .item('center'          , 'minor-class'     , 'center'          , ['justify', 'right', 'left'])
};

/**
 * @param label Display name
 * @param param Data parameter (be it class/color...)
 * @param data Data required
 * @param exclusive Array of exclusive classes
 */
$.fn.item = function(label, param, data = null, exclusive = /\*/) {

    /**
     * <li> element
     */
    var listItem = $('<li />');

    /**
     * Appending menu item
     */
    $(this).append(listItem);

    /**
     * Adding a label
     */
    $(listItem).html(label);

    /**
     * Preventing deselection of text
     */
    $(listItem).mousedown(function(e) {
        e.preventDefault();
    });

    /**
     * Handling the mouseup event
     */
    $(listItem).mouseup(function() {
        var s = selection();

        console.log(s);
        if(param === 'new-section') {
            $(".editor").append(
                '<div class="row">' + 
                    '<div class="col-12 area-2">' +
                        '<p contenteditable="true"></p>' + 
                    '</div>' +
                '</div>'
            );

            return;
        }

        /**
         * Cases that need selection all need to go through this condition
         */
        if($('.editor').has($(s.parent)).length === 0)
            return;

        if(param === 'new-paragraph') {
            $(s.parent).after(
                '<p contenteditable="true"></p>'
            ).next().focus();

            return;
        }

        if(param === 'major-class' || param === 'minor-class') {
            var el = param === 'major-class' ? $(s.parent).parent() : $(s.parent);

            if(exclusive instanceof Array) {
                $(el).addClass(data);

                for(key in exclusive) {
                    $(el).removeClass(exclusive[key]);
                }
            } else {
                $(el).removeClassRegExp(exclusive).addClass(data);
            }

            return;
        }
    });


    return this;
};


/**
 * Selection helper
 */
function selection() {
    sel = window.getSelection();
    if(sel !== undefined) {
        start = sel.focusOffset < sel.anchorOffset  ? sel.focusOffset : sel.anchorOffset;
        end   = sel.focusOffset > sel.anchorOffset  ? sel.focusOffset : sel.anchorOffset;

        return {
            start  : start,
            end    : end,
            text   : sel.toString(),
            parent : $(sel.focusNode).is('p') ? $(sel.focusNode) : $(sel.focusNode).parent(),
            text   : $(sel.focusNode).is('p') ? $(sel.focusNode).text() : $(sel.focusNode)
        };
    } else {
        return false;
    }
}


/**
 * removing el classes based on regular expression
 * @param regexp regular expression
 */
$.fn.removeClassRegExp = function (regexp) {
    if(regexp && (typeof regexp==='string' || typeof regexp==='object')) {
        regexp = typeof regexp === 'string' ? regexp = new RegExp(regexp) : regexp;
        $(this).each(function () {
            $(this).removeClass(function(i,c) { 
                var classes = [];
                $.each(c.split(' '), function(i,c) {
                    if(regexp.test(c)) { classes.push(c); }
                });
                return classes.join(' ');
            });
        });
    }
    return this;
};