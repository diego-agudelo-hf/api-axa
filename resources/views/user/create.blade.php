@extends('layouts.app')
@section('title', 'Nuevo usuario')

@section('content')
    <div class="d-flex justify-content-center mt-5 ">
        <form class="col-4 g-3  border  p-5 m-5 rounded shadow-lg p-3 mb-5 bg-white  border-radius-lg"
            action="{{ url('users') }}" method="POST">
            <h2>Crear Usuario</h2>

            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com"
                    value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Digite su nombre"
                    value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="********"
                    value="{{ old('password') }}" required>
            </div>
            <div class="d-flex justify-content-center ">
                <button type="submit" class="btn btn-success text-center">Crear Usuario</button>
            </div>

        </form>
    </div>
@endsection
