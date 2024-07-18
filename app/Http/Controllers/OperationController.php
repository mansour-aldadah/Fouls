<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Consumer;
use App\Models\LogFile;
use App\Models\MovementRecord;
use App\Models\SubConsumer;
use Carbon\Carbon;
use Hamcrest\Type\IsInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\HttpFoundation\Response;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operations = Operation::orderByDesc('date')->orderByDesc('created_at')->get();
        return response()->view('operations.index', ['operations' => $operations]);
    }
    public function closeMonth()
    {
        $operations = Operation::where('isClosed', false)->get();
        $months = [];
        foreach ($operations as $operation) {
            $month = $operation->date->format('Y-m');
            if (!in_array($month, $months)) {
                $months[] = $month;
            }
        }
        return response()->view('operations.close-month', ['months' => $months, 'operations' => $operations]);
    }
    public function updateIsClosed(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'month' => 'required',
            ],
            [
                'month.required' => 'أدخل الشهر',
            ]
        );
        if (!$validator->fails()) {
            $operations = Operation::all()->where('month', $request->input('month'));
            foreach ($operations as $operation) {
                $operation->isClosed = true;
                $isUpdated = $operation->save();
            }
            return response()->json([
                'icon' => 'success',
                'message' => $isUpdated ? 'تم إغلاق شهر' . $request->input('month') . 'بنجاح' : 'فشل في الإغلاق'
            ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'icon' => 'warning',
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function indexIncome($time)
    {
        if ($time == 'all') {
            $operations = Operation::where('type', 'وارد')->orderByDesc('date')->orderByDesc('created_at')->get();
            return response()->view('operations.index-income', ['operations' => $operations]);
        } elseif ($time == 'month') {
            $startOfMonth = Carbon::now()->startOfMonth(Carbon::SATURDAY)->format('Y-m-d');
            $endOfMonth = Carbon::now()->endOfMonth(Carbon::FRIDAY)->format('Y-m-d');
            $operations = Operation::where('type', 'وارد')->whereBetween('date', [$startOfMonth, $endOfMonth])->orderByDesc('date')->orderByDesc('created_at')->get();
            return response()->view('operations.index-income', ['operations' => $operations]);
        }
    }
    public function indexOutcome($time)
    {
        if ($time == 'all') {
            $operations = Operation::where('type', 'صرف')->orderByDesc('date')->orderByDesc('created_at')->get();
            return response()->view('operations.index-outcome', ['operations' => $operations]);
        } elseif ($time == 'month') {
            $startOfMonth = Carbon::now()->startOfMonth(Carbon::SATURDAY)->format('Y-m-d');
            $endOfMonth = Carbon::now()->endOfMonth(Carbon::FRIDAY)->format('Y-m-d');
            $operations = Operation::where('type', 'صرف')->whereBetween('date', [$startOfMonth, $endOfMonth])->orderByDesc('date')->orderByDesc('date')->orderByDesc('created_at')->get();
            return response()->view('operations.index-outcome', ['operations' => $operations]);
        } elseif ($time == 'week') {
            $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');
            $operations = Operation::where('type', 'صرف')->whereBetween('date', [$startOfWeek, $endOfWeek])->orderByDesc('date')->orderByDesc('created_at')->get();
            return response()->view('operations.index-outcome', ['operations' => $operations]);
        } elseif ($time == 'today') {
            $operations = Operation::where('type', 'صرف')->where('date', now()->format('Y-m-d'))->orderByDesc('date')->orderByDesc('created_at')->get();
            return response()->view('operations.index-outcome', ['operations' => $operations]);
        }
    }

    /**S
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function search()
    {
        $consumers = Consumer::all();
        $subConsumers = SubConsumer::all();
        return view('operations.search', ['consumers' => $consumers, 'subConsumers' => $subConsumers]);
    }
    public function searchResult(Request $request)
    {
        $type = $request->input('type');
        // $amount = $request->input('amount');
        $From = $request->input('from_date');
        $To = $request->input('to_date');
        $foulType = $request->input('foulType');
        $dischangeNumber = $request->input('dischangeNumber');
        $receiverName = $request->input('receiverName');
        $sub_consumer_id = $request->input('sub_consumer_name');
        $description = $request->input('description');
        $consumer_id = $request->input('consumer_name');
        $reportDate = $request->input('reportDate');


        if ($request->input('checked')) {
            $checked = true;
        } else {
            $checked = false;
        }
        // Initialize the query builder
        if ($consumer_id) {
            $operations = Consumer::findOrFail($consumer_id)->operations();
        } else {
            $operations = Operation::query();
        }
        // Apply filters
        if ($type) {
            $operations->where('type', $type);
        }

        // if ($amount) {
        //     $operations->where('amount', $amount);
        // }
        if ($reportDate == 'يومي') {
            $request->validate([
                'from_date' => 'required'
            ], [
                'from_date.required' => 'أدخل التاريخ'
            ]);
            $operations->where('date',  $From);
        } elseif ($reportDate == 'لفترة') {
            $request->validate(
                [
                    'from_date' => 'required',
                    'to_date' => [Rule::requiredIf(fn () => $From !== null), 'after:from_date']
                ],
                [
                    'from_date.required' => 'أدخل التاريخ',
                    'to_date.required' => 'أدخل التاريخ الثاني',
                    'to_date.after' => 'يجب أن يكون التاريخ الثاني بعد التاريخ الأول'
                ]
            );
            $operations->where('date', '>=', $From);
        } else {
            if ($From || $To) {
                $request->validate(
                    [
                        'from_date' => 'required',
                        'to_date' => [Rule::requiredIf(fn () => $From !== null), 'after:from_date']
                    ],
                    [
                        'from_date.required' => 'أدخل التاريخ',
                        'to_date.required' => 'أدخل التاريخ الثاني',
                        'to_date.after' => 'يجب أن يكون التاريخ الثاني بعد التاريخ الأول'
                    ]
                );
                $operations->where('date', '>=', $From);
            }
        }



        if ($To) {
            $operations->where('date', '<=', $To);
        }

        if ($foulType) {
            $operations->where('foulType', $foulType);
        }

        if ($checked) {
            $operations->where('checked', $checked);
        }

        if ($dischangeNumber) {
            $operations->where('dischangeNumber', $dischangeNumber);
        }

        if ($receiverName) {
            $operations->where('receiverName', 'LIKE', '%' . $receiverName . '%');
        }

        if ($sub_consumer_id) {
            $operations->where('sub_consumer_id', $sub_consumer_id);
        }

        if ($description) {
            $operations->where('description', 'LIKE', '%' . $description . '%');
        }

        // Execute the query and get the results
        $operations = $operations->orderByDesc('date')->orderByDesc('created_at')->get();
        session([
            'operations' => $operations,
            'type' => $type,
            'from' => $From,
            'to' => $To,
            'reportDate' => $reportDate,
            'foulType' => $foulType,
            'dischangeNumber' => $dischangeNumber,
            'receiverName' => $receiverName,
            'consumer_id' => $consumer_id,
            'description' => $description,
            'sub_consumer_id' => $sub_consumer_id,
            'checked' => $checked,
        ]);
        return view('operations.search-result', ['operations' => $operations]);
    }

    public function print()
    {
        // Retrieve the results from the session
        $operations = session('operations', []);
        $type = session('type');
        $from = session('from');
        $to = session('to');
        $reportDate = session('reportDate');
        $foulType = session('foulType');
        $dischangeNumber = session('dischangeNumber');
        $receiverName = session('receiverName');
        $consumer_id = session('consumer_id');
        $description = session('description');
        $sub_consumer_id = session('sub_consumer_id');
        $checked = session('checked');
        return view('operations.print', [
            'operations' => $operations,
            'type' => $type, //check
            'from' => $from, //check
            'to' => $to, //check
            'reportDate' => $reportDate, //check
            'foulType' => $foulType, //check
            'dischangeNumber' => $dischangeNumber, //check
            'receiverName' => $receiverName, //check
            'consumer_id' => $consumer_id, //check
            'description' => $description,
            'sub_consumer_id' => $sub_consumer_id, //check
            'checked' => $checked
        ]);
    }
    public function createIncome()
    {
        return response()->view('operations.create-income');
    }
    public function createOutcome()
    {
        $consumers = Consumer::all();
        $subConsumers = SubConsumer::all();
        return view('operations.create-outcome', ['consumers' => $consumers, 'subConsumers' => $subConsumers]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = $request->input('record');
        $request->validate([
            'sub_consumer_name' => 'required',
            'amount' => ['required', 'numeric'],
            'date' => 'required',
            'foulType' => 'required',
            'receiverName' => 'required|max:35',
            'dischangeNumber' => ['required', 'unique:operations', 'regex:/^\d{4}$/']
        ], [
            'sub_consumer_name' => 'أدخل اسم المستهلك',
            'amount' => 'أدخل كمية الوقود',
            'amount.numeric' => 'يجب أن تكون كمية الوقود رقماً',
            'date' => 'أدخل التاريخ',
            'foulType' => 'أدخل نوع الوقود',
            'receiverName.required' => 'أدخل اسم المستلم',
            'receiverName.max' => 'يجب ألا يزيد اسم المستلم عن 35 حرف',
            'dischangeNumber.required' => 'أدخل رقم سند الصرف',
            'dischangeNumber.unique' => 'هذا السند موجود مسبقاً',
            'dischangeNumber.regex' => 'يجب أن يتكون سند الصرف من 4 أرقام',
        ]);

        if (+$request->amount > Operation::getExistOF($request->foulType)) {
            $request->validate(['amount' => function ($attribute, $value, $fail) {
                return $fail('لا يوجد ما يكفي من الوقود لصرف هذه الكمية');
            }]);
        }
        $operation = new Operation();
        $operation->sub_consumer_id = $request->input('sub_consumer_name');
        if ($request->input('checked')) {
            $operation->checked = true;
        } else {
            $operation->checked = false;
        }
        $operation->amount = $request->input('amount');
        $operation->type = 'صرف';
        $operation->date = $request->input('date');
        $operation->dischangeNumber = $request->input('dischangeNumber');
        $operation->receiverName = $request->input('receiverName');
        $operation->foulType = $request->input('foulType');
        $operation->description = $request->input('description');
        $isSaved2 = false;
        if ($record) {
            $last = SubConsumer::find($request->input('sub_consumer_name'))->movementRecords()->orderByDesc('date')->orderByDesc('created_at')->first()->record ??  '0';
            $request->validate([
                'record' => ['numeric', function ($attribute, $value, $fail) use ($last) {
                    if ($value <= $last) {
                        $fail('يجب أن تكون قراءة العدّاد أكبر من القراءة السابقة');
                    }
                }]
            ], [
                'record.numeric' => 'يجب أن تكون قراءة العدّاد رقماً',
            ]);
            $movementRecord = new MovementRecord();
            $movementRecord->sub_consumer_id =  $request->input('sub_consumer_name');
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
        $isSaved = $operation->save();
        if ($isSaved) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\Operation';
            $logFile->object_id = $operation->id;
            $logFile->action = 'adding';
            $logFile->old_content = null;
            $logFile->save();
            if ($isSaved2) {
                session()->flash('messege', $isSaved && $isSaved2 ? 'تمت الإضافة بنجاح' : 'فشل في الإضافة');
                return redirect()->route('operations.index');
            }
            session()->flash('messege', $isSaved ? 'تمت الإضافة بنجاح' : 'فشل في الإضافة');
            return redirect()->route('operations.index');
        }
    }

    public function store_income(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'date' => 'required',
            'foulType' => 'required',
        ], [
            'amount.required' => 'أدخل كمية الوقود',
            'amount.numeric' => 'يجب أن تكون كمية الوقود رقماً',
            'date' => 'أدخل التاريخ',
            'foulType' => 'أدخل نوع الوقود',
        ]);
        $operation = new Operation();
        $operation->amount = $request->input('amount');
        $operation->type = 'وارد';
        $operation->date = $request->input('date');
        if ($request->input('checked')) {
            $operation->checked = true;
        } else {
            $operation->checked = false;
        }
        $operation->foulType = $request->input('foulType');
        $operation->description = $request->input('description');
        $isSaved = $operation->save();
        if ($isSaved) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\Operation';
            $logFile->object_id = $operation->id;
            $logFile->action = 'adding';
            $logFile->old_content = null;
            $logFile->save();
        }
        session()->flash('messege', $isSaved ? 'تمت الإضافة بنجاح' : 'فشل في الإضافة');
        return redirect()->route('operations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Operation $operation)
    {
        return response()->view('operations.show', ['operation' => $operation]);
    }
    public function showOutcome(Operation $operation)
    {
        return response()->view('operations.show-outcome', ['operation' => $operation]);
    }
    public function showIncome(Operation $operation)
    {
        return response()->view('operations.show-income', ['operation' => $operation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operation $operation)
    {
    }
    public function editIncome(Operation $operation, $page)
    {
        return response()->view('operations.edit-income', [
            'operation' => $operation,
            'page' => $page
        ]);
    }
    public function editOutcome(Operation $operation, $page)
    {
        $consumers = Consumer::all();
        $subConsumers = SubConsumer::all();
        $subConsumer = $operation->subConsumer;
        $consumer = $subConsumer->consumer;
        // dd($operation);
        return response()->view('operations.edit-outcome', [
            'consumers' => $consumers,
            'subConsumers' => $subConsumers,
            'operation' => $operation,
            'consumer' => $consumer,
            'subConsumer' => $subConsumer,
            'page' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Operation $operation)
    {
        // dd($request->page);
        $request->validate([
            'sub_consumer_name' => 'required',
            'amount' => ['required', 'numeric'],
            'date' => 'required',
            'foulType' => 'required',
            'receiverName' => 'required|max:35',
            'dischangeNumber' => ['required', 'regex:/^\d{4}$/']
        ], [
            'sub_consumer_name' => 'أدخل اسم المستهلك',
            'amount.required' => 'أدخل كمية الوقود',
            'amount.numeric' => 'يجب أن تكون كمية الوقود رقماً',
            'date' => 'أدخل التاريخ',
            'foulType' => 'أدخل نوع الوقود',
            'receiverName.required' => 'أدخل اسم المستلم',
            'receiverName.max' => 'يجب ألا يزيد اسم المستلم عن 35 حرف',
            'dischangeNumber.required' => 'أدخل رقم سند الصرف',
            'dischangeNumber.regex' => 'يجب أن يتكون سند الصرف من 4 أرقام',

        ]);
        // dd($page);
        $old = $operation->replicate();

        $page = $request->page;
        $operation->sub_consumer_id = $request->input('sub_consumer_name');
        $operation->amount = $request->input('amount');
        if ($request->input('checked')) {
            $operation->checked = true;
        } else {
            $operation->checked = false;
        }
        $operation->date = $request->input('date');
        $operation->dischangeNumber = $request->input('dischangeNumber');
        $operation->receiverName = $request->input('receiverName');
        $operation->foulType = $request->input('foulType');
        $operation->description = $request->input('description');
        $isUpdated = $operation->save();
        if ($isUpdated) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\Operation';
            $logFile->object_id = $operation->id;
            $logFile->action = 'editting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        session()->flash('messege', $isUpdated ? 'تم التعديل بنجاح' : 'فشل في التعديل');
        if ($page == 'index') {
            return redirect()->route('operations.index');
        } elseif ($page == 'home') {
            return redirect()->route('dashboard');
        } elseif ($page == 'index-income') {
            return redirect()->route('operations.index-income', ['time' => 'all']);
        } elseif ($page == 'index-outcome') {
            return redirect()->route('operations.index-outcome', ['time' => 'all']);
        } elseif ($page == 'show') {
            return redirect()->route('sub_consumers.show', $operation->sub_consumer_id);
        } elseif ($page == 'search') {
            return redirect()->route('operations.search-result', $operation->sub_consumer_id);
        }
        return redirect()->route('operations.index');
    }
    public function updateIncome(Request $request, Operation $operation)
    {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'date' => 'required',
            'foulType' => 'required',
        ], [
            'amount.required' => 'أدخل كمية الوقود',
            'amount.numeric' => 'يجب أن تكون كمية الوقود رقماً',
            'date' => 'أدخل التاريخ',
            'foulType' => 'أدخل نوع الوقود',
        ]);
        $old = $operation->replicate();
        $operation->amount = $request->input('amount');
        $operation->date = $request->input('date');
        if ($request->input('checked')) {
            $operation->checked = true;
        } else {
            $operation->checked = false;
        }
        $page = $request->page;

        $operation->foulType = $request->input('foulType');
        $operation->description = $request->input('description');
        $isUpdated = $operation->save();
        if ($isUpdated) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\Operation';
            $logFile->object_id = $operation->id;
            $logFile->action = 'editting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        session()->flash('messege', $isUpdated ? 'تم التعديل بنجاح' : 'فشل في التعديل');
        if ($page == 'index') {
            return redirect()->route('operations.index');
        } elseif ($page == 'home') {
            return redirect()->route('dashboard');
        } elseif ($page == 'index-income') {
            return redirect()->route('operations.index-income', ['time' => 'all']);
        } elseif ($page == 'index-outcome') {
            return redirect()->route('operations.index-outcome', ['time' => 'all']);
        } elseif ($page == 'show') {
            return redirect()->route('sub_consumers.show', $operation->sub_consumer_id);
        }
        return redirect()->route('operations.index');
    }

    public function checkHasRecord($subConsumerId)
    {
        $subConsumer = SubConsumer::find($subConsumerId);

        // Assuming `hasRecord` is a boolean attribute of the SubConsumer model
        return response()->json(['hasRecord' => $subConsumer->hasRecord]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operation $operation)
    {
        $old = $operation;
        $isDeleted = $operation->delete();
        if ($isDeleted) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\Operation';
            $logFile->object_id = $old->id;
            $logFile->action = 'deleting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف العملية ' : 'فشل حذف العملية '
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
