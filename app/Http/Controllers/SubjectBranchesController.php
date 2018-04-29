<?php

namespace App\Http\Controllers;
use App\Models\SubjectBranch;
use Illuminate\Http\Request;

class SubjectBranchesController extends Controller
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
        $branches = SubjectBranch::all();
        if($request->ws == "all"){
            return $branches;
        }
        
        return view('branch.index', compact('branches'));
    }
    public function create(){
        return view('branch.create');
    }

    public function store(Request $request){
        $branch = SubjectBranch::create($request->all());
        return redirect('branch');
    }

    public function edit(Request $request, $id){
        $branch = SubjectBranch::findOrFail($id);
        return view('branch.edit', compact('branch'));
    }
    public function update(Request $request, $id){
        $branch = SubjectBranch::findOrFail($id)->update($request->all());
        return redirect('branch');
    }
    public function show(Request $request, $id){
        $branch = SubjectBranch::findOrFail($id);
    }
    public function destroy($id){
        $branch = SubjectBranch::findOrFail($id)->delete();
        return \Redirect::back();
    }
}
