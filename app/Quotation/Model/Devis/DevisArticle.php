<?php

namespace Quotation\Model\Devis;


use Quotation\Model\BaseModel;

class DevisArticle extends BaseModel
{
    protected $table = 'devis_article';

    protected $primaryKey = 'id_devis_article';

    protected $guarded = ['id_devis_article'];

    protected function setValidator($data)
    {
        // TODO: Implement setValidator() method.
    }
}
