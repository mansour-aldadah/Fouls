<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\LogFile;
use App\Models\User;
use App\Models\UserConsumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->where('role', '!==', 'مدير');
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $consumers = Consumer::all();
        return view('users.create', ['consumers' => $consumers]);
    }
    public function passwordReset(User $user)
    {
        return view('users.password-reset', ['user' => $user]);
    }
    public function updatePassword(Request $request, User $user)
    {
        $validator = Validator(
            $request->all(),
            [
                'oldPassword' => ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('كلمة المرور القديمة غير صحيحة');
                    }
                }],
                'password' => ['required', 'confirmed', Password::defaults()],
            ],
            [
                'oldPassword.required' => 'أدخل كلمة المرور الحالية',
                'password.required' => 'أدخل كلمة المرور الجديدة',
                'password.confirmed' => 'كلمة المرور وتأكيدها غير متطابقتين'
            ]
        );

        if (!$validator->fails()) {
            $old = $user->replicate();
            $user->password =  Hash::make($request->password);
            $isUpdated = $user->save();
            if ($isUpdated) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\User';
                $logFile->object_id = $user->id;
                $logFile->action = 'editting';
                $logFile->old_content = $old;
                $logFile->save();
            }
            return response()->json([
                'icon' => 'success',
                'message' => $isUpdated ? 'تم تغيير كلمة المرور بنجاح' : 'فشل في تغيير كلمة المرور'
            ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'icon' => 'warning',
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = $request->input('role');
        $validator = Validator(
            $request->all(),
            [
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'role' => ['required'],
                'name' => ['required'],
                'consumer_id' => Rule::requiredIf(fn () => $role == 'مستهلك')
            ],
            [
                'username.required' => 'أدخل اسم المستخدم',
                'password.required' => 'أدخل كلمة المرور',
                'role' => 'أدخل نوع المستخدم',
                'name' => 'أدخل الاسم',
                'password.confirmed' => 'كلمة المرور وتأكيدها غير متطابقتين',
                'consumer_id' => 'أدخل اسم المستهلكين المسؤول عنهم'
            ]
        );
        if (!$validator->fails()) {
            $user = new User();
            $user->username = $request->username;
            $user->password =  Hash::make($request->password);
            $user->role = $request->input('role');
            $user->name = $request->input('name');
            $isSaved = $user->save();
            if ($isSaved) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\User';
                $logFile->object_id = $user->id;
                $logFile->action = 'adding';
                $logFile->old_content = null;
                $logFile->save();
            }
            if ($role == 'مستهلك') {
                $userConsumers = new UserConsumer();
                $userConsumers->consumer_id = $request->input('consumer_id');
                $userConsumers->user_id = $user->id;
                $isSaved2 = $userConsumers->save();
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
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $consumers = Consumer::all();
        return view('users.edit', ['user' => $user, 'consumers' => $consumers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $role = $request->input('role');
        $oldRole = $user->role;
        $validator = Validator(
            $request->all(),
            [
                'username' => ['required', 'string', 'max:255'],
                'role' => ['required'],
                'name' => ['required'],
                'consumer_id' => Rule::requiredIf(fn () => $role == 'مستهلك')
            ],
            [
                'username.required' => 'أدخل اسم المستخدم',
                'consumer_id' => 'أدخل اسم المستهلكين المسؤول عنهم',
                'role' => 'أدخل نوع المستخدم',
                'name' => 'أدخل الاسم',
            ]
        );

        if (!$validator->fails()) {
            $old = $user->replicate();
            $user->username = $request->username;
            $user->role = $request->input('role');
            $user->name = $request->input('name');
            $isUpdated = $user->save();
            if ($isUpdated) {
                $logFile = new LogFile();
                $logFile->user_id = Auth::user()->id;
                $logFile->object_type = 'App\Models\User';
                $logFile->object_id = $user->id;
                $logFile->action = 'editting';
                $logFile->old_content = $old;
                $logFile->save();
            }
            if ($oldRole == 'مستخدم' && $role == 'مستهلك') {
                $userConsumers = new UserConsumer();
                $userConsumers->user_id = $user->id;
                $userConsumers->consumer_id = $request->input('consumer_id');
                $isSaved = $userConsumers->save();
            } elseif ($oldRole == 'مستهلك' && $role == 'مستهلك') {
                $userConsumers = UserConsumer::where('user_id', $user->id);
                $userConsumers->consumer_id = $request->input('consumer_id');
                $isUpdated2 = $userConsumers->save();
            } elseif ($oldRole == 'مستهلك' && $role == 'مستخدم') {
                $userConsumers = UserConsumer::where('user_id', $user->id);
                $isDeleted = $userConsumers->delete();
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
    public function destroy(User $user)
    {
        $old = $user;
        $userConsumers = UserConsumer::where('user_id', $user->id);
        $isDeleted =  $userConsumers->delete() && $user->delete();
        if ($isDeleted) {
            $logFile = new LogFile();
            $logFile->user_id = Auth::user()->id;
            $logFile->object_type = 'App\Models\User';
            $logFile->object_id = $old->id;
            $logFile->action = 'deleting';
            $logFile->old_content = $old;
            $logFile->save();
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف المستخدم ' . $user->username : 'فشل حذف المستخدم ' . $user->username
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
