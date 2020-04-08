<?php

namespace Webdev\Http\Controllers\Admin\UserManagement;

use Webdev\Models\User;
use Illuminate\Http\Request;
use Webdev\Http\Controllers\Controller;

class WDUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = [];
        $users = User::paginate(10);
        foreach($users as $user){
            $userRoles = [];
            $amount_roles = count($user->roles);
            $counter = 1;
            //Get all Roles for each User
            foreach($user->roles as $role){
                if($amount_roles == $counter){
                    //Last item
                    array_push($userRoles,$role->name);
                }else{
                    array_push($userRoles,$role->name.',');
                }
                $counter++;
            }
            array_push($roles,$userRoles);
        }
        return view('admin.user_management.users.index',[
            'roles' => $roles,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user_management.users.create',[
            'user' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = $request->validate([
            'login' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:wdusers',
            'password' => 'required|string|min:6|confirmed',
        ]);
        User::create([
            'login' => $request['login'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
        return redirect()->route('admin.user_management.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Webdev\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Webdev\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('admin.user_management.users.edit',[
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validation = $request->validate([
            'login' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('wdusers')->ignore($id)
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        //Find User
        $user = User::find($id);
        $user->login = $request->get('login');
        $user->email = $request->get('email');
        $request->get('password') == null ?: $user->password = bcrypt($request->get('password'));
        $user->save();
        
        return redirect()->route('admin.user_management.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user_management.user.index');
    }
}
