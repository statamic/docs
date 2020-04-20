require('./prism.js')
require('./scrollspy.js')
// require('./nav.js')
require('./anchors.js')
require('./external-links.js')

let phrases = [
    "🍳 What's cookin', home skillet?",
    "🐢 Cowabunga!",
    "🥤 Who loves orange soda?",
    "🔩 I put the screw in the tuna!",
    "🤪 I know you are but what am I?",
    "💣 You da bomb!",
    "🤚 Talk to the hand!",
    "🔥 Let's get crunk!",
    "✂️ Cut. It. Out.",
    "💥 These docs are all that and a bag of chips.",
]

console.log(phrases[Math.floor(Math.random() * phrases.length)])

Prism.highlightAll()
