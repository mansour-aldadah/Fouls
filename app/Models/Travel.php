<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'road', 'couse', 'sub_consumer_id'];

    public function subConsumer()
    {
        return $this->belongsTo(SubConsumer::class, 'sub_consumer_id', 'id');
    }
}
