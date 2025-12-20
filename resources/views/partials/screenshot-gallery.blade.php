@if(!empty($screenshots) && count($screenshots) > 0)
<div class="screenshot-gallery">
    <h2>Screenshots</h2>
    <div class="gallery-grid">
        @foreach($screenshots as $index => $screenshot)
        <a href="{{ $screenshot['url'] }}" class="gallery-item" data-lightbox data-index="{{ $index }}" data-caption="{{ $screenshot['caption'] ?? '' }}"><img src="{{ $screenshot['url'] }}" alt="{{ $screenshot['caption'] ?? 'Division screenshot' }}" loading="lazy"></a>
        @endforeach
    </div>
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
