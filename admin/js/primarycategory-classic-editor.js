(function ($) {
    $(document).on({
        change: function () {

            var selectedValue = jQuery(this).val();
            var selectedText = jQuery(this).parent().text();

            if (this.checked) {
                jQuery('#primary_category_select').append(jQuery('<option>', {
                    value: selectedValue,
                    text: selectedText,
                }));
            } else {

                jQuery('#primary_category_select option[value="' + selectedValue + '"]').remove();
            }
        }
    }, '#taxonomy-category :checkbox');

})(jQuery);





