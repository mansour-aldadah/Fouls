<?php

namespace App\Http\Controllers;

use App\Models\LogFile;
use App\Models\MovementRecord;
use App\Models\SubConsumer;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subConsumers = SubConsumer::all();
        $travels = Travel::orderByRaw("FIELD(status, 'قيد التنفيذ') DESC")->orderByDesc('date')->get();
        return view('travels.index', ['subConsumers' => $subConsumers, 'travels' => $travels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subConsumers = SubConsumer::all();
        return view('travels.create', ['subConsumers' => $subConsumers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'sub_consumer_id' => 'required',
                'road' => 'required',
                'cause' => 'required',
                // 'recordBefore' => 'required|numeric',
                // 'recordAfter' => 'required|numeric',
                'date' => 'required|date',
            ],
            [
                'sub_consumer_id.required' => 'أدخل اسم المستهلك',
                'road.required' => 'أدخل طريق الرحلة',
                'cause.required' => 'أدخل هدف الرحلة',
                'date.required' => 'أدخل تاريخ الرحلة',
                // 'recordBefore.required' => 'أدخل قراءة العدّاد قبل الرحلة',
                // 'recordAfter.required' => 'أدخل قراءة العدّاد بعد الرحلة',
                // 'recordBefore.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
                // 'recordAfter.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
            ]
        );
        if (!$validator->fails()) {
            $travel = new Travel();
            $travel->sub_consumer_id = $request->input('sub_consumer_id');
            $travel->road = $request->input('road');
            $travel->cause = $request->input('cause');
            $travel->date = $request->input('date');
            $travel->status = 'منشأة';
            // $travel->recordBefore = $request->input('recordBefore');
            // $travel->recordAfter = $request->input('recordAfter');
            $isSaved = $travel->save();
            if ($isSaved) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\Travel';
                $logFile->object_id = $travel->id;
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
    public function show(Travel $travel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Travel $travel)
    {
        $subConsumers = SubConsumer::all();
        return view('travels.edit', ['subConsumers' => $subConsumers, 'travel' => $travel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Travel $travel)
    {
        $validator = Validator(
            $request->all(),
            [
                'sub_consumer_id' => 'required',
                'road' => 'required',
                'cause' => 'required',
                // 'recordBefore' => 'required|numeric',
                // 'recordAfter' => 'required|numeric',
                'date' => 'required|date',
            ],
            [
                'sub_consumer_id.required' => 'أدخل اسم المستهلك',
                'road.required' => 'أدخل طريق الرحلة',
                'cause.required' => 'أدخل هدف الرحلة',
                'date.required' => 'أدخل تاريخ الرحلة',
                // 'recordBefore.required' => 'أدخل قراءة العدّاد قبل الرحلة',
                // 'recordAfter.required' => 'أدخل قراءة العدّاد بعد الرحلة',
                // 'recordBefore.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
                // 'recordAfter.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
            ]
        );
        if (!$validator->fails()) {
            $old = $travel->replicate();
            $travel->sub_consumer_id = $request->input('sub_consumer_id');
            $travel->road = $request->input('road');
            $travel->cause = $request->input('cause');
            $travel->date = $request->input('date');
            // $travel->recordBefore = $request->input('recordBefore');
            // $travel->recordAfter = $request->input('recordAfter');
            $isUpdated = $travel->save();
            if ($isUpdated) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\Travel';
                $logFile->object_id = $travel->id;
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

    public function updateStatus(Travel $travel, Request $request)
    {
        $old = $travel->replicate();
        $reading = $request->input('reading');
        $movementRecord = new MovementRecord();
        $movementRecord->date = $travel->date;
        $movementRecord->sub_consumer_id = $travel->sub_consumer_id;
        $movementRecord->record = $reading;
        if ($travel->status == 'منشأة') {
            $last = SubConsumer::find($travel->sub_consumer_id)->movementRecords()->orderByDesc('date')->orderByDesc('created_at')->first()->record ??  '0';
            $validator = Validator($request->all(), [
                'reading' => ['required', 'numeric', function ($attribute, $value, $fail) use ($last) {
                    if ($value <= $last) {
                        $fail('يجب أن تكون قراءة العدّاد أكبر من القراءة السابقة');
                    }
                }]
            ], [
                'reading.required' => 'أدخل قراءة العدّاد',
                'reading.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
            ]);
            if (!$validator->fails()) {
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
                $travel->status = 'قيد التنفيذ';
                $travel->recordBefore = $reading;
                $isUpdated = $travel->save();
                if ($isUpdated) {
                    $logFile = new LogFile();
                    $logFile->user_id = Auth::user()->id;
                    $logFile->object_type = 'App\Models\Travel';
                    $logFile->object_id = $travel->id;
                    $logFile->action = 'editting';
                    $logFile->old_content = $old;
                    $logFile->save();
                }
                return response()->json([
                    'icon' => $isUpdated && $isSaved ? 'success' : 'error',
                    'message' => $isUpdated && $isSaved ? 'تم بدء الرحلة ' . $travel->road : 'فشل بدء الرحلة ' . $travel->road
                ], $isUpdated && $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'icon' => 'warning',
                    'message' => $validator->getMessageBag()->first()
                ], Response::HTTP_BAD_REQUEST);
            }
        } elseif ($travel->status == 'قيد التنفيذ') {
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
            $last = $travel->recordBefore;
            $validator = Validator($request->all(), [
                'reading' => ['required', 'numeric', function ($attribute, $value, $fail) use ($last) {
                    if ($value <= $last) {
                        $fail('يجب أن تكون قراءة العدّاد أكبر من القراءة السابقة');
                    }
                }]
            ], [
                'reading.required' => 'أدخل قراءة العدّاد',
                'reading.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
            ]);
            if (!$validator->fails()) {
                $travel->status = 'منتهية';
                $travel->recordAfter = $reading;
                $isUpdated = $travel->save();
                if ($isUpdated) {
                    $logFile = new LogFile();
                    $logFile->user_id = Auth::user()->id;
                    $logFile->object_type = 'App\Models\Travel';
                    $logFile->object_id = $travel->id;
                    $logFile->action = 'editting';
                    $logFile->old_content = $old;
                    $logFile->save();
                }
                return response()->json([
                    'icon' => $isUpdated && $isSaved ? 'success' : 'error',
                    'message' => $isUpdated && $isSaved ? 'تم إنهاء الرحلة ' . $travel->road : 'فشل إنهاء الرحلة ' . $travel->road
                ], $isUpdated && $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'icon' => 'warning',
                    'message' => $validator->getMessageBag()->first()
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function cancelTravel(Travel $travel)
    {
        $old = $travel->replicate();
        $travel->status = 'ملغية';
        $isUpdated = $travel->save();
        if ($isUpdated) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\Travel';
            $logFile->object_id = $travel->id;
            $logFile->action = 'editting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        return response()->json([
            'icon' => $isUpdated ? 'success' : 'error',
            'message' => $isUpdated ? 'تم إلغاء الرحلة ' . $travel->road : 'فشل إلغاء الرحلة ' . $travel->road
        ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Travel $travel)
    {
        $old = $travel;
        $isDeleted = $travel->delete();
        if ($isDeleted) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\Travel';
            $logFile->object_id = $old->id;
            $logFile->action = 'deleting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف الرحلة ' . $travel->road : 'فشل حذف الرحلة ' . $travel->road
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
