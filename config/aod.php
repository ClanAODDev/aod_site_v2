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
            ['name' => 'Nike Club Fleece Pullover Hoodie', 'slug' => 'tiif16wd', 'image_id' => 'ypb6lg43if4zzwdz'],
            ['name' => 'Nike Club Fleece Full-Zip Hoodie', 'slug' => '90qgzsw5', 'image_id' => 'fwt961uj7lgevd6q'],
            ['name' => 'Carhartt Hoodie', 'slug' => 'uz0zlglj', 'image_id' => 'bt2s8kkk6eg2f8jd'],
            ['name' => 'Carhartt 1/4-Zip Sweatshirt', 'slug' => 'rnypwhs6', 'image_id' => 'orl5lxtff317xbwj'],
            ['name' => 'Dual Collar Esports Jersey', 'slug' => 'odvg8pbs', 'image_id' => 'xnq2q4bw6mni0hn1'],
            ['name' => 'Crew Neck Esports Jersey', 'slug' => 'xumadmka', 'image_id' => 'zb6e2uchrwwvkb08'],
            ['name' => 'Men\'s Vanguard Esports Jersey', 'slug' => 'xkmpjwrj', 'image_id' => 'o4hdu3ca1v74i1az'],
            ['name' => 'Women\'s Catalyst Esports Jersey', 'slug' => '5avfjj0r', 'image_id' => 'er07qzh8r9puflvm'],
            ['name' => 'Nike Team rLegend Tee', 'slug' => 'bsbap0bs', 'image_id' => 'ujdiowaibuto367r'],
            ['name' => 'Women\'s Tank Top', 'slug' => 'tjax7emq', 'image_id' => 'ot1ut94ljpwqkfp5'],
            ['name' => 'Nike Polo', 'slug' => 'oakktu0x', 'image_id' => 'zw88py0kses2xo5k'],
            ['name' => 'Sport-Tek Fleece Pants', 'slug' => 'xemw0dre', 'image_id' => 'ms0ougij88dercor'],
            ['name' => 'Port & Company Fleece Jogger', 'slug' => '047mhpfh', 'image_id' => '3xvbjcrbxx3tlqra'],
            ['name' => 'XXL Gaming Mouse Pad', 'slug' => 'wlieyyh0', 'image_id' => 'tkq7j82lgsdhz4q1'],
            ['name' => 'XL Gaming Mouse Pad', 'slug' => 'cab3mp8b', 'image_id' => 'jeiwngkq7gil1527'],
            ['name' => 'Gaming Playmat', 'slug' => '0bfk88ot', 'image_id' => '0ogdte43jdol1zwx'],
            ['name' => 'Sport Towel', 'slug' => 'fvkiemly', 'image_id' => 'wd11nz7p6p2zrogl'],
            ['name' => '15 oz Mug', 'slug' => '3pkex63t', 'image_id' => 'l2hk3sj30vm865uk'],
            ['name' => 'Ceramic Shot Glass', 'slug' => 'e95v3y0n', 'image_id' => 'qrjziofw4f8yfczl'],
        ],
    ],
];
