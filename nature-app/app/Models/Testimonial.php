<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Testimonial extends Model
{


    public $incrementing = false;
    protected $keyType = 'string';


     use HasTranslations ;



     protected $fillable = ["feedback","name","job_title","company_name"];

    public $translatable = ['feedback', 'job_title'];


     protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }



    
        public function setLocalizedValue(string $field, string $locale, $value): void
        {
            $this->setTranslation($field, $locale, $value);
        }



    
}
