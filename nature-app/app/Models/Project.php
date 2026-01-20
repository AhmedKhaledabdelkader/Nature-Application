<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;


class Project extends Model
{

       public $incrementing = false;
    protected $keyType = 'string';


    use HasTranslations ;


    
    protected $fillable = [
        'name',
        'image_before',
        'image_after',
        'overview',
        'brief',
        'gallery',
        'start_date',
        'end_date',
        'results',
        'metrics',
        'country_id',
        'city_id',
        'status'
    ];

    protected $translatable = [
        'name',
        'overview',
        'start_date',
        'end_date',
        'brief',
    
    ];

    protected $casts = [
        'gallery' => 'array',
        'results'=>'array',
        'metrics'=>'array'
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



 public function country()
    {
        return $this->belongsTo(Country::class);
    }


 public function city()
    {
        return $this->belongsTo(City::class);
    }





public function services()
{
    return $this->belongsToMany(ServiceV2::class, 'project_service_v2_s', 'project_id', 'service_v2_id');
}



    
}
