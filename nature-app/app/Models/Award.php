<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Award extends Model
{


    use HasTranslations ;

    
     public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'image',
        'organizations_logos',
        'year',
        'status'
      
    ];

    public $translatable = [
        'name',
        'description',
    ];

    protected $casts = [
    'organizations_logos' => 'array',
    'status'=>'boolean'
    
];


 
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
