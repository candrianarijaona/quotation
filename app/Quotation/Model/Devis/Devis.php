<?php

namespace Quotation\Model\Devis;


use Quotation\Model\BaseModel;
use Quotation\Model\Client;

class Devis extends BaseModel
{

    protected $table = 'devis';

    protected $primaryKey = 'id_devis';

    protected $guarded = ['id_devis'];

    /**
     * @return Client|null
     **/
    protected function client()
    {
        return $this->hasOne(Client::class, 'id_client', 'id_client');
    }

    /**
     * @param $data
     */
    protected function setValidator($data)
    {
        // TODO: Implement setValidator() method.
    }
}
