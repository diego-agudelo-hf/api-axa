@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
    <div class="d-flex justify-content-center m-3">
        <h1>Usuarios</h1>
    </div>
    @if (count($users) > 0)
        <table class="table caption-top table-bordered shadow-lg p-3 mb-5 bg-white rounded border-radius-lg ">
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="col-1">{{ $user->id }}</td>
                        <td class="col-3">{{ $user->name }}</td>
                        <td class="col-3">{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <form action="{{ url('users', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>

                            <a href="{{ route('users.edit', $user->id) }}"> <button
                                    class="btn btn-primary">Editar</button></a>
                            <a href="{{ route('users.show', $user->id) }}"> <button 
                                    class="btn btn-primary">Ver</button></a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="d-flex justify-content-center ">
        <a href="{{ route('users.create') }}"> <button type="submit" class="btn btn-info text-center">Nuevo
                usuario</button></a>
    </div>
@endsection
