<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Service\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function __construct(private UserService $loginService){

    }

    private $messages = [
        'email.required' => 'O campo e-mail é obrigatório',
        'email.email' => 'O e-mail informado não é válido',
        'password.required' => 'O campo senha é obrigatório',
        'password.confirmed' => 'As senhas devem ser iguais',
        'password.min' => 'A senha deve ter pelo menos 8 caracteres',
        'password.regex' => 'A senha deve conter letras maiúsculas e caracteres especiais.',
        'email.exists' => 'O e-mail informado não está cadastrado no nosso sistema'
    ];

    public function Register(Request $request){
        return view('Users.cadastro');
    }

    public function ChangePassword(Request $request){
        return view('Users.alterar_senha');
    }

    public function Login(){
        return view('Users.login');
    }

    public function Create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/\W/'],
            'terms' => 'required'
        ], $this->messages);

        try {
            $user = $this->loginService->CreateUser($validated);

            Auth::login($user);

            event(new Registered($user));

            return redirect()->route('verification.notice')->with('success', 'Conta criada com sucesso! Por favor, verifique seu e-mail.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar uma conta: ' . $e->getMessage());
        }
    }

    public function Update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/\W/'],
        ], $this->messages);

        try {
            $this->loginService->UpdateUser($validated);
            return redirect()->route('user.login')->with('success', 'Senha alterada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar a senha: ' . $e->getMessage());
        }
    }
    public function Authenticate(Request $request){

        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/\W/'],
        ], $this->messages);

        try {
            $user = $this->loginService->VerifyLogin($validated);
            Auth::login($user);

            return redirect()->route('movies.index');
        }
        catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'E-mail não cadastrado.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
    public function Logout(){
        Auth::logout();
        return redirect()->route('user.login')->with('success', 'Você saiu da conta com sucesso!');
    }

}
