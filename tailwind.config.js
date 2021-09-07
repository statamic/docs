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
      pink: {
        light: '#FFDCED',
        DEFAULT: '#FF269E'
      },
      red: {
        DEFAULT: '#DE3618',
        dark: '#98230E',
      },
      purple: '#6B26FF',
      blue: {
        lightest: '#B1D8FC',
        light: '#01A1D7',
        DEFAULT: '#339CE5',
        dark: '#066A85'
      },
      teal: '#01D7B0',
      mint: '#B8FFF3',
      yellow: 'FAF77D',
      gray: {
        lightest: '#EEF2F6',
        light: '#E7ECF1',
        DEFAULT: '#CBD5E1',
        'dark': '#94A3B8',
      }
    },
    borderColor: theme => ({
       ...theme('colors'),
        DEFAULT: theme('colors.black', 'currentColor'),
    }),
    fontFamily: {
      display: ['tenon', 'sans-serif'],
      sans: ['gira-sans', 'sans-serif'],
      mono: ['Menlo', 'monospace']
    },
    boxShadow: {
      DEFAULT: "2px 2px 0 theme('colors.black', 'currentColor')",
      'sm': "1px 1px 0 theme('colors.black', 'currentColor')",
      'md': "2px 2px 0 theme('colors.black', 'currentColor')",
      'lg': "4px 4px 0 theme('colors.black', 'currentColor')",
      'white': "2px 2px 0 theme('colors.white', 'currentColor')",
      'white-lg': "4px 4px 0 theme('colors.white', 'currentColor')",
      'mint': "1px 1px 0 theme('colors.mint', 'currentColor')",
      'mint-md': "2px 2px 0 theme('colors.mint', 'currentColor')",
      'mint-lg': "7px 7px 0 theme('colors.mint', 'currentColor')",
      'pink': "1px 1px 0 theme('colors.pink.DEFAULT', 'currentColor')",
      'pink-md': "2px 2px 0 theme('colors.pink.DEFAULT', 'currentColor')",
      'pink-lg': "7px 7px 0 theme('colors.pink.DEFAULT', 'currentColor')",
      'purple': "1px 1px 0 theme('colors.purple', 'currentColor')",
      'purple-md': "2px 2px 0 theme('colors.purple', 'currentColor')",
      'purple-lg': "7px 7px 0 theme('colors.purple', 'currentColor')",
      'red': "1px 1px 0 theme('colors.red.DEFAULT', 'currentColor')",
      'red-md': "2px 2px 0 theme('colors.red.DEFAULT', 'currentColor')",
      'red-lg': "7px 7px 0 theme('colors.red.DEFAULT', 'currentColor')",
      'red-dark': "1px 1px 0 theme('colors.red.dark', 'currentColor')",
      'red-dark-md': "2px 2px 0 theme('colors.red.dark', 'currentColor')",
      'red-dark-lg': "7px 7px 0 theme('colors.red.dark', 'currentColor')",
      'teal': "1px 1px 0 theme('colors.teal', 'currentColor')",
      'teal-md': "2px 2px 0 theme('colors.teal', 'currentColor')",
      'teal-lg': "7px 7px 0 theme('colors.teal', 'currentColor')",
      'stack': "5px 5px 0 -1px #fff, 5px 5px 0 theme('colors.black')",
      'stack-md': "10px 10px 0 -1px #fff, 10px 10px 0 theme('colors.black')",
      'stack-lg': "20px 20px 0 -1px #fff, 20px 20px 0 theme('colors.black'), 40px 40px 0 -1px #fff, 40px 40px 0 theme('colors.black')",
      'outline': '0 0 0 3px rgba(66, 153, 225, 0.5)',
    },
    extend: {
      fontSize: {
        '3xl': ['2rem', 1],
        '7xl': ['4.25rem', 1],
      }
    },
  },
  variants: {},
  plugins: [],
}
