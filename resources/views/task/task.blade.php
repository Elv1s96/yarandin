@extends('layouts.app')
@section('title-block')Задачи @endsection
@section('content')
    @guest
        <div class="alert alert-danger">
            @lang('main.to_view_you_must_register')
        </div>
    @endguest
    @auth
        <div class="col-md-12">
            <h1>@lang('main.tasks')</h1>
            <table class="table">
                <tbody>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        @lang('main.task')
                    </th>
                    <th>
                        @lang('main.project_status')
                    </th>
                    <th>
                        @lang('main.project')
                    </th>
                </tr>
                @if(isset($tasks))
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td>@if( $task->status == 1 ) @lang('main.new') @elseif( $task->status == 2 ) @lang('main.in_process') @elseif( $task->status == 3 ) @lang('main.done') @endif</td>
                        <td>{{ $task->project->name }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-success" type="button"
                                       href="{{ route('task.edit',$task) }}">@lang('main.Edit')</a>
                                    @if($task->file_name)
                                        <a class="btn btn-warning" type="button"
                                           href="{{ route('task.file_download',$task->id) }}">@lang('main.download_file')</a>
                                    @else
                                        <span class="btn btn-warning">@lang('main.file_missing')</span>
                                    @endif
                                    <input class="btn btn-danger" type="submit" value="{{__('main.delete')}}"></form>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        {{ $tasks->links() }}
        @endif
        <a href="{{ route('task.create') }}">
            <button class="btn btn-success">@lang('main.create_task')</button>
        </a>
    @endauth
@endsection
