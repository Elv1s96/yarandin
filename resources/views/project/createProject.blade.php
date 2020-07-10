@extends('layouts.app')
@section('title-block')Создать проект @endsection
@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('project.store') }}">
        @csrf
        <div class="input-group row">
            <label for="name" class="col-sm-2 col-form-label">Название проекта: </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            </div>
        </div>
{{--        <div class="input-group row">--}}
{{--            <label for="image" class="col-sm-2 col-form-label">Файл или картинка: </label>--}}
{{--            <div class="col-sm-10">--}}
{{--                <label class="btn btn-danger btn-file">--}}
{{--                    Загрузить <input type="file" style="display: none;" name="file_name" id="file_name">--}}
{{--                </label>--}}
{{--            </div>--}}
{{--        </div>--}}
        <button class="btn btn-success">Сохранить</button>
    </form>
@endsection
