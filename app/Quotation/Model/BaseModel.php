<?php

namespace Quotation\Model;


use Illuminate\Database\Eloquent\Model;
use Valitron\Validator;

/**
 * Class BaseModel
 * @package Quotation\Model
 * @property-read Validator $validator
 */
abstract class BaseModel extends Model
{

    /**
     * Turn off the created_at & updated_at columns
     * @var boolean
     */
    public $timestamps = false;

    protected $validator;

    protected $errors = [];

    /**
     * @param $data
     * @return void
     */
    abstract protected function setValidator($data);

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    protected function validate($data)
    {

        $this->setValidator($data);

        if (!$this->validator->validate()) {
            $this->errors = $this->validator->errors();
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
