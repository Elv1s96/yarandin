@extends('layouts.app')
@section('title-block')Создать проект @endsection
@section('content')
    <div class="col-md-12">
        <h1>Проект: {{ $project->name }}</h1>
    </div>
    <h2>Пользователи, прикрепленные к проекту</h2>
    <table class="table">
        <tbody>
        <tr>
            <th>
                #
            </th>
            <th>
                имя
            </th><th>

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
                            <input class="btn btn-danger" type="submit" value="Удалить"></form>
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>

    </table>
@endsection
