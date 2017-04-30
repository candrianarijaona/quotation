jQuery(function () {
    var calculMontantHotel;
    var hotelForm = $('#hotelForm');

    hotelForm.find("input:text").keyup(function () {
        var _this = $(this);
        var id = _this.attr('id');
        var eltId = null;

        if (id.indexOf('prix') !== -1) {
            eltId = id.replace('prix_', '');
        } else if (id.indexOf('qte') !== -1) {
            eltId = id.replace('qte_', '');
        }

        if (eltId) {
            jQuery('#montant_' + eltId).val(jQuery('#qte_' + eltId).val() * jQuery('#prix_' + eltId).val());
        }

        calculMontantHotel();
    });

    calculMontantHotel = function () {
        var montant = 0;

        hotelForm.find("input:text").each(function () {
            var _this = $(this);
            var id = _this.attr('id');

            if (id.indexOf('montant') !== -1) {
                montant += parseFloat(_this.val());
            }
        });

        $('#total_hotel').val(montant);
    };

    calculMontantHotel();

    //Submit Form
    hotelForm.submit(function () {

        if (!$('#id_hotel').val()) {
            return false;
        }

        var formValues = $('#hotelForm').serialize();

        $('#successHotel').hide();

        $.ajax({
            url: '/devis/hotel/save',
            method: "POST",
            dataType: "json",
            data: {
                data: formValues,
                journee: $('#journee').html(),
                id_devis: $('#id_devis').val()
            }
        }).done(function (data) {
            if (data.id_devis_hotel) {
                $('#successHotel').show();
            }
        });

        return false;
    })
});
