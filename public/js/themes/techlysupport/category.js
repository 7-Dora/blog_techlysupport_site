// AJAX翻页功能
document.addEventListener('DOMContentLoaded', function() {
    const articleList = document.getElementById('article-list');
    const paginationContainer = document.getElementById('pagination-container');

    // 为所有翻页链接添加点击事件
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('page-link')) {
            e.preventDefault();

            const page = e.target.getAttribute('data-page');
            loadPage(page);
        }
    });

    function loadPage(page) {
        // 显示加载状态
        articleList.style.opacity = '0.5';
        articleList.style.pointerEvents = 'none';

        // 获取当前URL
        const currentUrl = window.location.href.split('?')[0];

        // 发送AJAX请求
        fetch(currentUrl + '?page=' + page, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                // 更新文章列表
                articleList.innerHTML = data.html;
                articleList.style.opacity = '1';
                articleList.style.pointerEvents = 'auto';

                // 更新分页按钮
                updatePagination(data.pagination);

                // 平滑滚动到列表顶部
                const header = document.querySelector('.latest-news-header');
                if (header) {
                    header.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                // 重新触发动画
                const articles = document.querySelectorAll('.article-item');
                articles.forEach((article, index) => {
                    article.style.animation = 'none';
                    setTimeout(() => {
                        article.style.animation = '';
                        article.style.animationDelay = `${index * 0.1}s`;
                    }, 10);
                });
            })
            .catch(error => {
                console.error('Error loading page:', error);
                articleList.style.opacity = '1';
                articleList.style.pointerEvents = 'auto';
                alert('加载失败,请刷新页面重试');
            });
    }

    function updatePagination(pagination) {
        const currentPage = pagination.current_page;
        const lastPage = pagination.last_page;
        const start = Math.max(1, currentPage - 2);
        const end = Math.min(lastPage, currentPage + 2);

        let html = '';

        // Previous按钮
        if (pagination.on_first_page) {
            html += '<span class="disabled page-nav">‹</span>';
        } else {
            html += `<a href="javascript:void(0)" data-page="${currentPage - 1}" class="page-nav page-link">‹</a>`;
        }

        // 第一页
        if (start > 1) {
            html += '<a href="javascript:void(0)" data-page="1" class="page-link">1</a>';
            if (start > 2) {
                html += '<span class="ellipsis">...</span>';
            }
        }

        // 页码
        for (let page = start; page <= end; page++) {
            if (page === currentPage) {
                html += `<span class="active">${page}</span>`;
            } else {
                html += `<a href="javascript:void(0)" data-page="${page}" class="page-link">${page}</a>`;
            }
        }

        // 最后一页
        if (end < lastPage) {
            if (end < lastPage - 1) {
                html += '<span class="ellipsis">...</span>';
            }
            html += `<a href="javascript:void(0)" data-page="${lastPage}" class="page-link">${lastPage}</a>`;
        }

        // Next按钮
        if (pagination.has_more_pages) {
            html += `<a href="javascript:void(0)" data-page="${currentPage + 1}" class="page-nav page-link">›</a>`;
        } else {
            html += '<span class="disabled page-nav">›</span>';
        }

        paginationContainer.innerHTML = html;
        paginationContainer.setAttribute('data-current-page', currentPage);
        paginationContainer.setAttribute('data-last-page', lastPage);
    }
});
