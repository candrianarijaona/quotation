<?php

namespace Quotation\Model;


use Valitron\Validator;

class Article extends BaseModel
{
    protected $table = 'article';

    protected $primaryKey = 'id_article';

    protected $fillable = ['label', 'id_categorie', 'unite'];

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
            ->rule('required', 'unite');

        $this->validator
            ->rule('required', 'id_categorie');

        $this->validator
            ->labels([
                'label' => 'La désignation',
                'unite' => 'L\'unité',
                'id_categorie' => 'La catégorie'
            ]);
    }
}
