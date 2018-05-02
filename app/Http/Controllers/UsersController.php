<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;

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
        
        return view('user.show', compact('users'));
    }
    public function create(){
        return view('user.create');
    }

    public function store(StoreUser $request){
        
        try{
            DB::beginTransaction();
            $user = User::create($request->all());
            if($request->subject_id){
                foreach($request->user_id as $id){
                    SubjectPermission::create([
                        'user_id' => $user->$id,
                        'subject_id' => $request->subject_id
                    ]);
                }
            }
            
            DB::commit();
             $response = '<div class="text-uppercase text-center">
            <h1>'.$subject->subject_name.'</h1>
            <p>'.$subject->subject_branch->branch_name.'</p> <hr>';
            
            if($subject->assignedUsers){
                $response .= '<p>Maestros asignados</p>
                <ul class="text-center">';
                foreach($subject->assignedUsers as $user){
                    $response .=  '<li>'.$user->label.'</li>'; 
                }    
            
                $response.'</ul>';
            }else{
                $response .= '<p>Aún no hay tutores asignados.</p>';
            }
            
            return \Response::json(array(
                'response' => $response.'</div>',
                'location' => '/subjects'.'/'.$subject->id,
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
        return view('user.show');
    }
    public function destroy($id){
        $user = User::findOrFail($id)->delete();
        return \Redirect::back();
    }
}
