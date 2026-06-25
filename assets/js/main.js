(function () {
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    reveals.forEach((el) => observer.observe(el));

    const counters = document.querySelectorAll('[data-count]');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = Number(el.dataset.count || 0);
            const suffix = target === 99 ? '%' : target === 35 ? '+' : '';
            let value = 0;
            const step = Math.max(1, Math.ceil(target / 42));
            const timer = setInterval(() => {
                value += step;
                if (value >= target) {
                    value = target;
                    clearInterval(timer);
                }
                el.textContent = value + suffix;
            }, 28);
            counterObserver.unobserve(el);
        });
    }, { threshold: 0.5 });
    counters.forEach((el) => counterObserver.observe(el));

    const canvas = document.getElementById('particleCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width;
    let height;
    let particles = [];

    function resize() {
        width = canvas.width = canvas.offsetWidth * window.devicePixelRatio;
        height = canvas.height = canvas.offsetHeight * window.devicePixelRatio;
        ctx.setTransform(window.devicePixelRatio, 0, 0, window.devicePixelRatio, 0, 0);
        particles = Array.from({ length: Math.min(90, Math.floor(window.innerWidth / 18)) }, () => ({
            x: Math.random() * canvas.offsetWidth,
            y: Math.random() * canvas.offsetHeight,
            vx: (Math.random() - 0.5) * 0.35,
            vy: (Math.random() - 0.5) * 0.35,
            r: Math.random() * 1.7 + 0.6
        }));
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.offsetWidth, canvas.offsetHeight);
        particles.forEach((p, i) => {
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0 || p.x > canvas.offsetWidth) p.vx *= -1;
            if (p.y < 0 || p.y > canvas.offsetHeight) p.vy *= -1;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(255,255,255,0.55)';
            ctx.fill();

            for (let j = i + 1; j < particles.length; j++) {
                const q = particles[j];
                const dx = p.x - q.x;
                const dy = p.y - q.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(q.x, q.y);
                    ctx.strokeStyle = `rgba(59,130,246,${(1 - dist / 120) * 0.22})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        });
        requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    resize();
    draw();
})();
