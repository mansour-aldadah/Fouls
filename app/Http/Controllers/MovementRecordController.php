<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\MovementRecord;
use App\Models\SubConsumer;
use Illuminate\Http\Request;
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
        $validator = Validator($request->all(),  [
            'date' => 'required',
            'record' => 'required'
        ], [
            'date.required' => 'أدخل التاريخ',
            'record.required' => 'أدخل قراءة العدّاد'
        ]);
        if (!$validator->fails()) {
            $movementRecord = new MovementRecord();
            $movementRecord->sub_consumer_id = $request->subConsumerId;
            $movementRecord->date = $request->input('date');
            $movementRecord->record = $request->input('record');
            $isSaved = $movementRecord->save();
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
        $validator = Validator($request->all(),  [
            'date' => 'required',
            'record' => 'required'
        ], [
            'date.required' => 'أدخل التاريخ',
            'record.required' => 'أدخل قراءة العدّاد'
        ]);
        // dd('dsafs');
        if (!$validator->fails()) {
            $movementRecord->sub_consumer_id = $request->subConsumerId;
            $movementRecord->date = $request->input('date');
            $movementRecord->record = $request->input('record');
            $isUpdated = $movementRecord->save();
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
        $isDeleted = $movementRecord->delete();
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف قراءة العدّاد '  : 'فشل حذف قراءة العدّاد '
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
