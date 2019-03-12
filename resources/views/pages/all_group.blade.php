@extends('layouts.app')

@section('content')
        <h1>Работа с группами</h1>
        <form class="form-inline" action="/group" method="post">
            <div class="form-group mx-sm-3 mb-2">
                <label for="Group" >Добавить группу:</label>
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
                <th scope="col">Удалить группу</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($groups as $group)
                <tr>
                    <th scope="row">{{ $group->id }}</th>
                    <td>{{ $group->name }}</td>
                    <td>
                        <form action="/group/{{ $group['id'] }}" method="POST">
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