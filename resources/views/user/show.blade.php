@extends('layouts.app')
@section('title', 'Actualizar usuario')

@section('content')
    <div class="d-flex justify-content-center mt-5 ">
        
            <h2>datos Usuario</h2>
         
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com"
                    value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Digite su nombre"
                    value="{{ $user->name }}" required>
            </div>
            
            <div class="d-flex justify-content-center ">
                <a class="btn btn-warning text-center " href="{{ route('users.index') }}">Cancelar</a>

                <button type="submit" class="btn btn-success text-center">Actualizar</button>
            </div>


    </div>
@endsection
