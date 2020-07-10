<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset(Auth::user()->id)) {
            return redirect()->route('home');
        } else {
            $projects = Project::paginate(10);
            return view('project.project', compact('projects'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *Fsh
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.createProject');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $params = $request->all();
        if (isset(Auth::user()->id)) {
            $params['user_id'] = Auth::user()->id;
        }
        Project::create($params);
        return redirect()->back()->with('success', 'Проект создан');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.showProject', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $users = user::get();
        return view('project.editProject', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        DB::table('tasks')->where('project_id', $project->id)->delete();
        $project->delete();
        return redirect()->back()->with('success', 'Проект удален');
    }

    public function myProjects()
    {
        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
        } else {
            return redirect()->route('home');
        }
        $projects = Project::where('user_id', $user_id)->paginate(5);
        return view('project.project', compact('projects'));
    }

    public function addUserToProject(Project $project, Request $request, $project_id)
    {
        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
        }
        $checkUser = DB::table('project_user')->where('user_id', $request->user_id)->where('project_id', $project_id)->first();
        if ($checkUser != null) {
            return redirect()->back()->with('warning', 'Пользователь уже прикреплен');
        }
        $request->all();
        $project->users()->attach($request->user_id, ['project_id' => $project_id]);
        return redirect()->back()->with('success', 'Пользователь добавлен');
    }

    public function deleteUser(Request $request, $project_id, Project $project)
    {
        DB::table('project_user')->where('project_id', $project_id)->where('user_id', $request->user_id)->delete();
        return redirect()->back()->with('success', 'Пользователь удален из проекта ');
    }
}
