<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Sheets Agregate') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-4 hover:py-8">
                    <h1><b>Agregate your sheets</b></h1>
                    </div>
                    <form id="form" action="{{route('upload-sheets')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <label for="files">Select files</label>
                            <input id="files" type="file" name="files[]" multiple />
                        </div>
                        <div class="py-4 hover:py-8">
                            <button
                            type="submit"
                            class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">
                            Start Agregate
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
