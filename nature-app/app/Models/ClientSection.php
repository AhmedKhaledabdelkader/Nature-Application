<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ClientSection extends Model
{

    public $incrementing = false;
    protected $keyType = 'string';




 

    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
        'status'
    ];



      
protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id =Str::uuid();
            }
        });
    }


    
}
