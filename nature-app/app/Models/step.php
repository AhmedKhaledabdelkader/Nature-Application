<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class step extends Model
{

 public $incrementing = false;
    protected $keyType = 'string';


    use HasTranslations ;



    protected $fillable = ['title', 'description','image'];

    public $translatable = ['title', 'description'];

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




    public function services()
    {
        return $this->belongsToMany(Provided_Service::class)
            ->withPivot('order_index');
    }

    
}
