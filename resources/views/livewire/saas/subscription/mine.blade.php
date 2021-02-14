<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
        <div class="m-10">
            <div class="flex flex-col bg-white rounded-xl p-20 shadow text-center">
                <div class="first mb-6">
                    @if($sub??false && $plan??false)
                        <div>{{ $plan['name'] }} / <?=($sub['plan']['amount']/100)?> {{$sub['plan']['currency']}}
                            <span class="bg-blue-300 text-white rounded px-2 ml-2">{{$sub['status']}}</span></div>

                        @if(strlen($user['do_ip'])>0)
                        <div class="mt-4">
                            <a href="http://{{$user['do_ip']}}" target="_blank">{{$user['do_ip']}}</a> <span class="bg-blue-300 text-white rounded px-2 ml-2">{{$user['do_status']}}</span>
                        </div>
                        @endif
                    @else
                        No subscription yet
                    @endif</div>
                    @if( $sub??false )
                    <div class="second"><x-jet-secondary-button wire:click="go()">Manage</x-jet-secondary-button></div>
                    @endif
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {

        window.setTimeout( ()=>{ @this.refresh() } , 100 );
        window.setInterval( ()=>{ @this.refresh() } , 1000*60 );
    })
</script>

