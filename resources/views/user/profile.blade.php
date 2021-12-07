<x-layout>
    @section('content')
        @livewire('profile', ['user_id' => $id])
    @endsection
</x-layout>