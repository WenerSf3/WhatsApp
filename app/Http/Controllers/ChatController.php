<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;

class ChatController extends Controller
{
    protected $chat;

    public function __construct(){
        
        $this->chat = New Chat;
    }

    public function list(){
        $list = $this->chat->all();
        return response()->json($list);
    }

    public function create(Request $request){
        $created = $this->chat->create([
            'message' => $request->input('message'),
            'user_id' => Auth::id(),
            'to_id' => $request->input('to'),
            'status' => 'preparing',
            'status_message' => 'created',
        ]);
        
        return $this->chat->all();

    }

    public function update($id, Request $request){
        $updated = $this->chat->findOrFail($id)->first();
        $updated->update([
            'message' => $request->input('message'),
            'status_message' => 'updated',
        ]);

        return $this->chat->all();
    }

    public function delete($id){
        $deleted = $this->chat->findOrFail($id)->first();
        $deleted->delete($deleted);

        return response()->json([
            'message' => 'Deletado com sucesso!',
            $deleted
        ]);
    }
}
