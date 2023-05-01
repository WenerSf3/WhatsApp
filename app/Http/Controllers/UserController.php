<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller implements JWT
{
    public function AllUsers()
    {
        $AllUsers = User::all();
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
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $hash = hash('sha256', 'criptografiagdigital2023x' . $request->input('password'));

        $create = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $hash,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Usuario criado com sucesso!',
            'Criado' => $create
        ]);;
    }

    public function Update(Request $request, $id)
    {
        $update = User::where('id', $id)->first();

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

    public function Delete($id)
    {
        $delete = User::findOrFail($id)->first();
        $delete->delete($id);

        return response()->json([
            'message' => 'Usuario deletado com sucesso!',
            'deletado' => $delete
        ]);
    }
    public function Disable($id)
    {
        $Disable = User::where('id', $id)->first();
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
        $Enable = User::where('id', $id)->first();

        $Enable->update([
            'status' => 'Enable'
        ]);
        return response()->json([
            'message' => 'Usuario ativado com sucesso!',
            'ativado' => $Enable
        ]);
    }
}
