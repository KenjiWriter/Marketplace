<x-layout>
    @section('content')
    <fieldset>
        <legend>System by <a href="https://github.com/KenjiWriter">@Wenzzi</a></legend>
        @livewire('chat', ['roomId' => $roomId])
    </fieldset>
    @endsection
</x-layout>