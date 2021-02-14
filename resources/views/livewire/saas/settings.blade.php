<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Update SaaS Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Config .') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('SaaS site name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" />
            <x-jet-input-error for="state.name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="domain" value="{{ __('SaaS site domain') }}" />
            <x-jet-input id="domain" type="text" class="mt-1 block w-full" wire:model.defer="state.domain" />
            <x-jet-input-error for="state.domain" class="mt-2" />
        </div>

        {{-- <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="stripe_pkey" value="{{ __('Stripe public key') }}" />
            <x-jet-input id="stripe_pkey" type="text" class="mt-1 block w-full" wire:model.defer="state.stripe_pkey" />
            <x-jet-input-error for="state.stripe_pkey" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="stripe_skey" value="{{ __('Stripe secret key') }}" />
            <x-jet-input id="stripe_skey" type="text" class="mt-1 block w-full" wire:model.defer="state.stripe_skey" />
            <x-jet-input-error for="state.stripe_skey" class="mt-2" />
        </div> --}}

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="do_token" value="{{ __('DigitalOcean token') }}" />
            <x-jet-input id="do_token" type="text" class="mt-1 block w-full" wire:model.defer="state.do_token" />
            <x-jet-input-error for="state.do_token" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="do_sshkey_pub" value="{{ __('DigitalOcean sshkey') }}" />
            <x-jet-input id="do_sshkey_pub" type="text" class="mt-1 block w-full"
                wire:model.defer="state.do_sshkey_pub" />
            <x-jet-input-error for="state.do_sshkey_pub" class="mt-2" />
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
