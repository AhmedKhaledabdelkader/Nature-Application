<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
       public $incrementing = false;
    protected $keyType = 'string';


protected $fillable = [

    "name",
    "tagline"


];


use HasTranslations ;

    protected $translatable = [
        'name',
        'tagline'
    
    ];

    protected $casts = [
    'name' => 'array',
    'tagline' => 'array',
     'subsections_publish_locales' => 'array',
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

 public function subsection()
    {
        return $this->hasMany(Subsection::class);
    }



}
