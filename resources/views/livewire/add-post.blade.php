<div>
    <fieldset>
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        <legend>Add new announcement</legend>
        <input type="text" wire:model="name" placeholder="name"><br>
        <label for="owner">I'm a first owner: </label> <input id="Owner" type="checkbox" wire:model="first_owner"><br>
        Category: 
        <select wire:model="category"> <br>
            <option value="0">Select category</option>
            <option value="1">Phones</option>
            <option value="2">Tablets</option>
            <option value="3">Computers</option>
            <option value="4">Other</option>
        </select> <br> <br>
        <input type="number" wire:model="price" placeholder="Price"> <br> <br>
        <button wire:click.prevent="add">Add announcement</button>
    </fieldset>
</div>
