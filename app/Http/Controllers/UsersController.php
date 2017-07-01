<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /*
     * 创建用户
     */
    public function create(){
        return view('users.create');
    }

    /*
     * 展示用户
     */
    public function show($id){
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    /*
     * 验证并且注册用户
     */
    public function store(Request $request){
        $this->validate($request,[
           'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required'
        ]);

        $user = User::create([
           'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        session()->flash('success','欢迎,您将在这里开启一段新的旅程');
        return redirect()->route('users.show',[$user]);
    }
}
