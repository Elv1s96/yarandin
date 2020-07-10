<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
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
        }

        $userId = Auth::user()->id;
        $is_Admin = Auth::user()->is_admin;
        if ($is_Admin == 1) {
            $tasks = Task::paginate(10);
        } else {
            $projects = Project::where('user_id', $userId)->get('id');

            foreach ($projects as $project) {
                $ids[] = $project->id;
            }
            if (isset($ids) && !empty($ids))
                $tasks = Task::whereIn('project_id', $ids)->paginate(10);
        }
        if (isset($ids) || $is_Admin == 1) {
            return view('task.task', compact('tasks'));
        } else {
            return view('task.task');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$projects = Project::get();
        $projects = Project::where('user_id', Auth::user()->id)->get();
        return view('task.createTask', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $params = $request->all();
        $task_name = $request->task_name;
        $task_project_name = $request->task_project_name;
        if ($request->status == 1) {
            $status = "New";
        } elseif ($request->status == 2) {
            $status = "In process";
        } elseif ($request->status == 3) {
            $status = "Done";
        }
        if (isset($params['file_name'])) {
            $file_name = $params['file_name'];
            unset($params['file_name']);
            if ($request->has('file_name')) {
                $params['file_name'] = $request->file('file_name')->storeAs('files', $file_name->getClientOriginalName());
            }
            $check = Task::where('file_name', $params['file_name'])->first();
            if ($check != null) {
                return redirect()->route('task.create')->with('warning', 'Имя загружаемого файла уже существует');
            }
        }


        Task::create($params);
        return redirect()->route('task.index')->with('success', 'Задача добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(TaskRequest $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $users = user::get();
        return view('task.editTask', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        if ($request->status == 1) {
            $status = "New";
        } elseif ($request->status == 2) {
            $status = "In process";
        } elseif ($request->status == 3) {
            $status = "Done";
        }
        $name = Auth::user()->name;
        $email = Auth::user()->email; //'danylevskyegor@gmail.com';
        $task_name = $request->task_name;
        $task_project_name = $request->task_project_name;
        Mail::to($email)->send(new SendMail($name, $email, $task_name, $task_project_name, $status));
        $params = $request->all();
        unset($params['task_name']);
        unset($params['task_project_name']);
        $task->update($params);
        return redirect()->back()->with('success', 'Статус поменян');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->with('success', 'Задача удалена');
    }

    public function filterTasks($task_status)
    {
        if (!isset(Auth::user()->id)) {
            return redirect()->route('home');
        }
        if ($task_status == 'new') {
            $status = 1;
        } elseif ($task_status == 'in_process') {
            $status = 2;
        } elseif ($task_status == 'done') {
            $status = 3;
        }
        $userId = Auth::user()->id;
        $is_Admin = Auth::user()->is_admin;
        if ($is_Admin == 1) {
            $tasks = Task::where('status', $status)->paginate(5);
        } else {
            $projects = Project::where('user_id', $userId)->get('id');
            foreach ($projects as $project) {
                $ids[] = $project->id;
            }
            $tasks = Task::where('status', $status)->where('project_id', $ids)->paginate(5);
        }
        return view('task.task', compact('tasks'));
    }

    public function fileDownload(Request $request, Task $task)
    {
        $file_name = Task::where('id', $task->id)->value('file_name');
        return response()->download(storage_path("app/public/{$file_name}"));

    }

    public function addUserToTask(Task $task, Request $request, $task_id)
    {
        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
        }
        $checkUser = DB::table('task_user')->where('user_id', $request->user_id)->where('task_id', $task_id)->first();
        if ($checkUser != null) {
            return redirect()->back()->with('warning', 'Пользователь уже прикреплен');
        }
        $request->all();
        $task->users()->attach($request->user_id, ['task_id' => $task_id]);
        return redirect()->back()->with('success', 'Пользователь добавлен');
    }

    public function deleteUser(Request $request, $task_id, Task $task)
    {
        DB::table('task_user')->where('task_id', $task_id)->where('user_id', $request->user_id)->delete();
        return redirect()->back()->with('success', 'Пользователь удален из проекта ');

    }
}
