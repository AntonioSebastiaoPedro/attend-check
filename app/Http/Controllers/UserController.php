<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index()
    {
        $teachers = User::teachers()->paginate(10);
        return view('users.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Professor cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(User $user)
    {
        // Garante que não editamos admins por esta rota se não for pretendido
        if ($user->isAdmin() && auth()->user()->id !== $user->id) {
            return redirect()->route('users.index')->with('error', 'Ação não permitida.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Dados do professor atualizados!');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'Não é possível remover um administrador.');
        }

        // Verifica se o professor tem turmas associadas
        if ($user->classes()->count() > 0) {
            return redirect()->route('users.index')
                ->with('error', 'Este professor não pode ser removido pois possui turmas associadas.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Professor removido com sucesso!');
    }
}
