import Alpine from 'alpinejs';
import "meilisearch-docsearch/css";
import { docsearch } from "meilisearch-docsearch";

require('./anchors.js')
require('./cookies.js')
require('./external-links.js')
require('./language-badges.js')
require('./searchHotKeys.js')
var dayjs = require('dayjs')
var relativeTime = require('dayjs/plugin/relativeTime')
dayjs.extend(relativeTime)

window.dayjs = dayjs;

docsearch({
    container: "#docsearch",
    host: "http://10.136.103.190:7700",
    apiKey: "fda1b40aeb7f13793823d0c60fa9f2f64592775a5ab166a7bad349d435044c41",
    indexUid: "default",
    hotKeys: ['ctrl+k', '/']
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
        get theme() {
            return this.darkMode ? 'dark' : 'light'
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
