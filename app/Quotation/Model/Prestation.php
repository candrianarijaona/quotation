<?php

namespace Quotation\Model;

use Valitron\Validator;

class Prestation extends BaseModel
{
    protected $table = 'prestation';

    protected $primaryKey = 'id_prestation';

    protected $guarded = ['id_prestation'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categorie()
    {
        return $this->hasOne('Quotation\Model\Categorie', 'id_categorie', 'id_categorie');
    }

    /**
     * @param $data
     * @return void
     */
    protected function setValidator($data)
    {
        $this->validator = new Validator($data, [], 'fr');

        $this->validator
            ->rule('required', 'label')
            ->rule('lengthBetween', 'label', 2, 100);

        $this->validator
            ->rule('required', 'type');

        $this->validator
            ->rule('required', 'prix');

        $this->validator
            ->labels([
                'label' => 'La désignation',
                'type' => 'Le type',
                'prix' => 'Le prix',
            ]);
    }
}
