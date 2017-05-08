<?php

namespace Quotation\Model;


use Valitron\Validator;

class Hotel extends BaseModel
{
    protected $table = 'hotel';

    protected $primaryKey = 'id_hotel';


    protected $guarded = ['id_hotel'];

    public function ville()
    {
        return $this->hasOne(Ville::class, 'id_ville', 'id_ville');
    }

    /**
     * @param $data
     * @return void
     */
    protected function setValidator($data)
    {
        $this->validator = new Validator($data, [], 'fr');

        $this->validator->rule('required', 'id_ville');

        $this->validator
            ->rule('required', 'label')
            ->rule('lengthBetween', 'label', 5, 100);

        $this->validator->rule('required', 'categorie');
        $this->validator
            ->rule('required', 'prix_single')
            ->rule('numeric', 'prix_single');

        $this->validator
            ->rule('required', 'prix_double')
            ->rule('numeric', 'prix_double');

        $this->validator
            ->labels([
                'id_ville' => 'La ville',
                'label' => 'Le nom de l\'hotel',
                'categorie' => 'Catégorie',
            ]);
    }
}
