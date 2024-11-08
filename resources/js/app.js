import Alpine from 'alpinejs';
import "meilisearch-docsearch/css";
import { docsearch } from "meilisearch-docsearch";

require('./anchors.js')
require('./cookies.js')
require('./external-links.js')
require('./language-badges.js')
var dayjs = require('dayjs')
var relativeTime = require('dayjs/plugin/relativeTime')
dayjs.extend(relativeTime)

window.dayjs = dayjs;

docsearch({
    container: "#docsearch",
    host: "http://localhost:7700",
    apiKey: "c0384ca771d144ba4c1e5101b7dfda260ccc1c761f2059a6a4155782b8a76c41",
    indexUid: "default",
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

window.htmlData = function() {
    return {
        themePickerOpen: false,
        themePreference: localStorage.getItem('theme') || 'system',
        systemTheme: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
        setSystemTheme(theme) {
            this.systemTheme = theme
        },
        setThemePreference(theme) {
            this.themePreference = theme
            localStorage.setItem('theme', theme)
        },
        get darkMode() {
            return this.themePreference === 'dark' || (this.themePreference === 'system' && this.systemTheme === 'dark')
        },
    }
}

Alpine.start();
window.Alpine = Alpine;
