jQuery(function () {
    var articleForm = $('#articleForm');

    var devisArticles = [];

    $(document).on('click', '.jqEditArticle', function () {
        var idDevisArticle = $(this).data('id');
        articleForm.fill(devisArticles[idDevisArticle]);
    });

    articleForm.fill = function (devisArticle) {
        $('#id_article').val(devisArticle.id_article).trigger('change');
        $('#qte_article')
            .val(devisArticle.qte_article)
            .focus();
        $('#prix_article').val(devisArticle.prix_article);
        $('#montant_article').val(devisArticle.qte_article * devisArticle.prix_article);

    };

    articleForm.clear = function() {
        $('#id_article').val('').trigger('change');
        $('#qte_article')
            .val('')
            .focus();
        $('#prix_article').val('');
        $('#montant_article').val('');
    }


    var printArticle = function (article) {
        $('#tbodyArticle').append('<tr>' +
            '<td>' + article.label + '</td>' +
            '<td>' + article.qte_article + '</td>' +
            '<td>' + article.prix_article + '</td>' +
            '<td>' + (article.qte_article * article.prix_article) + '</td>' +
            '<td>' +
                '<a href="#" class="btn btn-primary jqEditArticle" data-id="' + article.id_devis_article + '"><i class="fa fa-pencil-square-o"></i></a>' +
                '<a href="#" class="btn btn-danger jqDeleteArticle" data-id="' + article.id_devis_article + '"><i class="fa fa-trash-o"></i></a>' +
            '</td>' +
        '</tr>');
    };

    var articleLoad = function (idDevis, journee) {
        $('#tbodyArticle').html('');
        var totalArticle = 0;
        $.ajax({
            url: '/devis/article/load/' + idDevis + '/' + journee,
            method: "GET",
            dataType: "json"
        }).done(function (data) {
            if (data.devisArticles.length) {
                devisArticles = [];

                data.devisArticles.forEach(function (dp) {
                    devisArticles[dp.id_devis_article] = dp;
                    printArticle(dp);
                    totalArticle += dp.qte_article * dp.prix_article
                });

                $('#totalArticle').html(totalArticle.toLocaleString());
            }
        });
    };

    articleLoad($('#id_devis').val(), $('#journee').html());

    articleForm.find("input:text").keyup(function () {
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

    articleForm.find('#id_article').change(function () {
        $('#prix_article').val($(this).find('option:selected').attr('title'));
        $('#qte_article').trigger('keyup').focus();
    });

    //Submit Form
    articleForm.submit(function () {

        if (!$('#id_article').val()) {
            return false;
        }

        var formValues = $('#articleForm').serialize();

        $('#successArticle').hide();

        $.ajax({
            url: '/devis/article/save',
            method: "POST",
            dataType: "json",
            data: {
                data: formValues,
                journee: $('#journee').html(),
                id_devis: $('#id_devis').val()
            }
        }).done(function (data) {
            if (data.id_devis_article) {
                articleLoad($('#id_devis').val(), $('#journee').html());
            }
            $('#successArticle').show();
            articleForm.clear();
        });

        return false;
    })
});
