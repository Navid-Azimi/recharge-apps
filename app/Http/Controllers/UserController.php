<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GetCountries;
use App\Http\Controllers\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    use GetCountries, UploadImage;

    public function index()
    {
        $users = User::latest('updated_at')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', [
            'countries' => $this->getCountries(),
        ]);
    }

    public function store(Request $request)
    {
        $validated_user = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'user_role' => 'required',
            'avatar' => 'required|image',
            'user_country' => 'required|string',
            'city' => 'required',
        ])->validate();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->avatar = $request->hasFile('avatar') ? $this->uploadImage('avatar') : null;
        $user->user_role = $request->user_role;
        $user->user_country = $request->user_country;
        $user->business_type = $request->business_type;
        $user->passport_number = $request->passport_number;
        $user->city = $request->city;
        $user->business_license_nu = $request->business_license_nu;
        $user->save();

        return redirect('/users')->withSuccess('User created successfully!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        session(['reseller_redirect' => url()->previous()]);
        return view('users.edit', [
            'user' => $user,
            'countries' => $this->getCountries(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated_user = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'user_role' => 'required',
            'avatar' => 'nullable|image',
            'user_country' => 'required|string',
            'city' => 'required|min:3',
        ])->validate();

        $item = User::findOrFail($id);
        $item->name = $request->name;
        $item->city = $request->city;
        $item->email = $request->email;
        $item->avatar = $request->hasFile('avatar') ? $this->uploadImage('avatar') : $item->avatar;
        $item->user_role = $request->user_role;
        $item->user_country = $request->user_country;
        $item->business_type = $request->business_type;
        $item->passport_number = $request->passport_number;
        $item->business_license_nu = $request->business_license_nu;
        $item->status = $request->has('status') ? 1 : 0;
        if (request('password')) {
            $item->password = Hash::make($request->password);
        }
        $item->save();

        $reselRedirect = session('reseller_redirect');
        if ($reselRedirect === route('manage_resellers')) {
            return redirect()->route('manage_resellers')->withSuccess('User updated successfully!');
        } else {
            return redirect('/users')->withSuccess('User updated successfully!');
        }
    }
    // delete user -----------------------------------

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar) {
            $this->deleteImage($user->avatar);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    // delete user -----------------------------------

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!($token = JWTAuth::attempt($credentials))) {
                return response()->json(
                    ['error' => 'invalid_credentials'],
                    400
                );
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!($user = JWTAuth::parseToken()->authenticate())) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function getUsersByRole($role)
    {
        $users = User::where('user_role', $role)->get();
        return response()->json(['users' => $users]);
    }

    public function getAllUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }
}
