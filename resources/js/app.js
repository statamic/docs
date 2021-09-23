import Alpine from 'alpinejs';
import docsearch from '@docsearch/js';
import '@docsearch/css';

require('./anchors.js')
require('./cookies.js')
require('./external-links.js')
// require('./prism.js')


docsearch({
  container: '#docsearch',
  appId: 'BH4D9OD16A',
  indexName: 'statamic_3',
  apiKey: 'b5e8f73c7462a6d5c8b525ef183aabec',
  transformItems(items) {
    return items.map((item) => {
        // Transform the absolute URL into a relative URL so it works locally.
        const a = document.createElement('a');
        a.href = item.url;

        // If the result is the h1, remove the hash
        const hash = a.hash === '#content' ? '' : a.hash;

        return {...item, url: `${a.pathname}${hash}`}
    });
  },
});

window.bodyData = function() {
    let primaryKeyBind = /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform) ? 'meta' : 'ctrl';
    return {
        showNav: false,
        showSearch: false,
        showEasterEgg: false,
        nearTop: true,
    };
}

Alpine.start();
window.Alpine = Alpine;
