<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Check if APP_URL is same as main domain --}}
    {{-- @php
        // Parse APP_URL to get host
        $appUrl = parse_url(env('APP_URL'));
        // Get the current port from the request
        $port = Request::getPort();
        $mainDomain = $appUrl['host'] . ':' . $port;
        // Get current host with port
        $currentHost = Request::getHost() . ':' . $port;
        // dd($currentHost == $mainDomain);
    @endphp --}}

    {{-- @if ($currentHost == $mainDomain) --}}
    @if (Request::getHost() == 'localhost:900')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>subDomain Team Is: </h1>
                        {{ Auth::user()->tenant->subdomain }}
                    </div>
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
