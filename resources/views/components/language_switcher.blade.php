<div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
    @foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale !== $current_locale)
{{--            <span class="ml-2 mr-2 text-gray-700">{{ $available_locale }}</span>--}}
{{--        @else--}}
            <form action="{{ route('localization', $available_locale) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-info ml-1 underline ml-2 mr-2">
                    <span>{{ $available_locale }}</span>
                </button>
            </form>
        @endif
    @endforeach
</div>
