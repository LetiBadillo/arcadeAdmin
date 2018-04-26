<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
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

    public function store(Request $request){
        $subject = Subject::create($request->all());
        return redirect('subject');
    }

    public function edit(Request $request, $id){
        $subject = Subject::findOrFail($id);
        return view('subject.edit', compact('subject'));
    }
    public function update(Request $request, $id){
        $subject = Subject::findOrFail($id)->update($request->all());
        return redirect('subject');
    }
    public function show(Request $request, $id){
        $subject = Subject::findOrFail($id);
    }
    public function destroy($id){
        $subject = Subject::findOrFail($id)->delete();
        return \Redirect::back();
    }
}
