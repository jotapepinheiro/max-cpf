<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedBy
{
    protected static function boot()
    {
        parent::boot();

        if(Auth::user()) {
            static::creating(function($model)
            {
                $userId = Auth::id();
                $model->createdBy = $userId;
            });
            static::updating(function($model)
            {
                $userId = Auth::id();
                $model->updatedBy = $userId;
            });
        }

    }

}
