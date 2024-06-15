<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\SubConsumer;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Consumer::all();
        return response()->view('consumers.index', ['consumers' => $data]);
    }

    public function getSubConsumers($conusmer_id)
    {
        $data = SubConsumer::where('consumer_id', $conusmer_id)->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('consumers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator(
            $request->all(),
            [
                'name' => 'required|unique:consumers',
            ],
            [
                'name.required' => 'أدخل اسم المستهلك',
                'name.unique' => 'هذا المستهلك موجود مسبقاً'
            ]
        );
        if (!$validator->fails()) {
            $consumer = new Consumer();
            $consumer->name = $request->input('name');
            $isSaved = $consumer->save();
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
    public function show(Consumer $consumer)
    {
        $sub_consumers = SubConsumer::all()->where('consumer_id', $consumer->id);
        // dd($sub_consumers);
        return response()->view('consumers.show', ['consumer' => $consumer, 'sub_consumers' => $sub_consumers]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consumer $consumer)
    {
        return response()->view('consumers.edit', ['consumer' => $consumer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consumer $consumer)
    {
        $validator = Validator(
            $request->all(),
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'أدخل اسم المستهلك',
            ]
        );
        if (!$validator->fails()) {
            $consumer->name = $request->input('name');
            $isUpdated = $consumer->save();
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
    public function destroy(Consumer $consumer)
    {
        $isDeleted = $consumer->delete();
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف المستهلك ' . $consumer->name : 'فشل حذف المستهلك ' . $consumer->name
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
