<?php
/**
 * Holiday decorations snippet
 * 
 * Christmas lights and snowflakes animation.
 */
?>
<!-- Christmas Decorations -->
<div class="christmas-decorations">
    <!-- Light String Container -->
    <svg id="light-string-svg" class="light-string" xmlns="http://www.w3.org/2000/svg">
        <path id="light-wire" d="" stroke="#2d3748" stroke-width="2" fill="none" opacity="0.3"/>
        <g id="lights-container"></g>
    </svg>

    <!-- Snowflakes -->
    <div id="snowflakes-container"></div>
</div>

<script>
    // Christmas Lights Dynamic Generation
    function generateChristmasLights() {
        const svg = document.getElementById('light-string-svg');
        const wire = document.getElementById('light-wire');
        const container = document.getElementById('lights-container');
        
        if (!svg || !wire || !container) return;

        const width = window.innerWidth;
        const lightCount = Math.floor(width / 50);
        const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];

        // Generate wavy wire path
        let path = `M 0 15`;
        for (let i = 0; i <= lightCount; i++) {
            const x = (i / lightCount) * width;
            const y = 15 + Math.sin(i * 0.5) * 8;
            path += ` L ${x} ${y}`;
        }
        wire.setAttribute('d', path);

        // Clear existing lights
        container.innerHTML = '';

        // Add lights
        for (let i = 0; i < lightCount; i++) {
            const x = ((i + 0.5) / lightCount) * width;
            const y = 15 + Math.sin((i + 0.5) * 0.5) * 8;
            const color = colors[i % colors.length];

            const light = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            light.setAttribute('cx', x);
            light.setAttribute('cy', y + 8);
            light.setAttribute('r', 5);
            light.setAttribute('fill', color);
            light.style.animation = `twinkle ${1.5 + Math.random()}s ease-in-out infinite`;
            light.style.animationDelay = `${Math.random() * 2}s`;
            container.appendChild(light);
        }
    }

    // Snowflakes
    function createSnowflakes() {
        const container = document.getElementById('snowflakes-container');
        if (!container) return;
        
        const snowflakeCount = 50;
        const snowflakes = ['❄', '❅', '❆', '✻', '✼'];

        for (let i = 0; i < snowflakeCount; i++) {
            const snowflake = document.createElement('div');
            snowflake.className = 'snowflake';
            snowflake.innerHTML = snowflakes[Math.floor(Math.random() * snowflakes.length)];
            snowflake.style.left = `${Math.random() * 100}vw`;
            snowflake.style.fontSize = `${8 + Math.random() * 16}px`;
            snowflake.style.opacity = `${0.3 + Math.random() * 0.7}`;
            snowflake.style.animationDuration = `${8 + Math.random() * 12}s`;
            snowflake.style.animationDelay = `${Math.random() * 10}s`;
            container.appendChild(snowflake);
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        generateChristmasLights();
        createSnowflakes();
    });

    // Resize handler
    window.addEventListener('resize', () => {
        generateChristmasLights();
    });
</script>
