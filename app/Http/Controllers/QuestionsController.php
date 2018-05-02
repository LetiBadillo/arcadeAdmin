<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuestion;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    //   
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
            return Question::all();
        }elseif($request->ws == "search"){
            if($request->search == ""){
                return Question::all();
            }
            $query = Question::
            where('questions.question', 'like', '%'.$request->search.'%');
            
            if($request->enabled){
                $query->where('questions.enabled', $request->enabled);
            }
            return $query->get();
        }else{
            $questions = Question::paginate(8);
        }
    }
    public function create(){
        return view('question.create');
    }

    public function store(StoreQuestion $request){
        try{
            DB::beginTransaction();
            $question = Question::create($request->all());

            Option::create([
            'question_id' => $question->id, 
            'option' => $request->answer, 
            'is_answer' => true]);

            if($request->options){
                foreach($request->options as $option){
                    Option::create([
                        'question_id' => $question->id, 
                        'option' => $option, 
                        'is_answer' => false
                    ]);
                }
            }
            
            DB::commit();
            return \Response::json(array(
                'response' => 'Cambios guardados correctamente.',
                'location' => '/subjects'.'/'.$request->subject_id,
                'title' => 'Pregunta'
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
        $question = Question::findOrFail($id);
        return view('question.edit', compact('question'));
    }
    public function update(Request $request, $id){
        try{
            DB::beginTransaction();
            $question = Question::findOrFail($id);
            foreach($question->options as $option){
                $option->delete();
            }
            Option::create([
            'question_id' => $id, 
            'option' => $request->answer, 
            'is_answer' => true]);

            if($request->options){
                foreach($request->options as $option){
                    Option::create([
                        'question_id' => $question->id, 
                        'option' => $option, 
                        'is_answer' => false
                    ]);
                }
            }
            
            DB::commit();
            return \Response::json(array(
                'response' => 'Cambios guardados correctamente.',
                'location' => '/subjects'.'/'.$request->subject_id,
                'title' => 'Pregunta'
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
        $question = Question::findOrFail($id);
        if($request->getInfo){
            return $question;
        }
        
    }
    public function destroy($id){
        try{
            DB::beginTransaction();
            $response = '';
            $question = Question::findOrFail($id);
            $key = $question->enabled;
            if($key == 1){
                $question->enabled = 0;
                $question->save();
                $response = 'Pregunta desactivada.';
                foreach($question->options as $option){
                    $option->enabled = 0;
                    $option->save();
                }
            }
            if($key == 0){
                $question->enabled = 1;
                $question->save();
                $response = 'Pregunta activada.';
                foreach($question->options as $option){
                    $option->enabled = 1;
                    $option->save();
                }
            }
            
            DB::commit();
             
            
            return \Response::json(array(
                'response' => $response,
                'location' => '/subjects'.'/'.$question->subject->id,
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
