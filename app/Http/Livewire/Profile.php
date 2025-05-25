<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\product;
use App\Models\message;
use File;
use Auth;

class Profile extends Component
{
    public $user_id, $count_all, $status, $user;

    public function delete($id)
    {
        $product = product::where('id', $id)->first();
        if(isset($product)) {
            if($product->user_id == \Auth()->user()->id) {
                //messages
                $messages = message::where('product_id', $product->id)->get();
                foreach($messages as $message) {
                    $buyers[]   = ['id' => $message->buyer];   
                    $roomsId[]  = ['id' => $message->roomId];
                }
                if(count($messages) > 0) {
                    //Removing rooms
                    foreach($buyers as $buyer){
                        $buyer = user::find($buyer["id"]);
                        $accessible_rooms = json_decode($buyer->accessible_rooms, true);
                        if($accessible_rooms != NULL) {
                            foreach($accessible_rooms as $accessible_room) {
                                foreach($roomsId as $roomId) {
                                    if($accessible_room["roomId"] == $roomId) {
                                        unset($accessible_room);
                                    }
                                }
                            }
                            $accessible_rooms = json_encode($accessible_rooms);
                            $buyer->accessible_rooms = $accessible_rooms;
                            $buyer->save();

                        }
                    }
                    $user = user::find(auth()->user()->id);
                    foreach(json_decode($user->accessible_rooms, true) as $accessible_room) {
                        if($accessible_room["roomId"] == $roomId) {
                            unset($accessible_room);
                        }
                    }
                    $accessible_rooms = json_encode($accessible_rooms);
                    $user->accessible_rooms = $accessible_rooms;
                    $user->save();

                    message::where('product_id', $product->id)->delete();
                }

                //Images
                if($product->images != NULL) {
                    $images = json_decode($product->images, true);
                    foreach($images as $image) {
                        if(File::exists(public_path('storage/images/'.$image))){
                            File::delete(public_path('storage/images/'.$image));
                        }else{
                            session()->flash('error', 'The image was not found. '.$image);
                        }
                    }
                }
                $product->delete();
            } else {
                session()->flash('error', 'The user id are invalid.');
            }
        } else {
            session()->flash('error', 'Somethink went wrong, try again later.');
        }
    }

    function setStatus()
    {
        $user = user::find($this->user_id);
        if($user->profile_status == 1) {
            $user->profile_status = 0;
        } else {
            $user->profile_status = 1;
        }
        $user->save();
    }

    public function render()
    {
        $user = user::where('id',$this->user_id)->first();
        $this->user = $user;
        if($user->profile_status == 0) {
            $this->status = true;
        } else {
            $this->status = false;
        }
        $count = product::where('user_id',$this->user_id)->select('id')->get();
        $count_all = $count->count();
        $this->count_all = $count_all;
        $products = product::where('user_id', $this->user_id)
        ->with('category')
        ->simplePaginate(5);
        return view('livewire.profile',[
            'products' => $products
        ]);
    }
}
