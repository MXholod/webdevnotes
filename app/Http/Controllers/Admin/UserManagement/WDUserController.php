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
        return view('admin.user_management.users.index',[
            'users' => User::paginate(10)
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Webdev\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Webdev\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
