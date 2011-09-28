var add = function (el) {
    var collection = jQuery('#'+el.attr('id').substr(4, 999));
    var prototype = collection.attr('data-prototype');

    form = prototype.replace(/\$\$name\$\$/g, collection.children().length);
    collection.append(form);
}

jQuery('#patterns a').click(function () {
    add(jQuery(this));
});

jQuery('#parameters a').click(function () {
    add(jQuery(this));
});
