<?php

namespace Quotation\Model;


use Valitron\Validator;

class Hotel extends BaseModel
{
    protected $table = 'hotel';

    protected $primaryKey = 'id_hotel';

    protected $fillable = ['label', 'categorie', 'prix_single'];

    /**
     * @param $data
     * @return void
     */
    protected function setValidator($data)
    {
        $this->validator = new Validator($data, [], 'fr');

        $this->validator
            ->rule('required', 'label')
            ->rule('lengthBetween', 'label', 5, 100);

        $this->validator->rule('required', 'categorie');
        $this->validator
            ->labels([
                'label' => 'Le nom de l\'hotel',
                'categorie' => 'Catégorie',
            ]);
    }
}
