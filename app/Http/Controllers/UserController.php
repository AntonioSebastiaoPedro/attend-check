<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of teachers.
     */
    public function index()
    {
        $users = $this->userService->getPaginatedTeachers();
        return view('users.index', compact('users'));
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
    public function store(StoreUserRequest $request)
    {
        $this->userService->createTeacher($request->validated());

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
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->updateTeacher($user, $request->validated());

        return redirect()->route('users.index')
            ->with('success', 'Dados do professor atualizados!');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(User $user)
    {
        try {
            $this->userService->deleteTeacher($user);
            return redirect()->route('users.index')
                ->with('success', 'Professor removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', $e->getMessage());
        }
    }
}
