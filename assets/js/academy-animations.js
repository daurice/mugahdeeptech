(function () {
  document.documentElement.classList.add('page-enter');
  window.addEventListener('load', function () {
    document.documentElement.classList.add('page-enter-active');
    if (window.AOS) AOS.init({ duration: 700, once: true, easing: 'ease-out-cubic' });
    if (window.gsap) {
      gsap.from('.academy-course-card, .stat-admin', { y: 18, opacity: 0, duration: 0.65, stagger: 0.06, ease: 'power2.out' });
      gsap.from('.lesson-link', { x: -12, opacity: 0, duration: 0.45, stagger: 0.025, ease: 'power2.out' });
    }
  });

  document.querySelectorAll('[data-count]').forEach(function (el) {
    var target = Number(el.dataset.count || el.textContent || 0);
    var value = 0;
    var step = Math.max(1, Math.ceil(target / 45));
    var timer = setInterval(function () {
      value += step;
      if (value >= target) { value = target; clearInterval(timer); }
      el.textContent = value;
    }, 22);
  });

  document.querySelectorAll('.progress-ring').forEach(function (ring) {
    var p = Number(getComputedStyle(ring).getPropertyValue('--progress')) || 0;
    ring.style.background = 'conic-gradient(#3B82F6 0deg, #7C3AED ' + (p * 3.6) + 'deg, rgba(255,255,255,0.08) ' + (p * 3.6) + 'deg)';
  });

  document.querySelectorAll('.continue-pulse').forEach(function (card) {
    card.addEventListener('mousemove', function (e) {
      var r = card.getBoundingClientRect();
      card.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 100) + '%');
      card.style.setProperty('--my', ((e.clientY - r.top) / r.height * 100) + '%');
    });
  });

  var result = document.querySelector('[data-quiz-result="passed"]');
  if (result) launchConfetti();
  if (document.querySelector('.certificate-card')) {
    document.body.classList.add('certificate-ready');
    setTimeout(launchConfetti, 500);
  }

  var adminCanvas = document.getElementById('lmsAdminChart');
  if (adminCanvas && window.Chart) {
    new Chart(adminCanvas, { type: 'line', data: { labels: ['Courses','Learners','Enrollments','Quizzes','Certificates'], datasets: [{ label: 'LMS activity', data: JSON.parse(adminCanvas.dataset.values || '[0,0,0,0,0]'), borderColor: '#3B82F6', backgroundColor: 'rgba(59,130,246,.16)', tension: .42, fill: true }] }, options: { animation: { duration: 1200 }, plugins: { legend: { labels: { color: '#fff' } } }, scales: { x: { ticks: { color: '#B8B8B8' }, grid: { color: 'rgba(255,255,255,.06)' } }, y: { ticks: { color: '#B8B8B8' }, grid: { color: 'rgba(255,255,255,.06)' } } } } });
  }

  function launchConfetti() {
    var wrap = document.createElement('div');
    wrap.className = 'premium-confetti';
    document.body.appendChild(wrap);
    for (var i = 0; i < 60; i++) {
      var piece = document.createElement('i');
      piece.style.left = Math.random() * 100 + 'vw';
      piece.style.animationDelay = Math.random() * 0.7 + 's';
      piece.style.background = ['#3B82F6','#7C3AED','#10B981','#FFFFFF'][i % 4];
      wrap.appendChild(piece);
    }
    setTimeout(function () { wrap.remove(); }, 3600);
  }
})();