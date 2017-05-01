jQuery(function () {
    var prestationForm = $('#prestationForm');

    var devisPrestations = [];

    $(document).on('click', '.jqEditPrestation', function () {
        var idDevisPrestation = $(this).data('id');
        prestationForm.fill(devisPrestations[idDevisPrestation]);
    });

    prestationForm.fill = function (devisPrestation) {
        $('#id_prestation').val(devisPrestation.id_prestation).trigger('change');
        $('#qte_prestation')
            .val(devisPrestation.qte_prestation)
            .focus();
        $('#prix_prestation').val(devisPrestation.prix_prestation);
        $('#montant_prestation').val(devisPrestation.qte_prestation * devisPrestation.prix_prestation);

    };

    var printPrestation = function (prestation) {
        $('#tbodyPrestation').append('<tr>' +
            '<td>' + prestation.label + '</td>' +
            '<td>' + prestation.qte_prestation + '</td>' +
            '<td>' + prestation.prix_prestation + '</td>' +
            '<td>' + (prestation.qte_prestation * prestation.prix_prestation) + '</td>' +
            '<td>' +
                '<a href="#" class="btn btn-primary jqEditPrestation" data-id="' + prestation.id_devis_prestation + '"><i class="fa fa-pencil-square-o"></i></a>' +
                '<a href="#" class="btn btn-danger jqDeletePrestation" data-id="' + prestation.id_devis_prestation + '"><i class="fa fa-trash-o"></i></a>' +
            '</td>' +
        '</tr>');
    };

    var prestationLoad = function (idDevis, journee) {
        $('#tbodyPrestation').html('');
        var totalPrestation = 0;
        $.ajax({
            url: '/devis/prestation/load/' + idDevis + '/' + journee,
            method: "GET",
            dataType: "json"
        }).done(function (data) {
            if (data.devisPrestations.length) {
                devisPrestations = [];

                data.devisPrestations.forEach(function (dp) {
                    devisPrestations[dp.id_devis_prestation] = dp;
                    printPrestation(dp);
                    totalPrestation += dp.qte_prestation * dp.prix_prestation
                });

                $('#totalPrestation').html(totalPrestation);
            }
        });
    };

    prestationLoad($('#id_devis').val(), $('#journee').html());

    prestationForm.find("input:text").keyup(function () {
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

    });

    prestationForm.find('#id_prestation').change(function () {
        $('#prix_prestation').val($(this).find('option:selected').attr('title'));
    });

    //Submit Form
    prestationForm.submit(function () {

        if (!$('#id_prestation').val()) {
            return false;
        }

        var formValues = $('#prestationForm').serialize();

        $('#successPrestation').hide();

        $.ajax({
            url: '/devis/prestation/save',
            method: "POST",
            dataType: "json",
            data: {
                data: formValues,
                journee: $('#journee').html(),
                id_devis: $('#id_devis').val()
            }
        }).done(function (data) {
            if (data.id_devis_prestation) {
                prestationLoad($('#id_devis').val(), $('#journee').html());
            }
            $('#successPrestation').show();
        });

        return false;
    })
});
