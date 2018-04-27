<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request){
        $users = User::all();
        if($request->ws == "all"){
            return $users;
        }
        
        return view('user.index', compact('users'));
    }
    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
        $user = User::create($request->all());
        return redirect('user');
    }

    public function edit(Request $request, $id){
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $id){
        $user = User::findOrFail($id)->update($request->all());
        return redirect('user');
    }
    public function show(Request $request, $id){
        $user = User::findOrFail($id);
    }
    public function destroy($id){
        $user = User::findOrFail($id)->delete();
        return \Redirect::back();
    }
}
