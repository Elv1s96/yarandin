@extends('layouts.app')
@section('title-block')@lang('main.create_task') @endsection
@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('task.store') }}">
        @csrf
        <div class="form-row">
            <div class="col-md-3">
                <label for="name">@lang('main.task_name')</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Задача" required>
            </div>
            <div class="form-group col-md-3">
                <label for="inputCity">@lang('main.project')</label>
                <select id="project_id" name="project_id" class="form-control">
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" id="project_id" name="project_id">{{ $project->name }}</option>
                        @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="inputState">@lang('main.project_status')</label>
                <select id="status" name="status" class="form-control">
                    <option value="1" id="status" name="status">@lang('main.new')</option>
                    <option value="2" id="status" name="status">@lang('main.in_process')</option>
                    <option value="3" id="status" name="status">@lang('main.done')</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="file_name">@lang('main.upload_file')</label>
                <div class="col-sm-10">
                    <label class="btn btn-danger btn-file">
                        @lang('main.download') <input type="file" style="display: none;" name="file_name" id="file_name">
                    </label>
                </div>
            </div>
        </div>
        <button class="btn btn-success">@lang('main.save')</button>
    </form>
@endsection
