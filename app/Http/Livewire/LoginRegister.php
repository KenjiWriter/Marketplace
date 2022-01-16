<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Hash;
use App\Models\User;

class LoginRegister extends Component
{
    public $users, $email, $password, $password_confirmation, $name, $remember;
    public $registerForm = false;
    public $num1, $num2, $result, $user_result;

    public function render()
    {
        return view('livewire.login-register');
    }

    private function secureQuestion()
    {
        $this->num1 = rand(1,10);
        $this->num2 = rand(1,10);
        $this->result = $this->num1 + $this->num2;
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function login()
    {
        if($this->remember == 1) {
            $remember = true;
        } else {
            $remember = false;
        }
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (\Auth::attempt(['email' => $this->email, 'password' => $this->password], $remember)) {
                session()->flash('message', "You are Login successful.");
                return redirect('/');
        }else{
            session()->flash('error', 'email or password are wrong.');
        }
    }

    public function register()
    {
        $this->secureQuestion();
        $this->registerForm = !$this->registerForm;
    }

    public function registerStore()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'user_result' => 'required|numeric',
        ]);

        if($this->user_result == $this->result) {
            $this->password = Hash::make($this->password); 

            User::create(['name' => $this->name, 'email' => $this->email,'password' => $this->password]);
    
            session()->flash('message', 'Your register successfully Go to the login page.');
    
            $this->resetInputFields();
            $this->secureQuestion();
        } else {
            session()->flash('error', 'Result of secure question are wrong, try again.');
            $this->secureQuestion();
        }

    }
}
