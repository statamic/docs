// function isAppleDevice() {
//     return /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform);
// }
//
// function dismissSearchModal() {
//     const element = document.querySelector('.docsearch-modal-container');
//
//     if (! element) {
//         return;
//     }
//
//     const clickEvent = new MouseEvent('mousedown', {
//         bubbles: true,
//         cancelable: true,
//         view: window
//     });
//
//     element.dispatchEvent(clickEvent);
// }
//
// document.addEventListener('click', function(event) {
//     if (
//         event.target.closest('.docsearch-modal-search-hits-item') &&
//         event.target.closest('a')
//     ) {
//         if (event.ctrlKey || (isAppleDevice() && event.metaKey)) {
//             return;
//         }
//
//         if (! document.body.classList.contains('docsearch--active')) {
//             return;
//         }
//
//         dismissSearchModal();
//     }
// });
