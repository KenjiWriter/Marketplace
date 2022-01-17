<div>
    {{-- <fieldset>
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
        </select> <br>
        <input type="number" wire:model="price" placeholder="Price"> <br> <br>
        <label for="file">Upload photos: </label>
        <input type="file" id="file" wire:model="photos" multiple>
        @error('photo') <span style="color: red;">{{ $message }}</span> @enderror
        <div wire:loading wire:target="photo">Uploading...</div>
        <br><br>
        <button wire:click.prevent="add">Add announcement</button>
    </fieldset> --}}
    <div class="container border border-dark">
        <div class="col-lg-4 col-lg-offset-4 form-row">
            <h3>Add new announcement</h3>
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="form-group">
                <label for="name">Title:</label>
                <input class="form-control" type="text" wire:model="name" id="name" placeholder="Title">
                @error('name') <span style="color: red;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="desc">Description: </label>
                <textarea class="form-control" id="desc" cols="30" rows="5" wire:model="description"></textarea>
                @error('description') <span style="color: red;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="Owner">I'm a first owner: </label> <input id="Owner" class="checkbox" type="checkbox" wire:model="first_owner">
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" wire:model="category">
                    <option value="0">Select category</option>
                    <option value="1">Phones</option>
                    <option value="2">Tablets</option>
                    <option value="3">Computers</option>
                    <option value="4">Other</option>
                </select>
                @error('category') <span style="color: red;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="price">Price: </label>
                <input type="number" id="price" class="form-control" wire:model="price" placeholder="Price">
            </div>
            <div class="form-group">
                <label for="file">Upload photos: </label>
                <input type="file" class="form-control" id="file" wire:model="photos" multiple>
                @error('photo') <span style="color: red;">{{ $message }}</span> @enderror
                <div wire:loading wire:target="photo">Uploading...</div>
            </div>
            <button wire:click.prevent="add" class="form-control btn btn-success">Add announcement</button>
        </div>
    </div>
</div>
