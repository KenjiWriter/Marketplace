<div>
    <div>
        <h3>Add new images: </h3>
        <input type="file" id="file" wire:model="photos" multiple>
    </div>
    <h3>Images: </h3>
    @if (session()->has('error'))
        <div align="center">
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div align="center">
            {{ session('success') }}
        </div>
    @endif
    @if (isset($images))
        @foreach ($images as $key => $image)
            <div style="display: inline-block" align="center">
                <img style="width: 100px; height=50px;" src="{{ asset('storage/images/'.$image) }}" alt="{{ $image }}"> <br>
                <button wire:click="remove({{ $key }})">REMOVE</button>
            </div>
        @endforeach
    @endif
</div>
