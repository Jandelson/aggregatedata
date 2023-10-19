<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Destination') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-4 hover:py-8">
                    <h1><b>Configure your destination Mysql</b></h1>
                    </div>
                    @if (empty($data))
                        <form name="form" action="{{route('destination-store')}}" method="POST">
                    @else
                        <form name="form" action="{{route('destination-update')}}" method="POST">
                    @endif
                        @csrf
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="host">
                                Host
                            </label>
                            <input class="w-full px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="host" type="text" placeholder"127.0.0.1"
                            value="{{$data->host ?? ''}}">
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="port">
                                Port
                            </label>
                            <input class="px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="port" type="text" value="{{$data->port ?? ''}}">
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="host">
                                DataBase Name
                            </label>
                            <input class="px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="database" type="text"
                            value="{{$data->database ?? ''}}">
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="host">
                                User
                            </label>
                            <input class="px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="user" type="text"
                            value="{{$data->user ?? ''}}">
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="host">
                                Password
                            </label>
                            <input class="px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="password" type="password" placeholder="*************"
                            value="{{$data->password ?? ''}}">
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="host">
                                Table Name
                            </label>
                            <input class="px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="table_name" type="text"
                            value="{{$data->table_name ?? ''}}">
                            <p class="text-xs italic text-red-500">Please provid a exists table name or a name to create new table .</p>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="host">
                                Append or Replace Data?
                            </label>
                            <select class="px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="if_exists">
                                <option value="append"
                                @if ($if_exists == 'append')
                                    selected
                                @endif
                                >Append</option>
                                <option value="replace"
                                @if ($if_exists == 'replace')
                                    selected
                                @endif
                                >Replace</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="host">
                                Enable DataBase Service?
                            </label>
                            <input class="px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="enable" type="checkbox"
                            @if (!empty($data->enable))
                                checked
                            @endif
                            value="1">
                        </div>
                        <div class="py-4 hover:py-8">
                            <button
                            type="submit"
                            class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">
                            @if (empty($data))
                                Create
                            @else
                                Save
                            @endif
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
