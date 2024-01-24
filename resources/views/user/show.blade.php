@extends('layouts.app')
@section('title', 'Usuario')

@section('content')
    <div class="d-flex justify-content-center mt-5 ">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{ asset('images/user.png') }}" alt="Usuario">
            <div class="card-body">
                <p> <b>Email:</b>{{ $user->email }}</p>
                <b>Nombre:</b>{{ $user->name }}</p>
            </div>
            <div class="d-flex justify-content-center ">
                <a class="btn btn-warning text-center  m-3 " href="{{ route('users.index') }}">Atras</a>
            </div>
        </div>
    </div>
@endsection
