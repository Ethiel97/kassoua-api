<?php
/**
 * Created by PhpStorm.
 * User: Ethiel
 * Date: 20/10/2017
 * Time: 00:55
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{

    protected $fillable = ['product_id', 'filename'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}