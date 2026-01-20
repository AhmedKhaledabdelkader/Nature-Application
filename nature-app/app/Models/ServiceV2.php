<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class ServiceV2 extends Model
{
use HasTranslations ;

     public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'tagline',
        'steps',
        'benefits',
        'values',
        'impacts'
    ];

    public $translatable = [
        'name',
        'tagline'
    ];

    // JSON casting
    protected $casts = [
        'steps' => 'array',
        'benefits' => 'array',
        'values' => 'array',
        'impacts' => 'array',
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

    public function projects()
{
    return $this->belongsToMany(Project::class, 'project_service_v2_s', 'service_v2_id', 'project_id');
}

    
}
