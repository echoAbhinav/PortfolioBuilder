// Toggle dark mode
const darkModeToggle = document.getElementById('dark-mode-toggle');
darkModeToggle.addEventListener('change', () => {
    document.body.classList.toggle('dark');
    const isDarkMode = document.body.classList.contains('dark');
    
    // Save preference to session and database
    fetch('update_dark_mode.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'dark_mode=' + (isDarkMode ? 1 : 0)
    });
});

// Toggle sidebar on mobile
const mobileMenuBtn = document.getElementById('mobile-menu');
const sidebar = document.getElementById('sidebar');
mobileMenuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
});

// Animate elements on scroll
const animateOnScroll = () => {
    const elements = document.querySelectorAll('.fade-in');
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        
        if(elementPosition < windowHeight - 100) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
};

// Initialize animation on load
window.addEventListener('load', () => {
    animateOnScroll();
});

// Animate on scroll
window.addEventListener('scroll', () => {
    animateOnScroll();
});