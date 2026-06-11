<?php
/**
 * Footer snippet for Meyrin CTT Kirby Theme
 * 
 * This snippet contains the footer and closing HTML tags.
 * Reused across all templates.
 */
$contactPage = page('contact');
$footerEmail = $contactPage ? $contactPage->contact_email() : null;
$footerCoordinates = $contactPage ? $contactPage->coordinates() : null;
?>
    </main>

    <footer class="site-footer py-16 bg-primary text-white mt-16">
        <div class="max-w-[1200px] mx-auto px-4">
            <!-- Sponsors Section -->
            <?php if ($site->sponsors_list()->isNotEmpty()): ?>
            <div class="mb-12 pb-8 border-b border-white/20">
                <h4 class="mb-6 text-primary-light font-extrabold uppercase text-center"><?= $site->sponsors_title()->or('Nos Partenaires')->esc() ?></h4>
                <div class="flex flex-wrap justify-center items-stretch gap-6">
                    <?php foreach ($site->sponsors_list()->toStructure() as $sponsor): ?>
                        <?php if ($sponsor->logo()->toFile()): ?>
                        <a href="<?= $sponsor->url()->esc() ?>" target="_blank" rel="noopener" class="w-32 bg-white rounded-lg p-4 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl flex flex-col items-center justify-between max-w-[180px]" title="<?= $sponsor->name()->esc() ?>">
                            <div class="flex items-center justify-center mb-3 flex-1">
                                <?php $sponsorLogo = $sponsor->logo()->toFile(); ?>
                                <?php if ($sponsorLogo): ?>
                                <picture>
                                    <source srcset="<?= $sponsorLogo->srcset([150, 300, 450]) ?>" type="image/webp">
                                    <img 
                                        src="<?= $sponsorLogo->resize(150, 80)->url() ?>" 
                                        alt="<?= $sponsor->name()->esc() ?>" 
                                        class="max-h-16 w-auto object-contain"
                                        width="150"
                                        height="80"
                                        loading="lazy"
                                    >
                                </picture>
                                <?php endif ?>
                            </div>
                            <div class="text-center text-sm font-bold text-primary leading-tight">
                                <?= $sponsor->name()->esc() ?>
                            </div>
                        </a>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
            <?php endif ?>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="mb-4 text-primary-light font-extrabold uppercase"><?= $site->title()->esc() ?></h4>
                    <p>Club de Tennis de Table</p>
                    <?php if ($footerCoordinates && $footerCoordinates->isNotEmpty()): ?>
                        <?= $footerCoordinates->kt() ?>
                    <?php else: ?>
                        <p>1217 Meyrin</p>
                    <?php endif ?>
                </div>
                <div>
                    <h4 class="mb-4 text-primary-light font-extrabold uppercase">Liens</h4>
                    <ul class="list-none space-y-2">
                        <?php foreach ($site->children()->listed() as $p): ?>
                        <li>
                            <a href="<?= $p->url() ?>" class="hover:text-primary-light transition-colors">
                                <?= $p->title()->esc() ?>
                            </a>
                        </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 text-primary-light font-extrabold uppercase">Contact</h4>
                    <?php if ($footerEmail && $footerEmail->isNotEmpty()): ?>
                        <p class="mb-4"><?= $footerEmail->esc() ?></p>
                    <?php else: ?>
                        <p class="mb-4">info@meyrinctt.ch</p>
                    <?php endif ?>
                    
                    <?php if ($site->social_links()->isNotEmpty()): ?>
                    <div class="space-y-3">
                        <?php foreach ($site->social_links()->toStructure() as $social): ?>
                        <a href="<?= $social->url()->esc() ?>" target="_blank" rel="noopener" class="flex items-center gap-3 hover:text-primary-light transition-colors group">
                            <?php 
                            $platform = $social->platform()->value();
                            if ($platform === 'facebook'): 
                            ?>
                            <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                            <?php elseif ($platform === 'instagram'): ?>
                            <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                            </svg>
                            <?php elseif ($platform === 'twitter'): ?>
                            <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <?php elseif ($platform === 'youtube'): ?>
                            <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            <?php elseif ($platform === 'linkedin'): ?>
                            <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <?php endif ?>
                            <span class="group-hover:underline">
                                <?php if ($social->account()->isNotEmpty()): ?>
                                    <?= $social->account()->esc() ?>
                                <?php else: ?>
                                    <?= ucfirst($platform) ?>
                                <?php endif ?>
                            </span>
                        </a>
                        <?php endforeach ?>
                    </div>
                    <?php endif ?>
                </div>
            </div>
            
            <?php if ($site->copyright()->isNotEmpty()): ?>
            <div class="mt-8 pt-8 border-t border-white/20 text-center text-sm opacity-80">
                <?= $site->copyright()->esc() ?>
            </div>
            <?php endif ?>
        </div>
    </footer>

    <script src="<?= url('assets/js/index.js') ?>" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Announcement Banner Logic
            const banner = document.getElementById('announcement-banner');
            const closeBannerBtn = document.getElementById('close-banner');

            if (banner && closeBannerBtn) {
                const announcementId = banner.dataset.announcementId;
                const dismissedAnnouncementId = sessionStorage.getItem('announcementDismissedId');
                sessionStorage.removeItem('bannerDismissed');

                if (announcementId && dismissedAnnouncementId === announcementId) {
                    banner.classList.add('hidden');
                }

                closeBannerBtn.addEventListener('click', () => {
                    banner.classList.add('hidden');
                    if (announcementId) {
                        sessionStorage.setItem('announcementDismissedId', announcementId);
                    }
                });
            }

            // Club Carousel Initialization
            const clubCarousel = document.querySelector('.club-carousel');
            if (clubCarousel && typeof Swiper !== 'undefined') {
                <?php if ($page->intendedTemplate() == 'club'): ?>
                const autoplayEnabled = <?= $page->carousel_autoplay()->toBool() ? 'true' : 'false' ?>;
                const autoplayDelay = <?= $page->carousel_delay()->or(5000)->toInt() ?>;
                <?php else: ?>
                const autoplayEnabled = true;
                const autoplayDelay = 5000;
                <?php endif ?>

                new Swiper('.club-carousel', {
                    loop: true,
                    autoplay: autoplayEnabled ? {
                        delay: autoplayDelay,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    } : false,
                    speed: 800,
                    effect: 'slide',
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    keyboard: {
                        enabled: true,
                        onlyInViewport: true,
                    },
                    a11y: {
                        enabled: true,
                    },
                });
            }

        });
    </script>
</body>

</html>
