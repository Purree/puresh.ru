<div class="d-flex justify-center pt-8 me-1 flex-row">
    @foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale !== $current_locale)
{{--            <span class="ml-2 mr-2 text-gray-700">{{ $available_locale }}</span>--}}
{{--        @else--}}
            <form action="{{ route('localization', $available_locale) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-info underline mx-2 mb-1">
                    <span class="d-none d-lg-block">{{ $available_locale }}</span>
                    <span class="d-lg-none d-block">{{ $locale_name }}</span>
                </button>
            </form>
        @endif
    @endforeach
</div>
