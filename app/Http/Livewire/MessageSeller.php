<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\message;
use App\Models\user;
use Auth;

class MessageSeller extends Component
{
    public $body, $product_id, $product_seller;
    public $existingRoomId = null;

    public function mount()
    {
        // Check if there's an existing conversation for this product
        if (Auth::check()) {
            $existingMessage = message::where('product_id', $this->product_id)
                ->where(function ($query) {
                    $query->where('buyer', auth()->user()->id)
                        ->orWhere('seller', auth()->user()->id);
                })
                ->first();

            if ($existingMessage) {
                $this->existingRoomId = $existingMessage->roomId;
            }
        }
    }

    public function sendMessage()
    {
        $validatedDate = $this->validate([
            'body' => 'required|min:5|max:255',
        ]);

        if ($this->product_seller == auth()->user()->id) {
            session()->flash('message', "You can't message to your self.");
            return;
        }

        $messages = message::where('sender', auth()->user()->id)->first();
        if ($messages != NULL) {
            $roomId = $messages["roomId"];
        } else {
            $count = message::count();
            $roomId = $count + 1;
        }

        //Update buyer rooms
        $buyer = user::find(auth()->user()->id);
        $accessible_rooms_buyer = json_decode($buyer->accessible_rooms, true);
        if (!$accessible_rooms_buyer) {
            $accessible_rooms_buyer[] = ['roomId' => $roomId];
            $buyer->accessible_rooms = json_encode($accessible_rooms_buyer);
        } else {
            foreach ($accessible_rooms_buyer as $accessible_room_buyer) {
                if ($accessible_room_buyer == $roomId) {
                    break;
                } else {
                    $accessible_rooms_buyer[] = ['roomId' => $roomId];
                    $buyer->accessible_rooms = json_encode($accessible_rooms_buyer);
                }
            }
        }

        //Update seller rooms
        $seller = user::find($this->product_seller);
        $accessible_rooms_seller = json_decode($seller->accessible_rooms, true);
        if (!$accessible_rooms_seller) {
            $accessible_rooms_seller[] = ['roomId' => $roomId];
            $seller->accessible_rooms = json_encode($accessible_rooms_seller);
        } else {
            foreach ($accessible_rooms_seller as $accessible_room_seller) {
                if ($accessible_room_seller == $roomId) {
                    break;
                } else {
                    $accessible_rooms_seller[] = ['roomId' => $roomId];
                    $seller->accessible_rooms = json_encode($accessible_rooms_seller);
                }
            }
        }

        $send_message = message::create([
            'roomId' => $roomId,
            'product_id' => $this->product_id,
            'sender' => auth()->user()->id,
            'receiver' => $this->product_seller,
            'buyer' => auth()->user()->id,
            'seller' => $this->product_seller,
            'message' => $this->body
        ]);

        if ($send_message) {
            $buyer->save();
            $seller->save();

            // Redirect to the chat after sending the first message
            return redirect()->route('chat', $roomId);
        } else {
            session()->flash('message', 'Something went wrong! Try again later.');
        }
    }

    public function render()
    {
        return view('livewire.message-seller');
    }
}
