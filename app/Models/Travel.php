<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'road', 'couse', 'recordBefore', 'recordAfter',  'sub_consumer_id'];

    public function subConsumer()
    {
        return $this->belongsTo(SubConsumer::class, 'sub_consumer_id', 'id')->withTrashed();
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
