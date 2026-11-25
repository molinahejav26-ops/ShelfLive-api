<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /** Listado de usuarios. */
    public function index()
    {
        return UserResource::collection(User::orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'user', 'guest'])],
            'blocked' => ['sometimes', 'boolean'],
        ]);

        // forceCreate porque role y blocked no son "fillable"; la contraseña se cifra sola (cast "hashed")
        $user = User::forceCreate($data);

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'user', 'guest'])],
            'blocked' => ['sometimes', 'boolean'],
        ]);

        // la contraseña solo se cambia si se envía una nueva
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->forceFill($data)->save();

        return new UserResource($user);
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return response()->json(['message' => 'No puedes eliminar tu propia cuenta.'], 403);
        }

        $user->delete();

        return response()->noContent();
    }
}
