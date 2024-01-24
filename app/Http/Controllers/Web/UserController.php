<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserWebRequest;
use App\Http\Requests\UpdateUserWebRequest;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view("user.index")->with("users",  $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserWebRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
        } catch (\Exception $th) {
            return redirect()->route("users.create")->withErrors('Ocurrió un error al crear el usuario' . $th->getMessage());
        }

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return view("errors.404");
        }
        return view("user.show")->with("user",  $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return view("errors.404");
        }
        return view("user.edit")->with("user",  $user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserWebRequest $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return view("errors.404");
            }
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
        } catch (\Exception $th) {
            return redirect()->back()->withErrors(
                'Ocurrió un error al actualizar el usuario:' . $th->getMessage()
            );
        }
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return view("errors.404");
        }
        $user->delete();
        return redirect('users');
    }
}
