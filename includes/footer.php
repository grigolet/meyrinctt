    </main>

    <footer class="py-16 bg-primary text-white mt-16">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="mb-4 text-primary-light font-extrabold uppercase"><?php echo $config['site_name']; ?></h4>
                    <p>Club de Tennis de Table</p>
                    <p>1217 Meyrin</p>
                </div>
                <div>
                    <h4 class="mb-4 text-primary-light font-extrabold uppercase">Liens</h4>
                    <ul class="list-none space-y-2">
                        <li><a href="index.php" class="hover:text-primary-light transition-colors">Accueil</a></li>
                        <li><a href="club.php" class="hover:text-primary-light transition-colors">Club</a></li>
                        <li><a href="gallery.php" class="hover:text-primary-light transition-colors">Galerie</a></li>
                        <li><a href="contact.php" class="hover:text-primary-light transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 text-primary-light font-extrabold uppercase">Contact</h4>
                    <p>info@meyrinctt.ch</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
                if (!sessionStorage.getItem('bannerDismissed')) {
                    banner.classList.remove('hidden');
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
