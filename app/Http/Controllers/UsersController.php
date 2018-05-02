<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SubjectPermission;
use App\Http\Requests\StoreUser;
use App\Http\Requests\EditUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;
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
        $this->middleware('admin')->only(['store', 'create']);
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
        
        if(Auth::user()->user_type == 1){
            return view('user.index', compact('users'));   
        }else{
            return redirect('dashboard');
        }
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
                'title' => 'Usuarios'
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
    public function update(EditUser $request, $id){
        try{
            DB::beginTransaction();
            $user = User::findOrFail($id);
            if(empty($request->password)){
                $user->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);
            }else{
                $user->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password), 
                ]);
            }
            foreach($user->subjects as $subject){
                $subject->delete();
            }
            
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
                'title' => $user->label
            ), 200);
            
        }catch(\Exception $e){
            DB::rollback();
            return \Response::json(array(
                'error' => $e->getMessage(),
            ), 400);
            ;
        }
    }
    public function show(Request $request, $id){
        $user = User::findOrFail($id);
        if(Auth::user()->user_type == 1 || $user->id == Auth::id()){
            return view('user.show', compact('user'));      
        }else{
            return redirect('dashboard');
        }
    }
    public function destroy($id){
        try{
            DB::beginTransaction();
            $response = $title = '';
            $user = User::findOrFail($id);
            $key = $user->enabled;
            if($key == 1){
                $user->enabled = 0;
                $user->save();
                $title = 'Usuario desactivado.';
                $response = 'Este usuario ya no tendrá acceso al portal. <br> Puede deshacer esta acción en cualquier momento.';
            }
            if($key == 0){
                $user->enabled = 1;
                $user->save();
                $title = 'Usuario activado.';
                $response = 'Este usuario tendrá aceso al portal. <br> Puede deshacer esta acción en cualquier momento.';
            }
            
            DB::commit();
             
            
            return \Response::json(array(
                'response' => $response,
                'location' => '/users'.'/'.$id,
                'title' => $title
            ), 200);
            
        }catch(\Exception $e){
            DB::rollback();
            return \Response::json(array(
                'error' => $e->getMessage(),
            ), 400);
            ;
        }
    }
}
