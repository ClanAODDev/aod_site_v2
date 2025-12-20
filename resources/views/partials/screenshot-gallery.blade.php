@if(!empty($screenshots) && count($screenshots) > 0)
<div class="screenshot-gallery">
    <h2>Screenshots</h2>
    <div class="carousel-container">
        <button class="carousel-nav carousel-prev" aria-label="Previous screenshots">&lsaquo;</button>
        <div class="carousel-viewport">
            <div class="gallery-grid">
                @foreach($screenshots as $index => $screenshot)
                <a href="{{ $screenshot['url'] }}" class="gallery-item" data-lightbox data-index="{{ $index }}" data-caption="{{ $screenshot['caption'] ?? '' }}"><img src="{{ $screenshot['url'] }}" alt="{{ $screenshot['caption'] ?? 'Division screenshot' }}" loading="lazy"></a>
                @endforeach
            </div>
        </div>
        <button class="carousel-nav carousel-next" aria-label="Next screenshots">&rsaquo;</button>
    </div>
    @if(count($screenshots) > 3)
    <div class="carousel-dots"></div>
    @endif
</div>
<div class="lightbox-overlay" id="lightbox-overlay">
    <button class="lightbox-close" aria-label="Close">&times;</button>
    <button class="lightbox-prev" aria-label="Previous">&lsaquo;</button>
    <button class="lightbox-next" aria-label="Next">&rsaquo;</button>
    <div class="lightbox-content">
        <img src="" alt="" id="lightbox-image">
        <div class="lightbox-caption" id="lightbox-caption"></div>
    </div>
    <div class="lightbox-counter" id="lightbox-counter"></div>
</div>
@endif
