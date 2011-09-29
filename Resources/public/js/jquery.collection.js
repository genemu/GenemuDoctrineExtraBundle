/*
 * This file is part of the jQuery package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 (function($) {
    var params = {
        i18n: {
            add: 'Add collection',
            edit: 'Edit',
            remove: 'Remove'
        }
    };

    var methods = {
        add_collection: function (el) {
            index = el.children().length;
            node = $(el.attr('data-prototype').replace(/\$\$name\$\$/g, index));

            el.append(node);
            methods.create_bandeau(node.children().filter('div'));
        },
        create_bandeau: function (el) {
            el.hide().prev().hide();

            bandeau = $('<div>', {'class': 'description'});
            el.find('label').each(function () {
                title = $(this).text();
                value = $(this).next().val();

                bandeau.append($('<p>').html('<p><strong>'+title+':</strong> '+value+'</p>'));
            });

            el.parent().prepend($('<div>', {'class': 'bandeau'}).append(
                bandeau,
                $('<div>', {'class': 'actions'}).append(
                    $('<button>', {'type': 'button', 'class': 'edit'}).html(params.i18n.edit).click(function() {
                        $(this).parents('.bandeau').siblings('div').toggle();
                    }),
                    $('<button>', {'type': 'button', 'class': 'delete'}).html(params.i18n.remove).click(function() {
                        $(this).parents('.bandeau').parent().remove();
                    })
                )
            ));
        },
        init: function (el) {
            nodes = el.children().children();

            nodes.filter('div').each(function () {
                methods.create_bandeau($(this));
            });

            el.after(
                $('<button>', {'type': 'button'}).html(params.i18n.add).click(function() {
                    methods.add_collection(jQuery(this).prev());
                })
            );
        }
    }

    $.fn.genemuCollection = function(options) {
        params = $.extend(params, options);

        $this = $(this);
        methods.init($this);

        return $this;
    };
})(jQuery);
