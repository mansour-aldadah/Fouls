<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\LogFile;
use App\Models\MovementRecord;
use App\Models\SubConsumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class MovementRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $subConsumer = SubConsumer::findOrFail($id);
        $consumers = Consumer::all();
        return view('movement_records.create', ['subConsumer' => $subConsumer, 'consumers' => $consumers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->subConsumerId);
        $last = SubConsumer::find($request->subConsumerId)->movementRecords()->orderByDesc('date')->orderByDesc('created_at')->first()->record ?? '0';

        $validator = Validator($request->all(), [
            'date' => 'required|date',
            'record' => ['required', 'numeric', function ($attribute, $value, $fail) use ($last) {
                if ($value <= $last) {
                    $fail('يجب أن تكون قراءة العدّاد أكبر من القراءة السابقة');
                }
            }]
        ], [
            'date.required' => 'أدخل التاريخ',
            'record.required' => 'أدخل قراءة العدّاد',
            'record.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
        ]);
        if (!$validator->fails()) {
            $movementRecord = new MovementRecord();
            $movementRecord->sub_consumer_id = $request->subConsumerId;
            $movementRecord->date = $request->input('date');
            $movementRecord->record = $request->input('record');
            $isSaved = $movementRecord->save();
            if ($isSaved) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\MovementRecord';
                $logFile->object_id = $movementRecord->id;
                $logFile->action = 'adding';
                $logFile->old_content = null;
                $logFile->save();
            }
            return response()->json([
                'icon' => 'success',
                'message' => $isSaved ? 'تمت الإضافة بنجاح' : 'فشل في الإضافة'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'icon' => 'warning',
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MovementRecord $movementRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, MovementRecord $movementRecord)
    {
        $subConsumer = SubConsumer::findOrFail($id);
        $consumers = Consumer::all();
        return response()->view('movement_records.edit', ['movementRecord' => $movementRecord, 'subConsumer' => $subConsumer, 'consumers' => $consumers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MovementRecord $movementRecord)
    {
        $last = SubConsumer::find($request->subConsumerId)->movementRecords()->orderByDesc('date')->orderByDesc('created_at')->first()->record ??  '0';
        $lastDate = SubConsumer::find($request->subConsumerId)->movementRecords()->orderByDesc('date')->orderByDesc('created_at')->first()->record ??  '0';
        $date = $request->input('date');
        $validator = Validator($request->all(), [
            'date' => 'required|date',
            'record' => ['required', 'numeric', function ($attribute, $value, $fail) use ($last, $date, $lastDate) {
                if ($value <= $last) {
                    $fail('يجب أن تكون قراءة العدّاد أكبر من القراءة السابقة');
                }
            }]
        ], [
            'date.required' => 'أدخل التاريخ',
            'record.required' => 'أدخل قراءة العدّاد',
            'record.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
        ]);
        // dd('dsafs');
        if (!$validator->fails()) {
            $old = $movementRecord->replicate();
            $movementRecord->sub_consumer_id = $request->subConsumerId;
            $movementRecord->date = $request->input('date');
            $movementRecord->record = $request->input('record');
            $isUpdated = $movementRecord->save();
            if ($isUpdated) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\MovementRecord';
                $logFile->object_id = $movementRecord->id;
                $logFile->action = 'editting';
                $logFile->old_content = $old;
                $logFile->save();
            }
            return response()->json([
                'icon' => 'success',
                'message' => $isUpdated ? 'تم التعديل بنجاح' : 'فشل في التعديل'
            ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'icon' => 'warning',
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovementRecord $movementRecord)
    {
        $old = $movementRecord;
        $isDeleted = $movementRecord->delete();
        if ($isDeleted) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\MovementRecord';
            $logFile->object_id = $old->id;
            $logFile->action = 'deleting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف قراءة العدّاد '  : 'فشل حذف قراءة العدّاد '
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
