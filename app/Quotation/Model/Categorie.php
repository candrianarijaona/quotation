<?php

namespace Quotation\Model;

use Valitron\Validator;

class Categorie extends BaseModel
{
    protected $table = 'categorie';

    protected $primaryKey = 'id_categorie';

    protected $fillable = ['label'];

    /**
     * @param array $attributes
     * @param array $options
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function update(array $attributes = [], array $options = [])
    {
        if ($this->validate($attributes)) {
            return parent::update($attributes, $options);
        }

        return false;
    }

    /**
     * @param array $attributes
     *
     * @return bool
     * @throws \Exception
     */
    public function save(array $options = [])
    {

        if ($this->validate($this->getAttributes())) {
            return parent::save();
        }

        return false;
    }

    /**
     * @param $data
     */
    public function setValidator($data)
    {
        $this->validator = new Validator($data);

        $this->validator
            ->rule('required', 'label')
            ->rule('lengthBetween', 'label', 5, 100)
            ->labels([
                'label' => 'Label',
            ]);
    }

}
