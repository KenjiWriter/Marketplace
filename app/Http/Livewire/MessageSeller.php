<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\message;
use Auth;

class MessageSeller extends Component
{
    public $body, $product_id, $product_seller;

    public function sendMessage()
    {
        $validatedDate = $this->validate([
            'body' => 'required|min:5|max:255',
        ]);
        if($this->product_seller == auth()->user()->id) {
            session()->flash('message', "You can't message to your self.");
        } else {
            $messages = message::where('sender', auth()->user()->id)->first();
            if(isset($messages)) {
                $roomId = $messages["roomId"];
            } else {
                $count = message::count();
                $roomId = $count + 1;
            }
            $send_message = message::create(['roomId' => $roomId, 'product_id' => $this->product_id, 'sender' => auth()->user()->id, 'receiver' => $this->product_seller,'buyer' => auth()->user()->id, 'seller' => $this->product_seller, 'message' => $this->body]);
            if($send_message) {
                session()->flash('message', 'Message successfully sended!');
            } else {
                session()->flash('message', 'Something went wrong! try again later.');
            }
        }
    }


    public function render()
    {
        return view('livewire.message-seller');
    }
}
