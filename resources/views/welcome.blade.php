<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Take Screenshot</title>
    @toastr_css
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="container mx-auto px-4 py-8 bg-blue-800">
    <div class="w-full text-center">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="url">
                    <span class="text-sm"></span>Target URL
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-center @error('url') border-red-500 mb-2 @enderror"
                    id="url" name="url" type="text" value="{{ old('url') }}" placeholder="example.com">
                @error('url')<p class="text-red-500 text-xs italic">{{ $errors->first('url') }}</p>@enderror
            </div>
            <div class="items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Take Screenshot!
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-3">
        @foreach($screenshots as $screenshot)
            <div class="m-5">
                <a target="_blank" href="/img/{{ $screenshot->name }}"><img src="{{ asset('img/'.$screenshot->name) }}"
                                                                            title="Screenshot {{ ++$loop->remaining }}"></a>
                <div class="text-center"><p class="text-sm text-white inline-block">
                        Screenshot {{ $loop->remaining }}</p></div>
            </div>
        @endforeach
    </div>
</div>
@jquery
@toastr_js
@toastr_render
</body>
</html>
