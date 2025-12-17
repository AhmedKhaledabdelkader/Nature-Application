<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Award extends Model
{


    use HasTranslations ;

    
     public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'description',
        'image',
        'url',
        'organization_name',
        'organization_logo',
        'content_file',
    ];

    public $translatable = [
        'title',
        'description',
        'url',
        'organization_name',
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


    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }


    
}
