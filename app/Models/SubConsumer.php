<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Type\Integer;

class SubConsumer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'details', 'consumer_id'];

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'consumer_id', 'id')->withTrashed();
    }

    public static function numberOfSubConsumers()
    {
        return static::count();
    }
    public function getDistance()
    {
        $last = ($this->movementRecord()->orderByDesc('date')->orderByDesc('created_at')->get()[0]->record) ?? 0;
        $beforeLast = ($this->movementRecord()->orderByDesc('date')->orderByDesc('created_at')->get()[1]->record) ?? 0;
        if ($beforeLast == 0) {
            return 0;
        }
        return +$last - +$beforeLast;
    }

    public function operations()
    {
        return $this->hasMany(Operation::class, 'sub_consumer_id', 'id');
    }
    public function movementRecord()
    {
        return $this->hasMany(MovementRecord::class, 'sub_consumer_id', 'id');
    }
}
