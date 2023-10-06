<div class="mx-auto max-w-7xl">
    @if (session('error'))
    <div role="alert">
        <div class="px-6 py-2 font-bold text-white bg-red-500 rounded-t">
            {{ session('error') }}
        </div>
    </div>
    @endif

    @if (session('success'))
        <div role="alert">
            <div class="px-6 py-2 font-bold text-black rounded-t bg-indigo-50">
                {{ session('success') }}
                <br>
                <a href="{{route('download', session('link'))}}">
                    Click here! Download File.
                </a>
            </div>
        </div>
    @endif
</div>