<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Classe modelo de orçamentos
 * 
 * @author Jonathan David Mendes Lopes
 * @version 1.1
 */
class Estimate extends Model
{
    protected $guarded = [];
    /**
     * Define a relação muitos-para-um de orçamento para usuário(vendedor) 
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
