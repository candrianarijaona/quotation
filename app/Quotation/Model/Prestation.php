<?php

namespace Quotation\Model;

use Valitron\Validator;

class Prestation extends BaseModel
{
    protected $table = 'prestation';

    protected $primaryKey = 'id_prestation';

    protected $fillable = ['label', 'type'];

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
            ->labels([
                'label' => 'La désignation',
                'type' => 'Le type',
            ]);
    }
}
