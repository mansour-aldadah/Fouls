<?php

namespace App\Models;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;

class Operation extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id', 'date', 'sub_consumer_id', 'description', 'amount', 'type', 'foulType', 'dischangeNumber', 'receiverName'];
    protected $casts = [
        'date' => 'datetime'
    ];

    public function subConsumer()
    {
        return $this->belongsTo(SubConsumer::class, 'sub_consumer_id', 'id')->withTrashed();
    }

    public function getNewDateAttribute()
    {
        if ($this->date) {
            return $this->date->format('Y-m-d');
        }
    }
    public static function getNow()
    {
        return date('Y-M-D');
    }
    public static function getToday()
    {
        $operations = static::all()->where('type', 'صرف')->where('new_date', now()->format('Y-m-d'));
        return $operations->sum('amount') ?? 0;
    }

    public static function getWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');

        // dd($startOfWeek);

        $operations = static::all()->where('type', 'صرف')->whereBetween('new_date', [$startOfWeek, $endOfWeek]);

        return $operations->sum('amount') ?? 0;
    }
    public static function getMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth(Carbon::SATURDAY)->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth(Carbon::FRIDAY)->format('Y-m-d');

        // dd($startOfMonth);

        $operations = static::all()->where('type', 'صرف')->whereBetween('new_date', [$startOfMonth, $endOfMonth]);

        return $operations->sum('amount') ?? 0;
    }
    public static function getIncomeMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth(Carbon::SATURDAY)->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth(Carbon::FRIDAY)->format('Y-m-d');

        // dd($startOfMonth);

        $operations = static::all()->where('type', 'وارد')->whereBetween('new_date', [$startOfMonth, $endOfMonth]);

        return $operations->sum('amount') ?? 0;
    }
    public static function getOutcomes()
    {
        $operations = static::all()->where('type', 'صرف');
        $outcomes = 0;
        foreach ($operations as $operation) {
            $outcomes += $operation->amount;
        }
        return $outcomes;
    }
    public static function getIncomes()
    {
        $operations = static::all()->where('type', 'وارد');
        $incomes = 0;
        foreach ($operations as $operation) {
            $incomes += $operation->amount;
        }
        return $incomes;
    }
    public static function getTotal()
    {
        return static::getIncomes() - static::getOutcomes();
    }

    public static function getExistOF($foulType)
    {
        $operationsIn = Operation::all()->where('foulType', $foulType)->where('type', 'وارد')->sum('amount');
        $operationsOut = Operation::all()->where('foulType', $foulType)->where('type', 'صرف')->sum('amount');
        $amounts = $operationsIn - $operationsOut;
        return $amounts;
    }
}
