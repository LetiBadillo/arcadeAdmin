<?php

namespace App\Http\Controllers;
use App\Models\Subject;
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
        $subjects = Subject::all();
        if($request->ws == "all"){
            return $subjects;
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

    public function edit(Request $request, $id){
        $subject = Subject::findOrFail($id);
        return view('subject.edit', compact('subject'));
    }
    public function update(Request $request, $id){
        $subject = Subject::findOrFail($id)->update($request->all());
        return redirect('subjects');
    }
    public function show(Request $request, $id){
        return $subject = Subject::findOrFail($id);
    }
    public function destroy($id){
        $subject = Subject::findOrFail($id)->delete();
        return \Redirect::back();
    }
}
