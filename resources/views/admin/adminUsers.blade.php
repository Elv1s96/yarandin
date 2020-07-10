@extends('layouts.app')
@section('title-block')@lang('main.users') @endsection
@section('content')
    <div class="col-md-12">
        <h1>@lang('main.users')</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    @lang('main.name')
                </th> <th>
                    @lang('main.email')
                </th><th>
                    @lang('main.role')
                </th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@endsection
