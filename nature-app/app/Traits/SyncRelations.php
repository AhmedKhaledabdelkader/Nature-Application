<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait SyncRelations
{


     protected function syncRelation(
        Model $model,
        string $relation,
        array $ids = []
    ): void {
        if (!empty($ids) && method_exists($model, $relation)) {
            $model->{$relation}()->sync($ids);
        }
    }





    
}
