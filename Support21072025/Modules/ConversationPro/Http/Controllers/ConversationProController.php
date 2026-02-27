<?php

namespace Modules\ConversationPro\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\ConversationPro\Models\ConversationPro;
use Illuminate\Http\Request;
use App\Conversation;
use App\Http\Controllers\ConversationsController as BaseConversationsController;// Importation correcte

class ConversationProController extends BaseConversationsController{ 

    public function update(Request $request, $id)
    {
        // Logique pour mettre à jour la conversation
        $validatedData = $request->validate([
            'id_projet' => 'required|exists:projet,id', // Assurez-vous que le projet existe
        ]);

        $conversation = Conversation::findOrFail($id);
        $conversation->id_projet = $validatedData['id_projet'];
        $conversation->save();

        return back()->with('success', 'Le projet a été associé à la conversation.');
    }
    

}
