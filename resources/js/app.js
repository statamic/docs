/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#statamic',
// });


require('./prism.js')
require('./scrollspy.js')

let phrases = [
    "🍳What's shakin', home skillet?",
    "🐢Cowabunga!",
    "🥤Who loves orange soda?",
    "🔩I put the screw in the tuna!",
    "🤪I know you are but what am I?",
    "💣You da bomb!",
    "🤚Talk to the hand!",
    "🔥Let's get crunk!",
    "✂️Cut. It. Out.",
    "💥These docs are all that and a bag of chips.",
]

console.log(phrases[Math.floor(Math.random() * phrases.length)])

Prism.highlightAll()
