<?php
/**
 * Footer snippet for Meyrin CTT Kirby Theme
 * 
 * This snippet contains the footer and closing HTML tags.
 * Reused across all templates.
 */
?>
    </main>

    <footer class="py-16 bg-primary text-white mt-16">
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
                    <?php if ($site->club_address()->isNotEmpty()): ?>
                        <?= $site->club_address()->kt() ?>
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
                    <?php if ($site->club_email()->isNotEmpty()): ?>
                        <p><?= $site->club_email()->esc() ?></p>
                    <?php else: ?>
                        <p>info@meyrinctt.ch</p>
                    <?php endif ?>
                    
                    <?php if ($site->social_links()->isNotEmpty()): ?>
                    <div class="mt-4 flex gap-4">
                        <?php foreach ($site->social_links()->toStructure() as $social): ?>
                        <a href="<?= $social->url()->esc() ?>" target="_blank" rel="noopener" class="hover:text-primary-light transition-colors" aria-label="<?= $social->platform()->esc() ?>">
                            <?= $social->platform()->esc() ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu toggle
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mainNav = document.querySelector('.main-nav');

            if (mobileMenuToggle && mainNav) {
                mobileMenuToggle.addEventListener('click', () => {
                    const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
                    mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
                    mainNav.classList.toggle('hidden');
                });
            }

            // Announcement Banner Logic
            const banner = document.getElementById('announcement-banner');
            const closeBannerBtn = document.getElementById('close-banner');

            if (banner && closeBannerBtn) {
                if (sessionStorage.getItem('bannerDismissed')) {
                    banner.classList.add('hidden');
                }

                closeBannerBtn.addEventListener('click', () => {
                    banner.classList.add('hidden');
                    sessionStorage.setItem('bannerDismissed', 'true');
                });
            }
        });
    </script>
</body>

</html>
