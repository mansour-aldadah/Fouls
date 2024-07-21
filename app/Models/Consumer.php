<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'name',
    ];

    public function subConsumers()
    {
        return $this->hasMany(SubConsumer::class, 'consumer_id', 'id');
    }
    public function userConsumers()
    {
        return $this->hasMany(UserConsumer::class, 'user_consumers_id', 'id');
    }

    public function operations()
    {
        return $this->hasManyThrough(Operation::class, SubConsumer::class, 'consumer_id', 'sub_consumer_id')->where('isClosed', false);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_consumers');
    }
}
