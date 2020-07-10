@extends('layouts.app')
@section('title-block')Создать проект @endsection
@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ route('task.update',$task) }}">
    @method('PUT')
    @csrf
    <div class="form-row">
        <input hidden id="task_name" name="task_name" value="{{ $task->name }}">
        <input hidden id="task_project_name" name="task_project_name" value="{{ $task->project->name }}">
        <div class="col-md-3">
            <label >@lang('task_name')</label>
            <input type="text" class="form-control"   value="{{$task->name }}" readonly>
        </div>
        <div class="form-group col-md-3">
            <label >@lang('main.project')</label>
            <input type="text" class="form-control"
                   value="{{ $task->project->name }}"
                   readonly>
        </div>
        <div class="form-group col-md-3">
            <label for="inputState">@lang('main.project_status')</label>
            @if($task->project->user_id!=Auth::user()->id && Auth::user()->is_admin!=1)
                <input type="text" class="form-control" id="status" name="status"
                       value="@if($task->status == 1) {{__('main.new')}} @elseif($task->status == 2) {{__('main.in_process')}} @elseif($task->status == 3) {{__('main.done')}} @endif"
                       readonly>
                @else
                <select id="status" name="status" class="form-control">
                    <option @if($task->status == 1) selected @endif value="1" id="status" name="status">@lang('main.new')</option>
                    <option @if($task->status == 2) selected @endif value="2" id="status" name="status">@lang('main.in_process')</option>
                    <option @if($task->status == 3) selected @endif value="3" id="status" name="status">@lang('main.done')</option>
                </select>
                @endif

        </div>
    </div>
    @if($task->project->user_id == Auth::user()->id || Auth::user()->is_admin == 1)<button class="btn btn-success">@lang('main.save')</button>@endif
</form>
@if($task->project->user_id == Auth::user()->id || Auth::user()->is_admin == 1)
<form method="POST" enctype="multipart/form-data" action="{{ route('task.add.user',$task) }}">
    @csrf
    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="submit">@lang('main.add_user')</button>
                    </div>
                    <select class="custom-select" id="user_id" name="user_id">
                        @foreach($users as $user)
                            @if($user->id!= Auth::user()->id)
                            <option value="{{ $user->id }}" id="user_id" name="user_id">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
    </div>
</form>
@endif
<h2>@lang('main.users_attached_to_this_task'):</h2>
<table class="table">
    <tbody>
    <tr>
        <th>
            #
        </th>
        <th>
            @lang('main.name')
        </th>
    </tr>
    @foreach($task->users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>
            <div class="btn-group" role="group">
                <form action="{{ route('task.delete.user', $task->id) }}" method="POST">
                    @csrf
                    <input hidden id="user_id" name="user_id" value="{{ $user->id }}">
                    <input class="btn btn-danger" type="submit" value="Удалить"></form>
            </div>
        </td>
    </tr>
    @endforeach
    </tbody>

</table>
@endsection
