<x-layout>
    @section('content')
        @livewire('show-posts', ['user_id' => $id])
    @endsection
</x-layout>