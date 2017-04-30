<?php

namespace Quotation\Model\Devis;


use Quotation\Model\BaseModel;

class DevisHotel extends BaseModel
{
    protected $table = 'devis_hotel';

    protected $primaryKey = 'id_devis_hotel';

    protected $guarded = ['id_devis_hotel'];

    protected function setValidator($data)
    {
        // TODO: Implement setValidator() method.
    }
}
