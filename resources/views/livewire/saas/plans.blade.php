<div class="container mx-auto px-4 sm:px-8">
    <div class="py-4">


        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">

            <div class="mb-8 flex flex-row items-center justify-between">
                <div class="left"></div>
                <div class="right flex-1 text-right">
                    <x-jet-secondary-button wire:click="go('plans.create')">Add a plan</x-jet-secondary-button>
                </div>
            </div>

            <div class="inline-block min-w-full shadow-sm rounded overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-white">
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Plan ID
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Plan Name
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Stripe PriceId
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                DigitalOcean Instance
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Link
                            </th>

                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( ($plans ?? []) as $plan )
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $plan['id'] }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $plan['name'] }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $plan['stripe_price_id'] }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ $plan['do_region']??"-" }}/
                                    {{ $plan['do_size']??"-" }}/
                                    {{ $plan['do_image']??"-" }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <?php if( $plan['enabled'] == 1 ): ?>

                                <span
                                    class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden
                                        class="absolute inset-0 bg-green-200 opacity-50 rounded"></span>
                                    <span wire:click="toggle_enable({{$plan['id']}},0)" class="relative cursor-pointer">Enabled</span>
                                </span>

                                <?php else: ?>

                                <span
                                    class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden
                                        class="absolute inset-0 bg-gray-200 opacity-50 rounded"></span>
                                    <span wire:click="toggle_enable({{$plan['id']}},1)" class="relative cursor-pointer">Disabled</span>
                                </span>

                                <?php endif; ?>


                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-semibold ">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <input class="w-32 truncate bg-gray-200 rounded p-1 px-2 inline-block cursor-pointer copy-{{$plan['id']}}" onclick="copy_it({{$plan['id']}})" value="{{$site_url}} {{$plan['id']}}" />
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"><x-jet-secondary-button wire:click="go('plans.modify','{{$plan['id']}}')">Edit</x-jet-secondary-button>
                                </p>
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function copy_it(id) {
    console.log(id,".copy-"+id);
    window.document.querySelector(".copy-"+id).select();
    document.execCommand('copy');
}
</script>
