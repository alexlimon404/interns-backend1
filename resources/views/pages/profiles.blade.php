@extends('layouts.app')

@section('content')
        <h1>Работа c Profiles</h1>
        <form class="form-inline" action="/profile" method="post">
            <div class="form-group mx-sm-3 mb-2">
                <label for="profiles">Добавить Profile: </label>
                <input type="" class="form-control" id="profiles" aria-describedby="profiles" name="profile" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Добавить</button>
            {{ method_field('post') }}
            {{ csrf_field() }}
        </form>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">name</th>
                <th scope="col">user_id</th>
                <th scope="col">Удалить Profile</th>
            </tr>
            </thead>
            <tbody>
        @foreach ($profiles as $profile)
            <tr>
                <th scope="row">{{ $profile->id }}</th>
                <td>{{ $profile->name }}</td>
                <td>{{ $profile->user_id }}</td>
                <td>
                    <form action="/profile/{{ $profile['id'] }}" method="POST">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                    </form>
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
@endsection