<section class="primary-footer with-shadow">
    <div class="section-content-container">
        <div class="section-blurb">
            <div class="logo">
                @include('partials.aod-logo')
            </div>
            <div class="blurb-text">
                <h1>About The Angels of Death</h1>
                <p>The Angels of Death is a community of players founded in 1999 based on a core set of conduct that
                    aims to promote decency and provide a comfortable environment to play with thousands of other
                    likeminded members.</p>
                <p>With nearly 3000 members globally there is always someone to play alongside when you want.</p>
            </div>
        </div>
    </div>

    <div class="section-content-container">
        @include('partials.announcements')
        @include('partials.sitemap')
        @include('partials.tweets')

        <div class="site-meta footer-section full-width centered">
            <ul>
                <li>Copyright &copy; <?php echo "1999 - " . date('Y'); ?> Angels of Death. All rights reserved.</li>
                <li><a href="https://www.clanaod.net/privacy-policy/">Privacy Policy</a></li>
                <li>-</li>
                <li><a href="https://www.clanaod.net/terms-of-use/">Terms of Use</a></li>
            </ul>
        </div>
    </div>
</section>
