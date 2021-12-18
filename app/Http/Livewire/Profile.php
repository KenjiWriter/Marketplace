<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\product;

class Profile extends Component
{
    public $user_id, $count_all, $status, $user;

    public function delete($id)
    {
        $product = product::where('id', $id)->first();
        if(isset($product)) {
            if($product->user_id == \Auth()->user()->id) {
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
        $products = product::where('user_id',$this->user_id)->simplePaginate(5);
        return view('livewire.profile',[
            'products' => $products
        ]);
    }
}
