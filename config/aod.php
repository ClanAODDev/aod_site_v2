<?php

return [

    'intro_video_id' => env('INTRO_VIDEO_ID', '7u848gKuFgE'),
    'hero_video_id' => env('HERO_VIDEO_ID', 'fEVGn3eRABI'),
    'foundations_era_video_id' => env('HISTORY_FOUNDATIONS_ERA_VIDEO_ID', 'KN6yvG9aJsg'),
    'modern_era_video_id' => env('HISTORY_MODERN_ERA_VIDEO_ID', 'XHgfL_Av_r4'),

    /**
     * Highlighted Events
     *
     * Icons: https://fontawesome.com/search?o=r&m=free
     * Video types: youtube, twitch
     *
     * Themes:
     *   - holiday: Red/maroon gradient with diagonal stripes
     *   - default: Dark neutral gradient
     *   - esports: Dark blue/purple gradient
     *   - community: Dark green gradient
     */
    'highlighted_events' => [
        [
            'id' => 'christmas-2025',
            'show_snowflakes' => true,
            'enabled' => true,
            'start_date' => '12-01',
            'end_date' => '01-05',
            'theme' => 'holiday',
            'badge' => [
                'icon' => 'fas fa-snowflake',
                'text' => 'Holiday Special',
            ],
            'title' => 'ClanAOD <strong>Christmas Podcast</strong> 2025',
            'description' => 'Celebrate the season with the Angels of Death! Join us for our annual holiday podcast featuring community stories, gaming highlights, and festive fun.',
            'video' => [
                'type' => 'youtube',
                'id' => 'cdVZmCGgTxs',
                'title' => 'AOD Christmas Podcast 2025',
            ],
            /* 'cta' => [
                'text' => 'Learn More',
                'url' => 'https://',
                'icon' => 'fas fa-arrow-right',
            ],*/
        ],
    ],

    'merch' => [
        'store_url' => 'https://exclaim.gg/store/AODMerch',
        'image_base_url' => 'https://exclaim.gg/design-preview/',
        'image_suffix' => '.ps-front.pw-384.webp',
        'items' => [
            ['name' => 'Christmas Hoodie', 'slug' => 'b44boc0u', 'image_id' => 'culkvl4p4pil6j9l'],
            ['name' => 'Nike Club Fleece Hoodie', 'slug' => 'tiif16wd', 'image_id' => 'ypb6lg43if4zzwdz'],
            ['name' => 'Dual Collar Esports Jersey', 'slug' => 'odvg8pbs', 'image_id' => 'xnq2q4bw6mni0hn1'],
            ['name' => 'Dual Collar Esports Jersey (Alt)', 'slug' => 's9und22x', 'image_id' => 'fpcr04vr4lg4ek5y'],
            ['name' => 'XXL Gaming Mouse Pad', 'slug' => 'wlieyyh0', 'image_id' => 'tkq7j82lgsdhz4q1'],
            ['name' => 'XXL Gaming Mouse Pad (Alt)', 'slug' => 'bksx4de2', 'image_id' => 'qbjluqks1r1peumh'],
            ['name' => '15 oz Mug', 'slug' => '3pkex63t', 'image_id' => 'l2hk3sj30vm865uk'],
            ['name' => 'Carhartt Hoodie', 'slug' => 'uz0zlglj', 'image_id' => 'bt2s8kkk6eg2f8jd'],
            ['name' => 'Hockey Jersey', 'slug' => 'y2mwcg4d', 'image_id' => '3h9f1xt3x1sobwy5'],
            ['name' => 'Polyester Fleece Hoodie', 'slug' => 'ir00du3x', 'image_id' => 'c8rkaej53pv7oi21'],
            ['name' => 'Football Fan Jersey', 'slug' => 'wz4tuazy', 'image_id' => 'ixb16pzif8o3espf'],
            ['name' => 'Crew Neck Esports Jersey', 'slug' => 'xumadmka', 'image_id' => 'zb6e2uchrwwvkb08'],
            ['name' => 'Crew Neck Esports Jersey (Alt)', 'slug' => 'llqjhfld', 'image_id' => 's8wx13ady633hwmo'],
            ['name' => 'Women\'s Tank Top', 'slug' => 'tjax7emq', 'image_id' => 'ot1ut94ljpwqkfp5'],
            ['name' => 'Nike Polo', 'slug' => 'oakktu0x', 'image_id' => 'zw88py0kses2xo5k'],
            ['name' => 'Carhartt 1/4-Zip Sweatshirt', 'slug' => 'rnypwhs6', 'image_id' => 'orl5lxtff317xbwj'],
            ['name' => 'Carhartt 1/4-Zip Sweatshirt (Alt)', 'slug' => '28jsgngv', 'image_id' => '26g27ofq4c4cyxtj'],
            ['name' => 'Ceramic Shot Glass', 'slug' => 'e95v3y0n', 'image_id' => 'qrjziofw4f8yfczl'],
            ['name' => 'Sport-Tek Fleece Pants', 'slug' => 'xemw0dre', 'image_id' => 'ms0ougij88dercor'],
            ['name' => 'Cotton Joggers', 'slug' => 'l9oigwcp', 'image_id' => '21skuuelsbdrfjj2'],
            ['name' => 'Sublimated Shorts', 'slug' => 'g0tj1igm', 'image_id' => 'soyq5u0r0w3z2m3i'],
            ['name' => 'XL Gaming Mouse Pad', 'slug' => 'cab3mp8b', 'image_id' => 'jeiwngkq7gil1527'],
            ['name' => 'Female Esports Jersey', 'slug' => 'm28o26vq', 'image_id' => 'rjo5cwim0bwzalrz'],
        ],
    ],
];
