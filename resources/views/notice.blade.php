<x-guest-layout>
    <div class="flex items-center justify-center h-screen">

        <div class="text-gray-3000 font-bold p-10">
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <div>
                <x-jet-secondary-button class="mt-2" onclick="history.back(1)">Back</x-jet-secondary-button>
            </div>
        </div>

    </div>
</x-guest-layout>
