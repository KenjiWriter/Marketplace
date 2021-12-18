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
                dd('NOT WITH ME YOU FOOL :)');
            }
        } else {
            dd('Somethink went wrong');
        }
    }

    public function render()
    {
        $user = user::where('id',$this->user_id)->first();
        $this->user = $user;
        if($user->profile_status == 0) {
            $this->status = false;
            $user->profile_status = 1;
            $user->save();
        } else {
            $this->status = true;
            $user->profile_status = 0;
            $user->save();
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
