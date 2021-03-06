/*
 * This file is part of the jQuery package.
 *
 * (c) Olivier Chauvel <olchauvel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 (function ($) {
    var params = {
        i18n: {
            add: 'Add collection',
            confirm: 'Are you sure ?',
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
            el.parent().attr('class', 'field').append(
                $('<div>', {'class': 'description'}).html(el.html()),
                $('<div>', {'class': 'actions'}).append(
                    $('<a>', {
                        href: '#',
                        title: params.i18n.remove,
                        'class': 'icon-16 delete'
                    }).html(params.i18n.remove).click(function() {
                        if (confirm(params.i18n.confirm)) {
                            $(this).parents('.field').remove();
                        }
                    })
                ));

            el.prev().remove();
            el.remove();
        },
        init: function (el) {
            nodes = el.children().children();

            nodes.filter('div').each(function () {
                methods.create_bandeau($(this));
            });

            if (!el.hasClass('collection')) {
                el.addClass('collection');
            }

            el.after(
                $('<a>', {
                    href: '#',
                    title: params.i18n.add,
                    'class': 'add_collection'
                }).html(params.i18n.add).append(
                    $('<span>', {'class': 'icon-16 add'})
                ).click(function() {
                    methods.add_collection(jQuery(this).prev());
                })
            );
        }
    }

    $.fn.genemuCollection = function (options) {
        params = $.extend(params, options);

        $this = $(this);
        methods.init($this);

        return $this;
    };
})(jQuery);
