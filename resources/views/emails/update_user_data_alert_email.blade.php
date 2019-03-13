@extends('emails.layouts.base')
@section('content')
    <p>Пользователь с email: {{$emailAdmin}} обновил информацию пользователя с id: {{ $id }}:</p>
    <p>Имя: {{$oldName . " => " . $newName}}</p>
    <p>Роль: {{$oldRole . " => " . $newRole}}</p>
    <p>{{!$banned ? : "Пользователь забанен" }}</p>
@endsection