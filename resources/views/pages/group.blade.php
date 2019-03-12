@extends('layouts.app')

@section('content')
        <h1>Работа с группами пользователя</h1>
        <form class="form-inline" action="/group" method="post">
            <div class="form-group mx-sm-3 mb-2">
                <label for="Group">Добавить группу:</label>
                <input type="" class="form-control" id="Group" aria-describedby="Group" name="name" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Добавить</button>
            {{ method_field('post') }}
            {{ csrf_field() }}
        </form>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Group</th>
                <th scope="col">ButtonDelete</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($groups as $group)
            <tr>
                <th scope="row">{{ $group->id }}</th>
                <td>{{ $group->name }}</td>
                <td><button type="button" class="btn btn-primary">Primary</button>
            </tr>
            @endforeach
            </tbody>
        </table>
@endsection