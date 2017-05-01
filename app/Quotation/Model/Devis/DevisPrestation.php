<?php

namespace Quotation\Model\Devis;


use Quotation\Model\BaseModel;

class DevisPrestation extends BaseModel
{
    protected $table = 'devis_prestation';

    protected $primaryKey = 'id_devis_prestation';

    protected $guarded = ['id_devis_prestation'];

    protected function setValidator($data)
    {
        // TODO: Implement setValidator() method.
    }
}
