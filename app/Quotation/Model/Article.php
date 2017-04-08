<?php

namespace Quotation\Model;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    protected $primaryKey = 'id_article';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categorie()
    {
        return $this->hasOne('Quotation\Model\Categorie', 'id_categorie');
    }
}
