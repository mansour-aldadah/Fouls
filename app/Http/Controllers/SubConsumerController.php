<?php

namespace App\Http\Controllers;

use App\Models\SubConsumer;
use App\Models\Consumer;
use App\Models\LogFile;
use App\Models\MovementRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SubConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SubConsumer::all();
        return response()->view('sub_consumers.index', ['subConsumers' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Consumer $consumer)
    {
        $data = Consumer::all();
        return response()->view('sub_consumers.create', ['consumers' => $data, 'consumer' => $consumer]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $hasRecord = $request->input('hasRecord');
        $validator = Validator(
            $request->all(),
            [
                'consumer_id' => 'required',
                'details' => 'required|unique:sub_consumers,details,NULL,NULL,deleted_at,NULL|max:35',
                'record' => Rule::requiredIf(fn () => $hasRecord == 1),
                'date' => Rule::requiredIf(fn () => $hasRecord == 1),
            ],
            [
                'consumer_id.required' => 'أدخل اسم المستهلك الرئيسي',
                'details.required' => 'أدخل اسم المستهلك',
                'details.unique' => 'هذا المستهلك موجود مسبقاً',
                'record' => 'أدخل قراءة العدّاد',
                'date' => 'أدخل التاريخ',
                'details.max' => 'يجب ألا يزيد الاسم عن 35 حرف',
            ]
        );


        if (!$validator->fails()) {
            $sub_consumer = new SubConsumer();
            $sub_consumer->consumer_id = $request->input('consumer_id');
            $sub_consumer->details = $request->input('details');
            $sub_consumer->description = $request->input('description');
            if ($request->input('hasRecord')) {
                $sub_consumer->hasRecord = true;
            } else {
                $sub_consumer->hasRecord = false;
            }
            $isSaved = $sub_consumer->save();
            if ($isSaved) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\SubConsumer';
                $logFile->object_id = $sub_consumer->id;
                $logFile->action = 'adding';
                $logFile->old_content = null;
                $logFile->save();
            }
            if ($request->input('hasRecord')) {
                $movementRecord = new MovementRecord();
                $movementRecord->sub_consumer_id = $sub_consumer->id;
                $movementRecord->record = $request->input('record');
                $movementRecord->date = $request->input('date');
                $isSaved2 = $movementRecord->save();
                if ($isSaved2) {
                    $logFile = new LogFile();
                    $logFile->user_id = Auth::user()->id;
                    $logFile->object_type = 'App\Models\MovementRecord';
                    $logFile->object_id = $movementRecord->id;
                    $logFile->action = 'adding';
                    $logFile->old_content = null;
                    $logFile->save();
                }
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
    public function show(SubConsumer $subConsumer)
    {
        return view('sub_consumers.show', ['subConsumer' => $subConsumer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubConsumer $subConsumer)
    {
        $data = Consumer::all();
        return response()->view('sub_consumers.edit', ['subConsumer' => $subConsumer, 'consumers' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubConsumer $subConsumer)
    {
        $validator = Validator(
            $request->all(),
            [
                'consumer_id' => 'required',
                'details' => 'required|unique:sub_consumers,details,' . $subConsumer->id . ',id,deleted_at,NULL|max:35',
            ],
            [
                'consumer_id.required' => 'أدخل اسم المستهلك الرئيسي',
                'details.required' => 'أدخل اسم المستهلك',
                'details.unique' => 'هذا المستهلك موجود مسبقاً',
                'details.max' => 'يجب ألا يزيد الاسم عن 35 حرف',
            ]
        );
        if (!$validator->fails()) {
            $old = $subConsumer->replicate();
            $subConsumer->consumer_id = $request->input('consumer_id');
            $subConsumer->details = $request->input('details');
            $subConsumer->description = $request->input('description');
            if ($request->input('hasRecord')) {
                $subConsumer->hasRecord = true;
            } else {
                $subConsumer->hasRecord = false;
            }
            $isUpdated = $subConsumer->save();
            if ($isUpdated) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\SubConsumer';
                $logFile->object_id = $subConsumer->id;
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
    public function destroy(SubConsumer $subConsumer)
    {
        $old = $subConsumer;
        $isDeleted = $subConsumer->delete();
        if ($isDeleted) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\SubConsumer';
            $logFile->object_id = $old->id;
            $logFile->action = 'deleting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف المستهلك ' . $subConsumer->details : 'فشل حذف المستهلك ' . $subConsumer->details
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
