<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message; // Upewnij się, że model Message jest zaimportowany
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    // Metoda wyświetlająca czat z użytkownikiem
    public function show($id)
    {
        $user = User::findOrFail($id); // Pobierz użytkownika po ID
        return view('chat', compact('user')); // Przekaż użytkownika do widoku czatu
    }

    // Metoda do zapisywania wiadomości (grupowe)
    public function saveMessage(Request $request)
    {
        $request->validate([
            'msg' => 'required|string|max:255', // Walidacja wiadomości
        ]);

        $userId = Auth::id(); // Identyfikator zalogowanego użytkownika
        $message = $request->input('msg');

        DB::table('group_messages')->insert([
            'unique_id' => $userId,
            'message' => $message,
            'timestamp' => now()
        ]);

        return response()->json(['status' => 'success', 'message' => 'Wiadomość została zapisana.']);
    }

    // Metoda do pobierania wiadomości (grupowe)
    public function getMessages()
    {
        try {
            $messages = DB::table('group_messages')
                ->join('users', 'group_messages.unique_id', '=', 'users.id')
                ->select(DB::raw("CONCAT(users.fname, ' ', users.lname) as user"), 'group_messages.message', 'group_messages.timestamp')
                ->orderBy('group_messages.timestamp', 'desc')
                ->get();

            if ($messages->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Brak wiadomości']);
            }

            return response()->json(['status' => 'success', 'messages' => $messages]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // Metoda do zapisywania wiadomości prywatnych
    public function savePrivateMessage(Request $request)
    {
        $request->validate([
            'msg' => 'required|string|max:255',
            'incoming_msg_id' => 'required|integer|exists:users,id', // Walidacja ID odbiorcy
        ]);

        $message = new Message();
        $message->incoming_msg_id = $request->input('incoming_msg_id');
        $message->outgoing_msg_id = Auth::id(); // ID aktualnie zalogowanego użytkownika
        $message->msg = $request->input('msg');
        $message->save();

        return response()->json(['status' => 'success', 'message' => 'Wiadomość została zapisana.']);
    }

    // Metoda do pobierania wiadomości prywatnych
    public function getPrivateMessages($userId)
    {
        try {
            $messages = DB::table('messages')
                ->where(function ($query) use ($userId) {
                    $query->where('incoming_msg_id', Auth::id())
                        ->where('outgoing_msg_id', $userId);
                })
                ->orWhere(function ($query) use ($userId) {
                    $query->where('incoming_msg_id', $userId)
                        ->where('outgoing_msg_id', Auth::id());
                })
                ->join('users', 'messages.outgoing_msg_id', '=', 'users.id')
                ->select('messages.*', 'users.fname', 'users.lname')
                ->orderBy('messages.created_at', 'asc')
                ->get();

            if ($messages->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Brak wiadomości']);
            }

            return response()->json(['status' => 'success', 'messages' => $messages]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
