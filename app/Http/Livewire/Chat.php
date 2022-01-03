<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\user;
use App\Models\message;
use App\Models\product;

class Chat extends Component
{
    public $roomId, $product, $seller, $buyer, $body;

    public function sendMessage()
    {
        $validatedDate = $this->validate([
            'body' => 'required|min:5|max:255',
        ]);

        if($this->buyer->id == auth()->user()->id) {
            $receiver = $this->seller->id;
        } else {
            $receiver = $this->buyer->id;
        }

        $send_message = message::create(['roomId' => $this->roomId, 'product_id' => $this->product->id, 'sender' => auth()->user()->id, 'receiver' => $receiver,'buyer' => $this->buyer->id, 'seller' => $this->seller->id, 'message' => $this->body]);
        if($send_message) {
            $this->render();
        } else {
            session()->flash('message', 'Something went wront! try again later');
        }
    }
    
    public function render()
    {
        $accessible_rooms = json_decode(auth()->user()->accessible_rooms, true);
        if(count($accessible_rooms) > 0) {
            foreach($accessible_rooms as $accessible_room) {
                if($accessible_room["roomId"] != $this->roomId) {
                    session()->flash('error', '');
                }
            }
        } else {
            session()->flash('error', '');
        }
        $messages = message::where('roomId',$this->roomId)->get();
        if(count($messages) > 0) {
            if($messages[0]->buyer == auth()->user()->id or $messages[0]->seller == auth()->user()->id) {
            } else {
                session()->flash('error', '');
            }
    
            $this->product = product::where('id', $messages[0]->product_id)->select('name','id')->first();
            $this->seller = user::where('id', $messages[0]->seller)->select('name','id')->first();
            $this->buyer = user::where('id', $messages[0]->buyer)->select('name','id')->first();
        } else {
            session()->flash('error', '');
        }

        return view('livewire.chat', [
            'messages' => $messages
        ]);
    }
}
