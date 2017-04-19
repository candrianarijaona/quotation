jQuery(function () {
    //DATATABLE
    $('.datatable').dataTable();

    //SELECT 2
    $('select.select2').each(function() {
        var $this = $(this),
            width = $this.attr('data-select-width') || '100%';
        //, _showSearchInput = $this.attr('data-select-search') === 'true';
        $this.select2({
            formatMatches: function() {
                return '';
            },
            //showSearchInput : _showSearchInput,
            allowClear : true,
            width : width
        });

        //clear memory reference
        $this = null;
    });

    //DATEPICKER
    $('.datepicker input').each(function() {

        var $this = $(this),
            dataDateFormat = $this.attr('data-dateformat') || 'yy-mm-dd';

        $this.datepicker({
            dateFormat : dataDateFormat,
            prevText : '<i class="fa fa-chevron-left"></i>',
            nextText : '<i class="fa fa-chevron-right"></i>',
        });

        //clear memory reference
        $this = null;
    });
});
