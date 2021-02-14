<div class="container mx-auto px-4 sm:px-8">
    <div class="py-4">


        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow-sm rounded overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-white">
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Droplet ID
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Name
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Region
                            </th>
                            {{-- <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Created at
                            </th> --}}
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Size
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                IP
                            </th>
                            <th
                                class="px-5 py-3 border-b border-gray-200  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( ($droplets ?? []) as $droplet )
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"><a href="https://cloud.digitalocean.com/droplets/{{$droplet->id}}" target="_blank">{{$droplet->id}}</a></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"><a href="https://cloud.digitalocean.com/droplets/{{$droplet->id}}" target="_blank">{{ $droplet->name }}</a>
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $droplet->region->name }}
                                </p>
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $droplet->sizeSlug }}
                                </p>
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ droplet_ip($droplet) }}
                                </p>
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">

                                    <span
                                    class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden
                                        class="absolute inset-0 bg-green-200 opacity-50 rounded"></span>
                                    <span class="relative cursor-pointer">{{ $droplet->status }}</span>
                                    </span>


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
