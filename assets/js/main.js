$(function() {
    $('[data-toggle="tooltip"]').tooltip();

    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        const icons = Array.from(heroSection.querySelectorAll('.hero-icon'));
        const layers = Array.from(heroSection.querySelectorAll('.hero-layer'));
        let lastX = 0;
        let lastY = 0;
        let rafId = null;

        function updateParallax() {
            icons.forEach(function(icon) {
                const depth = parseFloat(icon.dataset.depth) || 1;
                const tx = lastX * depth * 12;
                const ty = lastY * depth * 10;
                icon.style.transform = 'translate3d(' + tx + 'px, ' + ty + 'px, 0)';
            });
            layers.forEach(function(layer, index) {
                const depth = 0.12 + index * 0.08;
                const tx = lastX * depth * 40;
                const ty = lastY * depth * 24;
                layer.style.transform = 'translate3d(' + tx + 'px, ' + ty + 'px, 0)';
            });
            rafId = null;
        }

        heroSection.addEventListener('mousemove', function(event) {
            const rect = heroSection.getBoundingClientRect();
            lastX = (event.clientX - rect.left) / rect.width - 0.5;
            lastY = (event.clientY - rect.top) / rect.height - 0.5;
            if (!rafId) {
                rafId = requestAnimationFrame(updateParallax);
            }
        });

        heroSection.addEventListener('mouseleave', function() {
            lastX = 0;
            lastY = 0;
            if (!rafId) {
                rafId = requestAnimationFrame(updateParallax);
            }
        });
    }
});
