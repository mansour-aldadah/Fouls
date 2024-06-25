<?php

namespace App\Http\Controllers;

use App\Models\SubConsumer;
use App\Models\Travel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subConsumers = SubConsumer::all();
        $travels = Travel::all();
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
            ],
            [
                'sub_consumer_id.required' => 'أدخل اسم المستهلك',
                'road.required' => 'أدخل طريق الرحلة',
                'cause.required' => 'أدخل هدف الرحلة',
            ]
        );
        if (!$validator->fails()) {
            $travel = new Travel();
            $travel->sub_consumer_id = $request->input('sub_consumer_id');
            $travel->road = $request->input('road');
            $travel->cause = $request->input('cause');
            $isSaved = $travel->save();
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
            ],
            [
                'sub_consumer_id.required' => 'أدخل اسم المستهلك',
                'road.required' => 'أدخل طريق الرحلة',
                'cause.required' => 'أدخل هدف الرحلة',
            ]
        );
        if (!$validator->fails()) {
            $travel->sub_consumer_id = $request->input('sub_consumer_id');
            $travel->road = $request->input('road');
            $travel->cause = $request->input('cause');
            $isSaved = $travel->save();
            return response()->json([
                'icon' => 'success',
                'message' => $isSaved ? 'تم التعديل بنجاح' : 'فشل في التعديل'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
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
    public function destroy(Travel $travel)
    {
        $isDeleted = $travel->delete();
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف الرحلة ' . $travel->road : 'فشل حذف الرحلة ' . $travel->road
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
