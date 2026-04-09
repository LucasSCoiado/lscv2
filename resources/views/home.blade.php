@extends('layout.main_layout')
@section('content')
    @if ($user->role === 'medico')
        @include('home_medicos')
    @elseif ($user->role === 'paciente')
        @include('home_pacientes')
    @elseif ($user->role === 'admin' || $user->role === 'mAdmin')
        @include('home_admins')
    @endif
@endsection