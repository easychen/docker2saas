<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Update plan settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Then members can buy it .') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
            <x-jet-input-error for="state.name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="stripe_price_id" value="{{ __('Stripe PriceID') }}" />
            <x-jet-input id="stripe_price_id" type="text" class="mt-1 block w-full" wire:model.defer="state.stripe_price_id" />
            <x-jet-input-error for="state.stripe_price_id" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="do_region" value="{{ __('DigitalOcean Droplet Region') }}" />
            <x-jet-input id="do_region" type="text" class="mt-1 block w-full" wire:model.defer="state.do_region" />
            <x-jet-input-error for="state.do_region" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="do_size" value="{{ __('DigitalOcean Droplet Size') }}" />
            <x-jet-input id="do_size" type="text" class="mt-1 block w-full" wire:model.defer="state.do_size" />
            <x-jet-input-error for="state.do_size" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="do_image" value="{{ __('DigitalOcean Droplet Image') }}" />
            <x-jet-input id="do_image" type="text" class="mt-1 block w-full" wire:model.defer="state.do_image" />
            <x-jet-input-error for="state.do_image" class="mt-2" />
        </div>

        {{-- <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="do_sshkey_pub" value="{{ __('DigitalOcean SSH Public Key') }}" />
            <x-jet-input id="do_sshkey_pub" type="text" class="mt-1 block w-full" wire:model.defer="state.do_sshkey_pub" />
            <x-jet-input-error for="state.do_sshkey_pub" class="mt-2" />
        </div> --}}

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="do_user_data" value="{{ __('DigitalOcean Droplet User Data') }}" />
            <x-jet-input id="do_user_data" type="text" class="mt-1 block w-full" wire:model.defer="state.do_user_data" />
            <x-jet-input-error for="state.do_user_data" class="mt-2" />
        </div>






    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
