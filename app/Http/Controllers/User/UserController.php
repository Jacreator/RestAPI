<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $usersTotal = User::all()->count();
        if (is_null($users)) {
            return response()->json(['message' => 'No record in the table'], 401);
        }
        return response()->json(['total' => $usersTotal, 'data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // set rules for validation
        $rules = [
            'name' => 'required|min:2|max:40',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ];

        // perform validation
        $this->validate($request, $rules);

        // check input feild and make password hash
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        // create users
        $user = User::create($data);

        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json(['data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // the user with id
        $user = User::findOrFail($id);

        // set rules
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:8|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];

        // check individually what may have been sent
        // name check and update
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        // email check and update verified, verification_token and email
        if ($request->has('email') && $request->email !== $user->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        // password check
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        // check admin and make sure it's only a verified user that can update
        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return response()->json(['error' => 'only a verified user can modify admin status', 'code' => 409], 409);
            }

            $user->admin = $request->admin;
        }

        // check if any value was changed
        if (!$user->isDirty()) {
            return response()->json(['error' => 'You need to specify at least one different value to update', 'code' => 422], 422);
        }

        // save user information
        $user->save();

        return response()->json(['data' => $user], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(['message' => 'User Successfully Deleted', 'data' => $user], 201);
    }
}
