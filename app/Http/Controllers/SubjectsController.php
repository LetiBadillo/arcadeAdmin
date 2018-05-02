<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use App\Models\Question;
use App\Models\SubjectPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubject;

class SubjectsController extends Controller
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
        if($request->ws == "all"){
            return Subject::all();
        }elseif($request->ws == "search"){
            return Subject::
            join( 'subject_branches', 'subject_branches.id', '=', 'subjects.subject_branch_id' )
            ->where('subjects.subject_name', 'like', $request->search.'%')
	        ->orWhere( 'subject_branches.branch_name', 'like', $request->search.'%')
            ->get();
        }else{
            $subjects = Subject::paginate(8);
        }
        return view('subject.index', compact('subjects'));
    }
    public function create(){
        return view('subject.create');
    }

    public function store(StoreSubject $request){
        try{
            DB::beginTransaction();
            $subject = Subject::create($request->all());
            if($request->user_id){
                foreach($request->user_id as $id){
                    SubjectPermission::create([
                        'user_id' => $id,
                        'subject_id' => $subject->id
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

    public function edit(StoreSubject $request, $id){
        
    }
    public function update(StoreSubject $request, $id){
        try{
            DB::beginTransaction();
            $subject = Subject::findOrFail($id);
            $subject->update($request->all());
            if($subject->assignedUsers){
                foreach($subject->permissions as $user){
                    $user->delete();
                }    
                    
            }
            if($request->user_id){
                foreach($request->user_id as $user){
                    SubjectPermission::create([
                        'user_id' => $user,
                        'subject_id' => $id
                    ]);
                }
            }
            
            DB::commit();
             $response = 'Cambios guardados correctamente.';
            
            return \Response::json(array(
                'response' => $response,
                'location' => '/subjects'.'/'.$id,
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
        $subject = Subject::findOrFail($id);
        return view('subject.show', compact('subject'));
    }
    public function destroy($id){
        try{
            DB::beginTransaction();
            $response = '';
            $subject = Subject::findOrFail($id);
            $key = $subject->enabled;
            if($key == 1){
                $subject->enabled = 0;
                $subject->save();
                $response = 'Materia desactivada.';
            }
            if($key == 0){
                $subject->enabled = 1;
                $subject->save();
                $response = 'Materia activada.';
            }
            
            DB::commit();
             
            
            return \Response::json(array(
                'response' => $response,
                'location' => '/subjects'.'/'.$id,
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
