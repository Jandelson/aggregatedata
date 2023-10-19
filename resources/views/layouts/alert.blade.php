<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
    @if (session('status'))
        <div role="alert">
            <div class="px-6 py-2 font-bold text-black rounded-t bg-indigo-50">
                {!! session('status') !!}
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div role="alert">
            <div class="px-6 py-2 font-bold text-white bg-red-500 rounded-t">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

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
                {!! session('success') !!}
                <br>
                <a href="{{route('download', session('link'))}}">
                    Click here! Download File.
                </a>
            </div>
        </div>
    @endif
</div>