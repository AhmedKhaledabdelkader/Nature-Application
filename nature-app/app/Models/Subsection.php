<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Subsection extends Model
{
       public $incrementing = false;
    protected $keyType = 'string';



protected $fillable = [

    'title',
    'subtitle'

];

use HasTranslations ;

 protected $translatable = [
        'title',
        'subtitle'
    
    ];

   protected $casts = [
    'title' => 'array',
    'subtitle' => 'array',
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



 public function section()
    {
        return $this->belongsTo(Section::class);
    }


}
