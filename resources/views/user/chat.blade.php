<x-layout>
    @section('content')
        <fieldset>
            @livewire('chat', ['roomId' => $roomId])
        </fieldset>
    @endsection
</x-layout>
