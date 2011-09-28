/*
 * This file is part of the jQuery package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 (function($) {
    var $this = null;

    var methods = {
        add_collection: function(el) {
            index = el.children().length;

            el.append(
                $(el.attr('data-prototype').replace(/\$\$name\$\$/g, index))
                    .children()
                        .hide()
                        .children()
                            .filter('#'+el.attr('id')+'_'+index+'_ordering')
                                .val(index)
                            .end()
                        .end()
                    .end()
                    .prepend($('<div>', {'class': 'bandeau'}).append(
                        $('<div>', {'class': 'description'}).html('Description'),
                        $('<div>', {'class': 'actions'}).append(
                            $('<button>', {'type': 'button', 'class': 'edit'}).html('Edit').click(function() {
                                $(this).parents('.bandeau').siblings('div').toggle();
                            }),
                            $('<button>', {'type': 'button', 'class': 'delete'}).html('Delete').click(function() {
                                $(this).parents('.bandeau').parent().remove();
                            })
                        )
                    ))
            );
        }
    }

    $.fn.genemuCollection = function() {
        $this = $(this);

        $this
            .children()
            .children().hide().end()
            .prepend($('<div>', {'class': 'bandeau'}).append(
                $('<div>', {'class': 'description'}).html('Description'),
                $('<div>', {'class': 'actions'}).append(
                    $('<button>', {'type': 'button', 'class': 'edit'}).html('Edit').click(function() {
                        $(this).parents('.bandeau').siblings('div').toggle();
                    }),
                    $('<button>', {'type': 'button', 'class': 'delete'}).html('Delete').click(function() {
                        $(this).parents('.bandeau').parent().remove();
                    })
                )
            ));

        $this.after(
            $('<button>', {'type': 'button'}).html('Add collection').click(function() {
                methods.add_collection(jQuery(this).prev());
            })
        );

        return $this;
    };
})(jQuery);
