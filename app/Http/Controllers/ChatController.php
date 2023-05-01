<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function list(){
        $list = Chat::all();
        return response()->json($list);
    }

    public function create(Request $request){
        $created = Chat::create([
            'message' => $request->input('message'),
            'user_id' => Auth::id(),
            'to_id' => $request->input('to'),
            'status' => 'preparing',
            'status_message' => 'created',
        ]);
        
        return response()->json([
            'message' => 'Criado com Sucesso!',
            $created 
        ]);
    }

    public function update($id, Request $request){
        $updated = Chat::findOrFail($id)->first();
        $updated->update([
            'message' => $request->input('message'),
            'status_message' => 'updated',
        ]);

        return response()->json([
            'message' => 'Atualizado com Sucesso!',
            $updated
        ]);
    }

    public function delete($id){
        $deleted = Chat::findOrFail($id)->first();
        $deleted->delete($deleted);

        return response()->json([
            'message' => 'Deletado com sucesso!',
            $deleted
        ]);
    }
}
