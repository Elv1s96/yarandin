@extends('layouts.app')
@section('title-block')@lang('main.project') @endsection
@section('content')
    @guest
        <div class="alert alert-danger">
            @lang('main.to_view_you_must_register')
        </div>
    @endguest
    @auth
    <div class="col-md-12">
        <h1>@lang('main.project')</h1>
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
    @foreach($projects as $project)
        <tr>
            <td>{{ $project->id }}</td>
            <td><span @if($project->user_id == Auth::user()->id) style="color:red;" @endif>{{ $project->name }}</span> </td>
            <td>
                <div class="btn-group" role="group">
                    @if(Route::currentRouteName() == 'my.projects' || Auth::user()->is_admin == 1)
                    <form action="{{ route('project.destroy', $project->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-success" type="button" href="{{ route('project.edit',$project) }}">@lang('main.open')</a>
                        <input class="btn btn-danger" type="submit" value="{{ __('main.delete') }}"></form>
                    @endif


                </div>
            </td>
        </tr>
        @endforeach
            </tbody>
        </table>
    </div>
    {{ $projects->links() }}
    <a href="{{ route('project.create') }}"><button class="btn btn-success">@lang('main.create_project')</button></a>
    @endauth
@endsection
