<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementRecord extends Model
{
    use HasFactory;
    public function subConsumer()
    {
        return $this->belongsTo(SubConsumer::class, 'sub_consumer_id', 'id');
    }
    public function logFiles()
    {
        return $this->morphMany(LogFile::class, 'object', 'object_type', 'object_id', 'id');
    }
    public function logFile()
    {
        return $this->morphOne(LogFile::class, 'object', 'object_type', 'object_id', 'id');
    }
}
