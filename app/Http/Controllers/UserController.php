<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct(){
        $this->user = New User;
    }

    public function AllUsers()
    {
        $AllUsers = $this->user->all();
        $Count = $AllUsers->count();

        if (!$Count == 0) {
            return response()->json([
                'message' => 'Usuarios buscados com sucesso!',
                'buscados' => $AllUsers
            ]);
        }

        return response()->json([
            'message' => 'Nenhum Usuario encontrado!',
        ]);
    }

    public function Create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
            ]
        ]);
    }

    public function Login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
      
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'token' => $token,
        ]);
    }

    public function Update(Request $request, $id)
    {
        $update = $this->user->where('id', $id)->first();

        $hash = hash('sha256', 'criptografiagdigital2023x' . $request->input('password'));
        
        if($update->password == $hash){
            return 'Por favor, insira outra senha, esta ja foi usada';
        }

        $update->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $hash,
            'status' => 'active',
        ]);
        return response()->json([
            'message' => 'Usuario atualizado com sucesso!',
            'atualizado' => $update
        ]);
    }

    public function Delete(){
        $this->user->where('id', Auth::id())->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso']);
    }
    
    public function Disable($id)
    {
        $Disable = $this->user->where('id', $id)->first();
        $Disable->update([
            'status' => 'disable'
        ]);
        return response()->json([
            'message' => 'Usuario desativado com sucesso!',
            'desativado' => $Disable
        ]);
    }
    public function Enable($id)
    {
        $Enable = $this->user->where('id', $id)->first();

        $Enable->update([
            'status' => 'Enable'
        ]);
        return response()->json([
            'message' => 'Usuario ativado com sucesso!',
            'ativado' => $Enable
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
        ]);
    }
}
