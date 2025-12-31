<?php
/**
 * Navigation snippet for Meyrin CTT Kirby Theme
 * 
 * Main navigation menu that appears in the header.
 */

// Define menu items - these are the main pages
$menuItems = $site->children()->listed();
?>
<nav class="main-nav hidden md:block absolute md:static top-full left-0 w-full md:w-auto bg-bg md:bg-transparent border-b-2 md:border-0 border-border p-4 md:p-0 shadow-soft md:shadow-none">
    <ul class="flex flex-col md:flex-row gap-4 md:gap-8 list-none">
        <?php foreach ($menuItems as $item): ?>
        <li>
            <a href="<?= $item->url() ?>" 
               class="font-bold uppercase text-sm relative hover:after:w-full after:content-[''] after:absolute after:w-0 after:h-[3px] after:bottom-[-4px] after:left-0 after:bg-primary after:transition-[width] after:duration-300 <?= $item->isActive() ? 'after:w-full' : '' ?>">
                <?= $item->title()->esc() ?>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</nav>
