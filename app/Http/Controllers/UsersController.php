<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SubjectPermission;
use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UsersController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $users = User::all();
        if($request->ws == "all"){
            return $users;
        }elseif($request->ws== "bySubject"){
            if($request->id){
                return User::join('subjects_permissions', 'users.id', '=', 'subjects_permissions.user_id')
                ->where('subjects_permissions.subject_id', $request->id)->get();
            }
        }
        
        return view('user.index', compact('users'));
    }
    public function create(){
        return view('user.create');
    }

    public function store(StoreUser $request){
        
        try{
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name, 
                'last_name' => $request->last_name, 
                'email' => $request->email, 
                'password' => Hash::make($request->password), 
                'user_type' => 2
            ]);
            if($request->subjects){
                foreach($request->subjects as $id){
                    SubjectPermission::create([
                        'user_id' => $user->id,
                        'subject_id' => $id
                    ]);
                }
            }
            
            DB::commit();
           
            return \Response::json(array(
                'response' => 'Cambios guardados correctamente',
                'location' => '/users'.'/'.$user->id,
            ), 200);
            
        }catch(\Exception $e){
            DB::rollback();
            return \Response::json(array(
                'error' => $e->getMessage(),
            ), 400);
            ;
        }
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
        return view('user.show', compact('user'));
    }
    public function destroy($id){
        $user = User::findOrFail($id)->delete();
        return \Redirect::back();
    }
}
