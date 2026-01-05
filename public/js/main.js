// // Mobile menu toggle
// function toggleMobileMenu() {
//     const nav = document.getElementById('mainNav');
//     const toggle = document.getElementById('mobileToggle');
//     nav.classList.toggle('active');
//     toggle.classList.toggle('active');
//
//     // 防止body滚动
//     if (nav.classList.contains('active')) {
//         document.body.style.overflow = 'hidden';
//     } else {
//         document.body.style.overflow = '';
//     }
// }
//
// // Mobile dropdown toggle
// function toggleMobileDropdown(dropdownId) {
//     if (window.innerWidth <= 1024) {
//         const dropdown = document.getElementById(dropdownId);
//         dropdown.classList.toggle('mobile-open');
//
//         // 关闭其他下拉菜单
//         const allDropdowns = document.querySelectorAll('.dropdown');
//         allDropdowns.forEach(d => {
//             if (d.id !== dropdownId) {
//                 d.classList.remove('mobile-open');
//             }
//         });
//     }
// }

// Scroll to top
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show/hide scroll to top button and header shadow
window.addEventListener('scroll', function() {
    const scrollToTopBtn = document.getElementById('scrollToTop');
    const header = document.getElementById('header');

    if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add('show');
        header.classList.add('scrolled');
    } else {
        scrollToTopBtn.classList.remove('show');
        header.classList.remove('scrolled');
    }
});
//
// // Close mobile menu when clicking outside
// document.addEventListener('click', function(event) {
//     const nav = document.getElementById('mainNav');
//     const toggle = document.getElementById('mobileToggle');
//     const isClickInsideNav = nav.contains(event.target);
//     const isClickOnToggle = toggle.contains(event.target);
//
//     if (!isClickInsideNav && !isClickOnToggle && nav.classList.contains('active')) {
//         nav.classList.remove('active');
//         toggle.classList.remove('active');
//         document.body.style.overflow = '';
//     }
// });
//
// // Add fade-in animation to elements
// document.addEventListener('DOMContentLoaded', function() {
//     const elements = document.querySelectorAll('.card, .article-item');
//
//     const observer = new IntersectionObserver((entries) => {
//         entries.forEach(entry => {
//             if (entry.isIntersecting) {
//                 entry.target.classList.add('fade-in');
//             }
//         });
//     }, { threshold: 0.1 });
//
//     elements.forEach(element => {
//         observer.observe(element);
//     });
// });
//
// document.querySelectorAll('.article-content table').forEach(table => {
//     if (!table.parentElement.classList.contains('table-wrapper')) {
//         const wrapper = document.createElement('div');
//         wrapper.className = 'table-wrapper';
//         table.parentNode.insertBefore(wrapper, table);
//         wrapper.appendChild(table);
//     }
// });
