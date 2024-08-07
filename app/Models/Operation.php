<?php

namespace App\Models;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Operation extends Model
{
    use HasFactory;
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
    public function getmonthAttribute()
    {
        if ($this->date) {
            return $this->date->format('Y-m');
        }
    }
    public static function getNow()
    {
        return date('Y-M-D');
    }
    public static function getToday()
    {
        $operations = static::where('type', 'صرف')->get()->where('new_date', now()->format('Y-m-d'));
        return $operations->sum('amount') ?? 0;
    }

    public static function getWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');

        // dd($startOfWeek);

        $operations = static::where('type', 'صرف')->get()->whereBetween('new_date', [$startOfWeek, $endOfWeek]);

        return $operations->sum('amount') ?? 0;
    }
    public static function getMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth(Carbon::SATURDAY)->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth(Carbon::FRIDAY)->format('Y-m-d');

        // dd($startOfMonth);

        $operations = static::where('type', 'صرف')->get()->whereBetween('new_date', [$startOfMonth, $endOfMonth]);

        return $operations->sum('amount') ?? 0;
    }
    public static function getIncomeMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth(Carbon::SATURDAY)->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth(Carbon::FRIDAY)->format('Y-m-d');

        // dd($startOfMonth);

        $operations = static::where(function ($query) {
            $query->where('type', 'وارد');
        })->get()->whereBetween('new_date', [$startOfMonth, $endOfMonth]);

        return $operations->sum('amount') ?? 0;
    }
    public static function getOutcomes()
    {
        $operations = static::where('type', 'صرف')->get();
        $outcomes = 0;
        foreach ($operations as $operation) {
            $outcomes += $operation->amount;
        }
        return $outcomes;
    }
    public static function getIncomes()
    {
        $operations = static::where(function ($query) {
            $query->where('type', 'وارد');
        })->get();
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
        $operationsIn = Operation::where('foulType', $foulType)
            ->whereIn('type', ['وارد شهر', 'وارد'])->where('isClosed', false)->get()->sum('amount');
        $operationsOut = Operation::where('foulType', $foulType)->where('type', 'صرف')->where('isClosed', false)->get()->sum('amount');
        $amounts = $operationsIn - $operationsOut;
        return $amounts;
    }
    public static function getExistOFWithMonth($foulType, $month)
    {
        // Format month to match 'Y-m'
        $monthFormatted = Carbon::createFromFormat('Y-m', $month)->format('Y-m');

        $operationsIn = Operation::where('foulType', $foulType)
            ->where(function ($query) {
                $query->where('type', 'وارد')
                    ->orWhere('type', 'وارد شهر');
            })
            ->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$monthFormatted])
            ->where('isClosed', false)
            ->sum('amount');

        $operationsOut = Operation::where('foulType', $foulType)
            ->where('type', 'صرف')
            ->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$monthFormatted])
            ->where('isClosed', false)
            ->sum('amount');

        $amounts = $operationsIn - $operationsOut;
        return $amounts;
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
