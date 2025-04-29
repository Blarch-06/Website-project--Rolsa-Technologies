let lastScrollY = window.scrollY;
const nav = document.querySelector('nav');

// Hide navigation bar on scroll
window.addEventListener('scroll', () => {
    if (window.scrollY > lastScrollY) {
        nav.classList.add('hidden');
    } else {
        nav.classList.remove('hidden');
    }
    lastScrollY = window.scrollY;
});

// Highlight the active page
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.nav-link'); // Adjusted selector to match your HTML
    const currentPage = window.location.pathname.split('/').pop().toLowerCase(); // Normalize case

    links.forEach(link => {
        const linkHref = link.getAttribute('href').split('/').pop().toLowerCase(); // Normalize case
        if (linkHref === currentPage || (linkHref === 'index.html' && currentPage === '')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active'); // Ensure other links are not highlighted
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const aboutSection = document.getElementById('about-rolsa');

    const handleScroll = () => {
        const sectionPosition = aboutSection.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (sectionPosition < screenPosition) {
            aboutSection.classList.add('visible');
        }
    };

    window.addEventListener('scroll', handleScroll);
});

document.addEventListener('DOMContentLoaded', () => {
    const aboutLongSection = document.getElementById('about-rolsa-long');

    const handleScroll = () => {
        const sectionPosition = aboutLongSection.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (sectionPosition < screenPosition) {
            aboutLongSection.classList.add('visible');
        } else {
            aboutLongSection.classList.remove('visible');
        }
    };

    window.addEventListener('scroll', handleScroll);
});

document.addEventListener('DOMContentLoaded', () => {
    const scrollContainer = document.querySelector('.testimonial-scroll-container');

    scrollContainer.addEventListener('wheel', (event) => {
        event.preventDefault();
        scrollContainer.scrollBy({
            left: event.deltaY, // Use vertical scroll input to scroll horizontally
            behavior: 'smooth',
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
  // Function to check if a cookie exists
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
  }

  // Check if the user is logged in
  const isLoggedIn = getCookie('user_logged_in') === 'true';

  // Modify the navigation bar based on login status
  const navLinks = document.getElementById('nav-links');
  const loginLink = document.getElementById('login-link');

  if (isLoggedIn) {
    // Remove the "Login" link if it exists
    if (loginLink) {
      loginLink.remove();
    }

    // Check if "Dashboard" and "Logout" links already exist
    const existingDashboardLink = navLinks.querySelector('a[href="php/dashboard.php"]');
    const existingLogoutLink = navLinks.querySelector('a[href="php/logout.php"]');

    if (!existingDashboardLink) {
      // Add "Dashboard" link
      const dashboardLink = document.createElement('li');
      dashboardLink.className = 'nav-item';
      dashboardLink.innerHTML = '<a class="nav-link" href="php/dashboard.php">Dashboard</a>';
      navLinks.appendChild(dashboardLink);
    }

    if (!existingLogoutLink) {
      // Add "Logout" link
      const logoutLink = document.createElement('li');
      logoutLink.className = 'nav-item';
      logoutLink.innerHTML = '<a class="nav-link" href="php/logout.php">Logout</a>';
      navLinks.appendChild(logoutLink);
    }
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const animatedElements = document.querySelectorAll('[data-animation]');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animated'); // Add a class to mark as animated
        observer.unobserve(entry.target); // Stop observing once animated
      }
    });
  }, {
    threshold: 0.1, // Trigger when 10% of the element is visible
  });

  animatedElements.forEach((element) => observer.observe(element));
});
