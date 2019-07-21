<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'turnner_id', 'is_end'
    ];

    protected $casts = [
        'turnner_id' => 'integer',
        'is_end' => 'integer'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            $model->forceFill([
                'user_id' => auth()->id()
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function opponent()
    {
        return $this->users->except($this->user->id)->first();
    }

    public function gameMoves()
    {
        return $this->hasMany(GameMove::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
