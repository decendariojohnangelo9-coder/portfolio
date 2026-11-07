// Typing effect
(function () {
  const el = document.getElementById('typed');
  if (!el) return;
  const lines = ['IT Student', 'Web Developer', 'PHP + JavaScript builder'];
  let i = 0, j = 0, deleting = false;
  function tick() {
    const word = lines[i];
    el.textContent = word.slice(0, j);
    if (!deleting && j < word.length) { j++; return setTimeout(tick, 80); }
    if (!deleting) { deleting = true; return setTimeout(tick, 1400); }
    if (j > 0) { j--; return setTimeout(tick, 40); }
    deleting = false; i = (i + 1) % lines.length; setTimeout(tick, 300);
  }
  tick();
})();

// Mobile menu
const toggle = document.querySelector('.nav-toggle');
const menu = document.getElementById('menu');
toggle.addEventListener('click', () => {
  const open = menu.classList.toggle('open');
  toggle.setAttribute('aria-expanded', open);
});
menu.addEventListener('click', e => {
  if (e.target.tagName === 'A') { menu.classList.remove('open'); toggle.setAttribute('aria-expanded', false); }
});

// Section reveal on scroll
const io = new IntersectionObserver(entries => {
  entries.forEach(en => {
    if (!en.isIntersecting) return;
    en.target.classList.add('in');
    io.unobserve(en.target);
  });
}, { threshold: 0, rootMargin: '0px 0px -10% 0px' });
document.querySelectorAll('.section').forEach(s => { s.classList.add('reveal'); io.observe(s); });

// Highlight the nav link of the section you are currently reading
(function () {
  const map = new Map();
  document.querySelectorAll('#menu a').forEach(a => {
    const id = (a.getAttribute('href') || '').split('#')[1];
    if (id) map.set(id, a);
  });
  const sections = [...map.keys()].map(id => document.getElementById(id)).filter(Boolean);
  if (!sections.length) return;           // e.g. project page: nothing to track
  const hero = document.querySelector('.hero');
  const spy = new IntersectionObserver(entries => {
    entries.forEach(en => {
      if (!en.isIntersecting) return;
      map.forEach(a => { a.classList.remove('active'); a.removeAttribute('aria-current'); });
      const a = map.get(en.target.id);    // hero has no link, so everything gets cleared
      if (a) { a.classList.add('active'); a.setAttribute('aria-current', 'true'); }
    });
  }, { rootMargin: '-40% 0px -55% 0px' });
  sections.forEach(s => spy.observe(s));
  if (hero) spy.observe(hero);
})();

// Back to top button
(function () {
  const btn = document.querySelector('.to-top');
  if (!btn) return;
  const update = () => { btn.hidden = window.scrollY < 600; };
  window.addEventListener('scroll', update, { passive: true });
  btn.addEventListener('click', () => window.scrollTo(0, 0));   // CSS scroll-behavior makes it smooth
  update();
})();

// Contact form: character counter + "Sending..." state
(function () {
  const form = document.querySelector('form[action="contact.php"]');
  if (!form) return;
  const btn = form.querySelector('button[type="submit"]');
  const msg = form.querySelector('textarea');
  const count = document.getElementById('msgCount');
  const update = () => { count.textContent = msg.value.length + ' / ' + msg.maxLength; };
  msg.addEventListener('input', update);
  update();
  form.addEventListener('submit', () => { btn.disabled = true; btn.textContent = 'Sending...'; });
  // If the person presses Back, restore the button.
  window.addEventListener('pageshow', e => {
    if (e.persisted) { btn.disabled = false; btn.textContent = 'Send message'; }
  });
})();

// Gallery lightbox (project page)
(function () {
  const box = document.getElementById('lightbox');
  const shots = [...document.querySelectorAll('.shot-btn')];
  if (!box || !shots.length) return;
  const img = document.getElementById('lbImg');
  const title = document.getElementById('lbTitle');
  const cap = document.getElementById('lbCap');
  let current = 0, opener = null;

  function show(i) {
    current = (i + shots.length) % shots.length;
    const b = shots[current];
    img.src = b.dataset.src;
    img.alt = b.dataset.title;
    title.textContent = b.dataset.title;
    cap.textContent = b.dataset.caption;
  }
  function open(i) {
    opener = shots[i]; show(i);
    box.hidden = false; document.body.style.overflow = 'hidden';
    box.querySelector('.lb-close').focus();
  }
  function close() {
    box.hidden = true; document.body.style.overflow = '';
    if (opener) opener.focus();
  }
  shots.forEach((b, i) => b.addEventListener('click', () => open(i)));
  box.addEventListener('click', e => { if (e.target === box || e.target.classList.contains('lb-close')) close(); });
  box.querySelector('.lb-prev').addEventListener('click', () => show(current - 1));
  box.querySelector('.lb-next').addEventListener('click', () => show(current + 1));
  document.addEventListener('keydown', e => {
    if (box.hidden) return;
    if (e.key === 'Escape') close();
    else if (e.key === 'ArrowLeft') show(current - 1);
    else if (e.key === 'ArrowRight') show(current + 1);
  });
})();

// Code modal
const modal = document.getElementById('codeModal');
const mCode = document.getElementById('modalCode');
const mTitle = document.getElementById('modalTitle');
let lastBtn = null;

function closeModal() { modal.hidden = true; document.body.style.overflow = ''; if (lastBtn) lastBtn.focus(); }
document.querySelectorAll('.code-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    lastBtn = btn;
    mTitle.textContent = btn.dataset.file || 'Source code';
    mCode.textContent = btn.dataset.code;
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
    modal.querySelector('.modal-close').focus();
  });
});
modal.addEventListener('click', e => { if (e.target === modal || e.target.classList.contains('modal-close')) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.hidden) closeModal(); });