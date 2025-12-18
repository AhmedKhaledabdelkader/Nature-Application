<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Provided_Service extends Model
{


      use HasTranslations ;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['title','sub_title','color'];


    public $translatable = ['title','sub_title'];

        public function setLocalizedValue(string $field, string $locale, $value): void
        {
            $this->setTranslation($field, $locale, $value);
        }

     protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }



    

    
}
