
let tableOfContents = document.querySelector('.toc');
// console.log(tableOfContents)
if (tableOfContents) {
	let headers = [].slice.call(document.querySelectorAll('h2'))
		.map(({ id, offsetTop: position }) => ({ id, position }))
		.reverse();

	highlightLink(headers[headers.length - 1].id);

	window.addEventListener('scroll', event => {
		let position = (document.documentElement.scrollTop || document.body.scrollTop) + 34;
		let current = headers.filter(header => header.position < position)[0] || headers[headers.length - 1];
		let active = document.querySelector('.toc .active');

		if (active) {
			active.classList.remove('active');
		}

		highlightLink(current.id);
	});
}


function highlightLink(id) {
	let highlight = document.querySelector(`.toc a[href="#${id}"]`);

	if (highlight) {
		highlight.parentNode.classList.add('active');
	}

}
