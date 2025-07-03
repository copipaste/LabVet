<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $usuarios = User::with('roles:name')
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->through(function ($user) {
            return [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'email' => $user->email,
                'roles' => $user->getRoleNames(), // obtiene los roles como array de strings
            ];
        });

        return Inertia::render('usuario/Index', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name'); // Obtiene solo los nombres de roles
        return Inertia::render('usuario/Create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|exists:roles,name',
        ]);

        $usuario = User::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'direccion' => $validated['direccion'],
            'password' => Hash::make($validated['password']),
        ]);

        $usuario->assignRole($validated['rol']);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::with('roles:name')->findOrFail($id);
       
        return Inertia::render('usuario/Show', [
            'usuario' => $usuario
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles:name')->findOrFail($id);
        return Inertia::render('usuario/Edit', [
                'usuario' => [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'email' => $user->email,
                'roles' => $user->getRoleNames(), // ['admin']
            ],
            'rolesDisponibles' => Role::pluck('name'), // ['admin', 'cliente', ...]
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6|confirmed',
                'rol' => 'required|exists:roles,name',
            ]);

            $usuario = User::findOrFail($id);

            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;

            if ($request->filled('password')) {
                $usuario->password = Hash::make($request->password);
            }

            $usuario->save();

            // Eliminar roles anteriores y asignar el nuevo
            $usuario->syncRoles([$request->rol]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
            }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
    

        // Evita eliminarse a uno mismo si es necesario
        if (Auth::user() && Auth::user()->id === $usuario->id) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Elimina los roles y luego el usuario
        $usuario->syncRoles([]);
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}


















































