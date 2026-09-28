document.documentElement.classList.add('js');

function initReveal() {
    const els = document.querySelectorAll('[data-reveal]:not(.is-visible)');
    if (!('IntersectionObserver' in window)) {
        els.forEach((el) => el.classList.add('is-visible'));
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                io.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    els.forEach((el) => io.observe(el));
}

function initGlow() {
    document.addEventListener('pointermove', (e) => {
        const card = e.target.closest?.('.card-glow');
        if (!card) return;
        const r = card.getBoundingClientRect();
        card.style.setProperty('--mx', `${e.clientX - r.left}px`);
        card.style.setProperty('--my', `${e.clientY - r.top}px`);
    });
}

function initRanges() {
    const paint = (el) => {
        const pct = ((el.value - el.min) / (el.max - el.min)) * 100;
        el.style.setProperty('--fill', `${pct}%`);
    };
    document.querySelectorAll('input[type=range].range').forEach(paint);
    document.addEventListener('input', (e) => {
        if (e.target.matches?.('input[type=range].range')) paint(e.target);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initReveal();
    initGlow();
    initRanges();
});

document.addEventListener('livewire:navigated', () => {
    initReveal();
    initRanges();
});

document.addEventListener('livewire:init', () => {
    Livewire.hook('morphed', () => {
        initReveal();
        initRanges();
    });
});
