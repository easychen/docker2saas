<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plans') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('saas.plans.modify')
            <x-jet-section-border />
            @livewire('saas.plans.delete')

        </div>
    </div>
</x-app-layout>
