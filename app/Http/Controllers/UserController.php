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
     * Exibe uma listagem de professores.
     */
    public function index()
    {
        $users = $this->userService->getPaginatedTeachers();
        return view('users.index', compact('users'));
    }

    /**
     * Mostra o formulário para criar um novo professor.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Armazena um novo professor no banco de dados.
     */
    public function store(StoreUserRequest $request)
    {
        $this->userService->createTeacher($request->validated());

        return redirect()->route('users.index')
            ->with('success', 'Professor cadastrado com sucesso!');
    }

    /**
     * Mostra o formulário para editar o professor especificado.
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
     * Atualiza o professor especificado no banco de dados.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->updateTeacher($user, $request->validated());

        return redirect()->route('users.index')
            ->with('success', 'Dados do professor atualizados!');
    }

    /**
     * Remove o professor especificado do banco de dados.
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
