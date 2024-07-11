<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogFile extends Model
{
    use HasFactory;
    protected $fillable = ['*'];
    public function object()
    {
        return $this->morphTo();
    }
}
