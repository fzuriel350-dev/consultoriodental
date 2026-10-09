(function () {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reduceMotion) {
        return;
    }

    const selectors = [
        '.hero .container > *',
        '.section-title',
        '.card-grid > *',
        '.appointment-section .container > *',
    ];

    const nodes = [];

    selectors.forEach(function (selector) {
        document.querySelectorAll(selector).forEach(function (el) {
            nodes.push(el);
        });
    });

    if (nodes.length === 0) {
        return;
    }

    nodes.forEach(function (el) {
        el.classList.add('reveal');

        const siblings = Array.prototype.filter.call(
            el.parentElement.children,
            (child) => child.classList.contains('reveal')
        );

        el.style.transitionDelay = (siblings.indexOf(el) * 90) + 'ms';
    });

    if (!('IntersectionObserver' in window)) {
        nodes.forEach(function (el) {
            el.classList.add('is-visible');
        });

        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -8% 0px',
    });

    nodes.forEach(function (el) {
        observer.observe(el);
    });
})();