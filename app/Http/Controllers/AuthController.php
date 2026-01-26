<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Mostra o formulário de login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Processa o pedido de login.
     */
    public function login(LoginRequest $request)
    {
        if ($this->authService->login($request->validated(), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Bem-vindo de volta!');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Processa o pedido de logout.
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect()->route('login')
            ->with('success', 'Logout realizado com sucesso!');
    }
}
