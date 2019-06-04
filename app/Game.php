<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            $model->forceFill([
                'user_id' => auth()->id()
            ]);
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
