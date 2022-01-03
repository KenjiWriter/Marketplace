<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\message;
use App\Models\user;
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
                $buyer = user::find(auth()->user()->id);
                $accessible_rooms_buyer = json_decode($buyer->accessible_rooms, true);
                $accessible_rooms_buyer[] = ['roomId' => $roomId];
                $buyer->accessible_rooms = json_encode($accessible_rooms_buyer);

                $seller = user::find($this->product_seller);
                $accessible_rooms_seller = json_decode($seller->accessible_rooms, true);
                $accessible_rooms_seller[] = ['roomId' => $roomId];
                $seller->accessible_rooms = json_encode($accessible_rooms_seller);
            }
            $send_message = message::create(['roomId' => $roomId, 'product_id' => $this->product_id, 'sender' => auth()->user()->id, 'receiver' => $this->product_seller,'buyer' => auth()->user()->id, 'seller' => $this->product_seller, 'message' => $this->body]);
            if($send_message) {
                $buyer->save();
                $seller->save();
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
