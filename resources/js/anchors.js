// Add header anchors
var elements = document.querySelectorAll('article h2, article h3');
Array.prototype.forEach.call(elements, function (el, i) {
    if (el.id) {
        el.innerHTML += '<a href="#' + el.id + '" class="anchor"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" viewBox="0 0 16 16" height="16" width="16"><title>bookmarks 2 (From Streamline App : https://app.streamlineicons.com)</title><g transform="matrix(0.6666666666666666,0,0,0.6666666666666666,0,0)"><path d="M 16.5,4.05c-0.828,0-1.5,0.672-1.5,1.5V22.2c0,0.414-0.336,0.75-0.75,0.75c-0.14,0-0.278-0.039-0.397-0.114 L9,19.8l-4.853,3.033c-0.351,0.219-0.814,0.112-1.033-0.239C3.04,22.476,3.001,22.339,3,22.2V5.55c0-2.485,2.015-4.5,4.5-4.5h9 c2.485,0,4.5,2.015,4.5,4.5V9.3c0,0.414-0.336,0.75-0.75,0.75H15" stroke="currentColor" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g></svg></a>';
    }
});
