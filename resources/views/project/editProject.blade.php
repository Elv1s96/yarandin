@extends('layouts.app')
@section('title-block')@lang('main.create_project') @endsection
@section('content')

    <div class="col-md-12">
        <h2>@lang('main.my_project') № {{ $project->user_id }}</h2>
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

            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->name }}</td>
            </tr>

            </tbody>

        </table>
    </div>
    <h2>@lang('main.users_attached_to_this_project')</h2>
    <table class="table">
        <tbody>
        <tr>
            <th>
                #
            </th>
            <th>
                @lang('main.name')
            </th>
            <th>

            </th>
        </tr>
        @foreach($project->users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <form action="{{ route('project.delete.user', $project->id) }}" method="POST">
                            @csrf
                            <input hidden id="user_id" name="user_id" value="{{ $user->id }}">
                            <input class="btn btn-danger" type="submit" value="{{__('main.delete')}}"></form>
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>

    </table>
    <div class="form-group col-md-3">
        <label for="inputState">@lang('main.add_user')</label>
        <form method="POST" enctype="multipart/form-data" action="{{ route('projects.add.user',$project->id) }}">
            @csrf
            <select id="status" name="user_id" id="user_id" class="form-control">
                @foreach($users as $user)
                    @if($user->id!= Auth::user()->id)
                        <option value="{{ $user->id }}" id="user_id" name="user_id">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-success">@lang('main.add_user')</button>
        </form>
    </div>
@endsection
