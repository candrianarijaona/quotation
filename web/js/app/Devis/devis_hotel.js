jQuery(function () {
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

        hotelForm.calculMontant();
    });

    hotelForm.calculMontant = function () {
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

    hotelForm.calculMontant();

    hotelForm.fill = function(hotel) {
        $('#prix_single').val(hotel.prix_single).trigger('keyup');
        $('#prix_double').val(hotel.prix_double).trigger('keyup');
        $('#prix_petit_dejeuner').val(hotel.prix_petit_dejeuner).trigger('keyup');
        $('#prix_diner').val(hotel.prix_diner).trigger('keyup');
        $('#prix_lit_supp').val(hotel.lit_supp).trigger('keyup');
        $('#prix_vignette').val(hotel.vignette).trigger('keyup');
        $('#prix_taxe').val(hotel.taxe).trigger('keyup');
    }

    hotelForm.find('#id_hotel').change(function() {
        var idHotel = $(this).val();
        if (!idHotel) {
            return ;
        }

        $.ajax({
            url: '/hotel/load/' + idHotel,
            method: "GET",
            dataType: "json"
        }).done(function (data) {
            if (data.hotel) {
                hotelForm.fill(data.hotel);
            }
        });
    });

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
