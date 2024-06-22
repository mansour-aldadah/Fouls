<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('users.create');
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
            $user->password =  Hash::make($request->password);
            $isSaved = $user->save();
            return response()->json([
                'icon' => 'success',
                'message' => $isSaved ? 'تم تغيير كلمة المرور بنجاح' : 'فشل في تغيير كلمة المرور'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
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

        $validator = Validator(
            $request->all(),
            [
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ],
            [
                'username.required' => 'أدخل اسم المستخدم',
                'password.required' => 'أدخل كلمة المرور',
                'password.confirmed' => 'كلمة المرور وتأكيدها غير متطابقتين'
            ]
        );

        if (!$validator->fails()) {
            $user = new User();
            $user->username = $request->username;
            $user->password =  Hash::make($request->password);
            $isSaved = $user->save();
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
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator(
            $request->all(),
            [
                'username' => ['required', 'string', 'max:255'],
            ],
            [
                'username.required' => 'أدخل اسم المستخدم',
            ]
        );

        if (!$validator->fails()) {
            $user->username = $request->username;
            $isUpdated = $user->save();
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
        $isDeleted =  $user->delete();
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'message' => $isDeleted ? 'تم حذف المستخدم ' . $user->username : 'فشل حذف المستخدم ' . $user->username
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
