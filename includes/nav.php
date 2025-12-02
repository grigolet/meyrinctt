<nav class="main-nav hidden md:block absolute md:static top-full left-0 w-full md:w-auto bg-bg md:bg-transparent border-b-2 md:border-0 border-border p-4 md:p-0 shadow-soft md:shadow-none">
    <ul class="flex flex-col md:flex-row gap-4 md:gap-8 list-none">
        <?php
        $menu_items = [
            'index.php' => 'Accueil',
            'club.php' => 'Le Club',
        ];

        foreach ($menu_items as $link => $label) {
            $active_class = ($current_page === $link) ? 'after:w-full' : '';
            echo '<li><a href="' . $link . '" class="font-bold uppercase text-sm relative hover:after:w-full after:content-[\'\'] after:absolute after:w-0 after:h-[3px] after:bottom-[-4px] after:left-0 after:bg-primary after:transition-[width] after:duration-300 ' . $active_class . '">' . $label . '</a></li>';
        }
        ?>
        <li><a href="horaires.php" class="font-bold uppercase text-sm relative hover:after:w-full after:content-[''] after:absolute after:w-0 after:h-[3px] after:bottom-[-4px] after:left-0 after:bg-primary after:transition-[width] after:duration-300 <?php echo $current_page === 'horaires.php' ? 'after:w-full' : ''; ?>">Horaires</a></li>
        <li><a href="inscription.php" class="font-bold uppercase text-sm relative hover:after:w-full after:content-[''] after:absolute after:w-0 after:h-[3px] after:bottom-[-4px] after:left-0 after:bg-primary after:transition-[width] after:duration-300 <?php echo $current_page === 'inscription.php' ? 'after:w-full' : ''; ?>">Inscription</a></li>
        <li><a href="gallery.php" class="font-bold uppercase text-sm relative hover:after:w-full after:content-[''] after:absolute after:w-0 after:h-[3px] after:bottom-[-4px] after:left-0 after:bg-primary after:transition-[width] after:duration-300 <?php echo $current_page === 'gallery.php' ? 'after:w-full' : ''; ?>">Galerie</a></li>
        <li><a href="news.php" class="font-bold uppercase text-sm relative hover:after:w-full after:content-[''] after:absolute after:w-0 after:h-[3px] after:bottom-[-4px] after:left-0 after:bg-primary after:transition-[width] after:duration-300 <?php echo $current_page === 'news.php' ? 'after:w-full' : ''; ?>">Actualités</a></li>
        <li><a href="contact.php" class="font-bold uppercase text-sm relative hover:after:w-full after:content-[''] after:absolute after:w-0 after:h-[3px] after:bottom-[-4px] after:left-0 after:bg-primary after:transition-[width] after:duration-300 <?php echo $current_page === 'contact.php' ? 'after:w-full' : ''; ?>">Contact</a></li>
    </ul>
</nav>
