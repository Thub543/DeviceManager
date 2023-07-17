<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\UserCreateDataRequest;
use App\Http\Requests\UserRequests\UserEditDataRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::cleardAllSelect()->get();

        return view('users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(UserCreateDataRequest $request)
    {
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'isAdmin' => $request->has('isAdmin'),
        ]);

        return redirect()->route('users.index')->with('succes','User erfolgreich erstellt');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!User::where('id', $id)->exists()) {
            return redirect()->route('users.index')->with('error','User does not exist');
        }

        $user = User::findOrFail($id);

        return view('users.edit',compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(UserEditDataRequest $request, $id)
    {

        $request->validate([
            'username' => 'unique:users,username,'.$id
        ]);

        $user = User::findOrFail($id);

        // Update the username
        if($user->username != $request->username){
            $user->username = $request->username;
            $user->save();
        }

        // Update the password if it is provided
        if ($request->filled('password')) {
            // Check that the old password is correct
            if (Hash::check($request->password_atm, $user->password)) {
                $user->fill([
                    'password' => Hash::make($request->password)
                ])->save();
                return redirect()->route('users.index')->with('success', 'User updated');
            } else {
                return back()->withErrors(['password_atm' => 'Old password is incorrect.']);
            }
        }

        // Redirect back to the index page if no fields were updated
        return redirect()->route('users.index')->with('success', 'nohting updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::id() == $id)
            return redirect()->back()->with('error','You can not delete the user you are logged in with');

        if(!User::where('id',$id)->exists()){
            return back()->with('error','User does not exist');
        }
        try {
            User::destroy($id);
        } catch (\Exception $e) {
            return back()->with('error','This User cant be deleted.');
        }
        return redirect()->route('users.index')->with('success','User successfully deleted.');
    }
}
