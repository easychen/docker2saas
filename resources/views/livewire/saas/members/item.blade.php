<tr>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10">
                <img class="w-full h-full rounded-full"
                    src="<?=Gravatar::get($member['email']);?>"
                    alt="" />

            </div>
            <div class="ml-3">
                <p class="text-gray-900 whitespace-no-wrap">
                    {{ $member['name'] }}
                </p>
            </div>
        </div>
    </td>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap"><a
                href="mailto:{{ $member['email'] }}">{{ $member['email'] }}</a></p>
    </td>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <span
            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
            <span aria-hidden
                class="absolute inset-0 bg-green-200 opacity-50 rounded"></span>
            <span class="relative"><?=$member['id'] == 1 ? 'Admin' : 'User' ?></span>
        </span>
    </td>
    {{-- <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">
            <?=date("m/d/Y H:i", strtotime($member['created_at'])) ?>
        </p>
    </td> --}}
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">
            <?=strlen($member['stripe_id'])>1 ? '<a href="'. $stripe_base . 'customers/'.$member['stripe_id'].'" target="_blank">'.$member['stripe_id'].'</a>' : '-' ?>
        </p>
    </td>

    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">
            <?=strlen($member['stripe_scription_id'])>1 ? '<a href="'. $stripe_base . 'subscriptions/'.$member['stripe_scription_id'].'" target="_blank">'.$member['stripe_scription_id'].'</a>' : '-' ?>
        </p>
    </td>

    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">
            @if(strlen($member['do_instance_id'])>0)
            <div class="mb-4">
                @if( strlen( $member['do_ip'] ) > 0 )

                <a href="http://{{$member['do_ip']}}" target="_blank">{{$member['do_ip']}}</a> <a href="https://cloud.digitalocean.com/droplets/{{$member['do_instance_id']}}" target="_blank">☁</a> <span class="bg-green-600 text-white px-1 rounded">{{$member['do_status']}}</span>
                @else
                <a href="https://cloud.digitalocean.com/droplets/{{$member['do_instance_id']}}" target="_blank">{{$member['do_instance_id']}}</a>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <div>
                <x-jet-secondary-button wire:click="refresh_instance('{{$member['id']}}','{{$member['do_instance_id']}}')" title="refresh">🔎</x-jet-secondary-button>
                <x-jet-secondary-button wire:click="restart_instance('{{$member['id']}}','{{$member['do_instance_id']}}')" title="restart">🔃</x-jet-secondary-button>
                <x-jet-secondary-button wire:click="remove_instance('{{$member['id']}}','{{$member['do_instance_id']}}')" title="remove">🚫</x-jet-secondary-button>
            </div>
            @else
            <x-jet-secondary-button wire:click="create_instance('{{$member['id']}}','{{$member['stripe_price_id']}}')">+</x-jet-secondary-button>
            @endif


        </p>
    </td>


</tr>
