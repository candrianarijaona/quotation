<?php

namespace Quotation\Model;


use Valitron\Validator;

class Client extends BaseModel
{
    protected $table = 'client';

    protected $primaryKey = 'id_client';

    protected $fillable = ['civility', 'last_name', 'first_name', 'email', 'phone', 'adresse'];

    /**
     * @param $data
     * @return void
     */
    protected function setValidator($data)
    {
        $this->validator = new Validator($data, [], 'fr');

        $this->validator
            ->rule('required', 'civility');

        $this->validator
            ->rule('required', 'last_name')
            ->rule('lengthBetween', 'last_name', 5, 100);

        $this->validator
            ->rule('email', 'email');

        $this->validator
            ->labels([
                'civility' => 'La civilité',
                'last_name' => 'Le nom',
                'email' => 'L\'adresse email',
            ]);
    }
}
