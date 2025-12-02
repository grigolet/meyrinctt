<?php
$hero_bg = $hero_bg ?? "assets/hero.webp";
?>

<section class="py-32 bg-bg border-b-2 border-border relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center z-0" style="background-image: url('<?php echo $hero_bg; ?>');"></div>
    <div class="absolute top-0 left-0 w-full h-full bg-black/30 z-0 pointer-events-none"></div>

    <div class="absolute top-0 left-0 w-full pointer-events-none z-0">
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
    </div>

    <div class="max-w-[900px] mx-auto px-4 text-center relative z-10">
        <h1 class="text-5xl md:text-7xl font-black mb-4 text-white leading-none uppercase tracking-tighter drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)] text-shadow-lg/30"><?php echo $hero_title; ?></h1>
        <?php if (isset($hero_subtitle)): ?>
            <p class="text-xl md:text-2xl font-bold text-white max-w-[700px] mx-auto drop-shadow-[0_2px_2px_rgba(0,0,0,0.5)] text-shadow-lg/30"><?php echo $hero_subtitle; ?></p>
        <?php endif; ?>
    </div>
</section>
