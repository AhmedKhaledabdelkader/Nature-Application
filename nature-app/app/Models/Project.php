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
        'result',
        'project_reflected',
        'country_id',
        'city_id',
    ];

    protected $translatable = [
        'name',
        'overview',
        'start_date',
        'end_date',
        'brief',
        'result',
        'project_reflected',
    ];

    protected $casts = [
        'gallery' => 'array',
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
    return $this->belongsToMany(Provided_Service::class, 'project_provided__service');
}






    
}
