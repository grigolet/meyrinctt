<?php

/**
 * Meyrin CTT - Kirby 5 Theme
 * 
 * This is the main entry point for the Kirby CMS.
 * Make sure to copy the /kirby folder from the starterkit to this directory.
 */

require __DIR__ . '/kirby/bootstrap.php';

echo (new Kirby)->render();
