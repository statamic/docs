// import * as Turbo from "@hotwired/turbo"
import Alpine from 'alpinejs';

// require('./anchors.js')
require('./cookies.js')
require('./external-links.js')
require('./prism.js')

window.bodyData = function() {
    let primaryKeyBind = /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform) ? 'meta' : 'ctrl';
    return {
        showNav: true,
        showEasterEgg: false,
        nearTop: true,
        bindings: {
            ['@keydown.slash.prevent']() {
                this.$refs.docsSearch.focus();
            },
            ['@keydown.' + primaryKeyBind + '.k.prevent']() {
                this.$refs.docsSearch.focus();
            }
        }
    };
}

Prism.highlightAll()

Alpine.start();
window.Alpine = Alpine;

// Turbo + Alpine.js 3 bridge
// via: https://gist.github.com/calebporzio/20cf74af4a015644c7bef5166cffd86c
document.addEventListener('turbo:before-render', () => {
    let permanents = document.querySelectorAll('[data-turbo-permanent]')

    let undos = Array.from(permanents).map(el => {
        el._x_ignore = true

        return () => {
            delete el._x_ignore
        }
    })

    document.addEventListener('turbo:render', function handler() {
        while(undos.length) undos.shift()()

        document.removeEventListener('turbo:render', handler)
    })
})
