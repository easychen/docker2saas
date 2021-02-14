<x-jet-form-section submit="delete" class="mt-8">
    <x-slot name="title">
        {{ __('Delete the plan ') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Cannot revocerd .') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">

            <x-jet-label for="retype_name" value="{{ __('Confrim Plan Name') }}" />
            <x-jet-input id="retype_name" type="text" class="mt-1 block w-full" wire:model.defer="state.retype_name" />
            <x-jet-input-error for="state.retype_name" class="mt-2" />
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success mt-2">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="delete">
            {{ __('Deleted.') }}
        </x-jet-action-message>

        <x-jet-button class="bg-red-800">
            {{ __('Delete') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
