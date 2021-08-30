const colors = require('tailwindcss/colors')

module.exports = {
  mode: 'jit',
  purge: {
    content: [
      './resources/**/*.antlers.html',
      './resources/**/*.blade.php',
      './content/**/*.md'
    ]
  },
  important: true,
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      black:  '#191A1B',
      white: '#FFFFFF',
      pink: '#FF269E',
      teal: '#01D7B0',
      mint: '#B8FFF3',
      yellow: 'FAF77D',
      gray: colors.trueGray,
    },
    fontFamily: {
    },
    extend: {
    },
  },
  variants: {},
  plugins: [],
}
