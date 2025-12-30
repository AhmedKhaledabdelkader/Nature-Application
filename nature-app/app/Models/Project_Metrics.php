<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Project_Metrics extends Model
{

     public $incrementing = false;
    protected $keyType = 'string';



    protected $fillable = [
        'metric_name',
        'metric_value',
        'trend',
        'project_id',
    ];


   use HasTranslations ;


    public $translatable = [
        'metric_name',
        'metric_value',
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }




}
