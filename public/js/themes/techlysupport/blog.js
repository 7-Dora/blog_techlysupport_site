
    document.addEventListener('DOMContentLoaded', function() {
    const articleContent = document.getElementById('articleContent');
    const tocList = document.getElementById('tocList');

    if (!articleContent || !tocList) return;

    // Wrap tables in a responsive wrapper for mobile
    const tables = articleContent.querySelectorAll('table');
    tables.forEach(table => {
    if (!table.parentElement.classList.contains('table-wrapper')) {
    const wrapper = document.createElement('div');
    wrapper.className = 'table-wrapper';
    table.parentNode.insertBefore(wrapper, table);
    wrapper.appendChild(table);
}
});

    // Find all h2 elements in the article content
    const headings = articleContent.querySelectorAll('h2');

    if (headings.length === 0) return;

    // Create sections and TOC items
    headings.forEach((heading, index) => {
    const sectionId = 'section-' + index;
    const partNumber = index + 1;

    // Add ID and class to heading for scroll tracking
    heading.id = sectionId;
    heading.classList.add('content-section');
    heading.style.scrollMarginTop = '100px';

    // Create TOC item
    const tocItem = document.createElement('li');
    tocItem.className = 'toc-item';
    tocItem.innerHTML = `
            <a href="#${sectionId}" class="toc-link" data-section="${sectionId}">
                <span class="toc-number">${partNumber}</span>
                <span class="toc-text">${heading.textContent}</span>
            </a>
        `;
    tocList.appendChild(tocItem);
});

    // Add FAQ section to TOC if exists
    const faqSection = document.getElementById('section-faq');
    if (faqSection) {
    const faqTocItem = document.createElement('li');
    faqTocItem.className = 'toc-item';
    faqTocItem.innerHTML = `
            <a href="#section-faq" class="toc-link" data-section="section-faq">
                <span class="toc-number">?</span>
                <span class="toc-text">FAQ</span>
            </a>
        `;
    tocList.appendChild(faqTocItem);
}

    // Smooth scroll for TOC links
    const tocLinks = document.querySelectorAll('.toc-link');
    tocLinks.forEach(link => {
    link.addEventListener('click', function(e) {
    e.preventDefault();
    const targetId = this.getAttribute('href').substring(1);
    const targetElement = document.getElementById(targetId);

    if (targetElement) {
    const offsetTop = targetElement.getBoundingClientRect().top + window.pageYOffset - 100;
    window.scrollTo({
    top: offsetTop,
    behavior: 'smooth'
});

    // Close mobile TOC if open
    if (window.innerWidth < 1025) {
    document.getElementById('tocWrapper').classList.remove('mobile-open');
}
}
});
});

    // Intersection Observer for highlighting active section
    const observerOptions = {
    root: null,
    rootMargin: '-100px 0px -60% 0px',
    threshold: 0
};

    let currentActiveSection = null;

    const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
    const sectionId = entry.target.id;
    const tocLink = document.querySelector(`.toc-link[data-section="${sectionId}"]`);

    if (entry.isIntersecting) {
    // Remove active class from all links
    tocLinks.forEach(link => link.classList.remove('active'));
    // Add active class to current link
    if (tocLink) {
    tocLink.classList.add('active');
    currentActiveSection = sectionId;
}
}
});
}, observerOptions);

    // Observe all headings
    headings.forEach(heading => {
    observer.observe(heading);
});

    // Also observe FAQ section
    if (faqSection) {
    observer.observe(faqSection);
}

    // Fallback: activate first section on page load if none active
    setTimeout(() => {
    const activeLink = document.querySelector('.toc-link.active');
    if (!activeLink && tocLinks.length > 0) {
    tocLinks[0].classList.add('active');
}
}, 100);

    // Handle scroll to highlight based on scroll position (backup method)
    let scrollTimeout;
    window.addEventListener('scroll', () => {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
    let closestSection = null;
    let closestDistance = Infinity;

    headings.forEach(heading => {
    const rect = heading.getBoundingClientRect();
    const distance = Math.abs(rect.top - 150);
    if (rect.top < window.innerHeight * 0.5 && distance < closestDistance) {
    closestDistance = distance;
    closestSection = heading.id;
}
});

    // Check FAQ section too
    if (faqSection) {
    const faqRect = faqSection.getBoundingClientRect();
    const faqDistance = Math.abs(faqRect.top - 150);
    if (faqRect.top < window.innerHeight * 0.5 && faqDistance < closestDistance) {
    closestSection = 'section-faq';
}
}

    if (closestSection && closestSection !== currentActiveSection) {
    tocLinks.forEach(link => link.classList.remove('active'));
    const targetLink = document.querySelector(`.toc-link[data-section="${closestSection}"]`);
    if (targetLink) {
    targetLink.classList.add('active');
    currentActiveSection = closestSection;
}
}
}, 50);
});
});

    // Mobile TOC toggle (legacy, kept for compatibility)
    function toggleMobileToc() {
    const tocWrapper = document.getElementById('tocWrapper');
    tocWrapper.classList.toggle('mobile-open');
}

    // Mobile Content collapse/expand
    document.addEventListener('DOMContentLoaded', function() {
    const tocWrapper = document.getElementById('tocWrapper');
    if (!tocWrapper) return;

    // 移动端默认收起
    if (window.innerWidth <= 1024) {
    tocWrapper.classList.add('collapsed');

    // Popular articles 也默认收起
    const popularArticles = document.querySelector('.popular-articles');
    if (popularArticles) {
    popularArticles.classList.add('collapsed');
}
}

    const tocHeader = tocWrapper.querySelector('.toc-header');
    if (!tocHeader) return;

    tocHeader.addEventListener('click', function() {
    // Only enable collapse on mobile
    if (window.innerWidth <= 1024) {
    tocWrapper.classList.toggle('collapsed');
}
});

    // Also make popular articles collapsible on mobile
    const popularArticles = document.querySelector('.popular-articles');
    if (popularArticles) {
    const popularHeader = popularArticles.querySelector('.toc-header');
    if (popularHeader) {
    popularHeader.addEventListener('click', function() {
    if (window.innerWidth <= 1024) {
    popularArticles.classList.toggle('collapsed');
}
});
}
}
});
