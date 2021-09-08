import Alpine from 'alpinejs';

require('./anchors.js')
require('./cookies.js')
require('./external-links.js')
require('./prism.js')

window.bodyData = function() {
    let primaryKeyBind = /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform) ? 'meta' : 'ctrl';
    return {
        showNav: false,
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
