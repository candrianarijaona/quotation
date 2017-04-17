<?php

namespace Quotation\Model;

use Valitron\Validator;

class Categorie extends BaseModel
{
    protected $table = 'categorie';

    protected $primaryKey = 'id_categorie';

    protected $fillable = ['label'];

    /**
     * @param $data
     * @return void
     */
    public function setValidator($data)
    {
        $this->validator = new Validator($data, [], 'fr');

        $this->validator
            ->rule('required', 'label')
            ->rule('lengthBetween', 'label', 5, 100)
            ->labels([
                'label' => 'Désignation',
            ]);
    }

}
