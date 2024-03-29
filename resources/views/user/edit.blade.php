@extends('layouts.app')
@section('title', 'Actualizar usuario')

@section('content')
    <div class="d-flex justify-content-center mt-5 ">
        <form class="col-4 g-3  border  p-5 m-5 rounded shadow-lg p-3 mb-5 bg-white  border-radius-lg"
            action="{{ route('users.update', $user->id) }}" method="POST">
            <h2>Actualizar Usuario</h2>
            @method('PUT')

            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com"
                    value="{{ $user->email }}" >
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Digite su nombre"
                    value="{{ $user->name }}" required>
            </div>
            
            <div class="d-flex justify-content-center ">
                <a class="btn btn-warning text-center m-2" href="{{ route('users.index') }}">Cancelar</a>

                <button type="submit" class="btn btn-success text-center m-2">Actualizar</button>
            </div>

        </form>

    </div>
@endsection
