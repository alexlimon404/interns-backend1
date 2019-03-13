@extends('emails.layouts.base')
@section('content')
    <p>Обновился профиль с id: {{ $id }}:</p>
    <p>{{ $oldName . "=>" . $newName }}</p>
@endsection