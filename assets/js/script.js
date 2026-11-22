// 1. Navbar berubah warna saat di-scroll
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// 2. Toggle Menu Mobile
const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');
if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('open');
    });
}

// 3. Interactive Tab Syarat Beasiswa
const tabBtns = document.querySelectorAll('.tab-btn');
const tabPanes = document.querySelectorAll('.tab-pane');

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        tabBtns.forEach(b => b.classList.remove('active'));
        tabPanes.forEach(p => p.classList.remove('active'));

        btn.classList.add('active');
        const target = document.getElementById(btn.dataset.tab);
        if (target) target.classList.add('active');
    });
});

// 4. Animasi Scroll Reveal & Counter Angka Awardee
const reveals = document.querySelectorAll('.reveal');
const counters = document.querySelectorAll('.stat-number');
let counterStarted = false;

function handleScroll() {
    const triggerBottom = window.innerHeight * 0.88;

    reveals.forEach(el => {
        const boxTop = el.getBoundingClientRect().top;
        if (boxTop < triggerBottom) {
            el.classList.add('active');
        }
    });

    // Jalankan counter saat bagian statistik terlihat
    const statsSection = document.getElementById('statistik');
    if (statsSection && !counterStarted) {
        const statsTop = statsSection.getBoundingClientRect().top;
        if (statsTop < triggerBottom) {
            counterStarted = true;
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const increment = target / 60;
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.innerText = Math.ceil(current).toLocaleString('id-ID');
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target.toLocaleString('id-ID');
                    }
                };
                updateCounter();
            });
        }
    }
}

window.addEventListener('scroll', handleScroll);
handleScroll(); // Panggil saat halaman pertama dimuat