<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscribe confirm') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            <div class="m-10">
                <div class="flex flex-col bg-white rounded-xl p-20 shadow  text-center">
                    <div class="first mb-6">Subscribe the plan ( {{$plan['name']}} ) ? </div>
                    <div class="second">{{ $checkout->button('click to continue ') }}</div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
