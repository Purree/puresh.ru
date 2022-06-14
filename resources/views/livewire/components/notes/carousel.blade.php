<div>
    @if(!empty(current($note->images)))
        {{--        Get first object element and check is it empty        --}}
        @if($note->images->count() === 1)
            <livewire:components.notes.image-box wire:key="{{ 'image'. $note->images->first()->id }}"
                                                 :image="$note->images->first()"
                                                 :is-editable="$isEditable"
                                                 :is-in-carousel="false"/>
        @else
            <div id="noteImagesCarousel{{ $note->id }}" class="carousel slide" data-bs-interval="false">
                <div class="carousel-indicators">
                    @for($i = 0; $i < $note->images->count(); $i++)
                        <button type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                                data-bs-slide-to="{{ $i }}"
                                class="{{ $i === 0 ? 'active' : '' }}" aria-current="true"
                                aria-label="Slide {{ $i }}"></button>
                    @endfor
                </div>
                <div class="carousel-inner">
                    @foreach($note->images as $image)
                        <livewire:components.notes.image-box wire:key="{{ $loop->index . $image->id  }}"
                                                             :image="$image"
                                                             :is-editable="$isEditable"
                                                             :is-in-carousel="true"
                                                             :is-active="$loop->first"/>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#noteImagesCarousel{{ $note->id }}"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @endif
    @endif
</div>
