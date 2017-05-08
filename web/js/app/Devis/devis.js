/**
 * Created by samue on 01/05/2017.
 */
jQuery(function () {

    var Devis = {idDevis : $('#id_devis').val(), nbDays : $('#nb_jours') .val(), total : 0};

    Devis.populate = function(day) {
        //Start for day one
        day = day ? day : 1;

        if (day <= Devis.nbDays) {
            $.ajax({
                url: '/devis/total/' + Devis.idDevis + '/' + day,
                method: "GET",
                dataType: "json"
            }).done(function (data) {
                $('#jqTotalJournee_' + day).html(data.total.toLocaleString());
                Devis.total += data.total;
                Devis.populate(++day);
            });
        } else {
            var totalDevisEuro = 0;
            var coursEuro = $('#cours_euro').val();

            $('#grandTotalDevis').html(Devis.total.toLocaleString());
            if (coursEuro) {
                totalDevisEuro = (Devis.total / coursEuro).toFixed(2);
            }

            $('#grandTotalDevisEuro').html(totalDevisEuro.toLocaleString());
        }
    };

    if (Devis.nbDays) {
        Devis.populate();
    }

    Devis.repopulate = function () {
        Devis.total = 0;
        Devis.populate();
    };

    $('#jqRepopulateDevis').click(function () {
        Devis.repopulate();
    })
});
