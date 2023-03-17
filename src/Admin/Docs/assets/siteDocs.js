document.addEventListener('DOMContentLoaded', (event) => {
    const container = document.querySelector('.markdown-container');
    if (!container) {
        return;
    }

    let currentPage = container.querySelector('#current-page')?.getAttribute('content');

    if (!currentPage) {
        return;
    }

    const {
        rest_root,
        rest_path,
        nonce,
        currentScreen,
        currentSlug,
    } = window.siteDocs;

    const pageCache = {};

    async function getPageContents(page) {
        if (pageCache[page]) {
            return pageCache[page];
        }

        const request = fetch(`${rest_root}${rest_path}/${page}`, {
            method: 'GET',
            headers: {
                'X-WP-Nonce': nonce,
            },
        });

        const response = await request;
        const data = await response.json();

        const html = data.html;

        pageCache[page] = html;

        return html;
    }

    function decodeHTMLEntities(str) {
        const element = document.createElement('div');

        if (str && typeof str === 'string') {
            // strip script/html tags
            str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
            str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
            element.innerHTML = str;
            str = element.textContent;
            element.textContent = '';
        }

        return str;
    }

    async function renderPage(page) {
        /** @type {HTMLDivElement} */
        const newContent = document.createElement('div');
        const htmlString = await getPageContents(page);

        newContent.innerHTML = decodeHTMLEntities(htmlString);
        newContent.classList.add('markdown-content');
        newContent.classList.add('next-page');

        container.appendChild(newContent);

        container.querySelector('.markdown-content:not(.next-page)').remove();
        newContent.classList.remove('next-page');

        // get code blocks
        const codeBlocks = newContent.querySelectorAll('pre code');
        codeBlocks.forEach((el) => {
            hljs.highlightElement(el);
        });

        // get links
        const links = newContent.querySelectorAll('a');
        links.forEach((el) => {
            // if link ends with .md, it's a link to another page
            if (el.href.endsWith('.md')) {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    const href = el.getAttribute('href');
                    if (href.startsWith('../')) {
                        currentPage = href.replace('../', '');
                    } else {
                        currentPage = href;
                    }

                    renderPage(currentPage);
                });
            }
        });

        // preload links
        links.forEach((el) => {
            const href = el.getAttribute('href');
            if (href.endsWith('.md')) {
                if (href.startsWith('../')) {
                    getPageContents(href.replace('../', ''));
                } else {
                    getPageContents(href);
                }
            }
        });

    }

    document.querySelectorAll('pre code').forEach((el) => {
        hljs.highlightElement(el);
    });

    renderPage(currentPage);
});
