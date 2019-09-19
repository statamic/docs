const defaultConfig = require('tailwindcss/defaultConfig')

module.exports = {
  important: true,
  theme: {
    screens: {
      'sm': '576px',
      'md': '768px',
      'lg': '992px',
      'xl': '1280px',
    },
    borderColor: theme => ({
      ...theme('colors'),
      default: theme('colors.blue-darkest', 'currentColor'),
    }),
    borderRadius: {
      none: '0',
      sm: '2px',
      default: '5px',
      full: '9999px',
    },
    borderWidth: {
      default: '1px',
      '0': '0',
      '2': '2px',
      '4': '4px',
      '8': '8px',
    },
    boxShadow: {
      default: "1px 1px 0 theme('colors.blue-darkest', 'currentColor')",
      md: "3px 3px 0 theme('colors.blue-darkest', 'currentColor')",
      teal: "1px 1px 0 theme('colors.teal', 'currentColor')",
      'md-teal': "3px 3px 0 theme('colors.teal', 'currentColor')",
      orange: "1px 1px 0 theme('colors.orange', 'currentColor')",
      'md-orange': "3px 3px 0 theme('colors.orange', 'currentColor')",
      outline: '0 0 0 3px rgba(66, 153, 225, 0.5)',
    },
    colors: {
      transparent: 'transparent',
      'black': '#000',
      'white': '#fff',
      'blue-darkest': '#002F3C',
      'blue-dark': '#00546b',
      'blue': '#6D91D4',
      'blue-light': '#66A4CF',
      'blue-lightest': '#EFFEFF',
      'purple': '#7C67CB',
      'purple-hot': '#A832D7',
      'pink': '#D365CE',
      'pink-bright': '#FC6EB3',
      'pink-hot': '#FF269E',
      'teal-dark': '#066885',
      'teal': '#01D7B0',
      'orange': '#FFB47A',
      'yellow': '#FAF77D',
      'cp-bg': '#F1F5F9',
      'grey': {
        100: '#f7fafc',
        200: '#edf2f7',
        300: '#e2e8f0',
        400: '#cbd5e0',
        500: '#a0aec0',
        600: '#718096',
        700: '#4a5568',
        800: '#2d3748',
        900: '#1a202c',
      },
    },
    extend: {
      fontFamily: {
        'display': ['code-saver', 'sans-serif'],
      },
      spacing: {
        7: '1.75rem'
      },
      inset: {
        '16': '16px',
        '-16': '-16px',
        '64': '64px',
      },
      maxWidth: theme => {
        return {
          'screen-xl': theme('screens.xl'),
        }
      },
    }
  },
  variants: {
    backgroundColor: ['responsive', 'odd', 'even', 'hover', 'focus'],
    borderColor: ['responsive', 'hover', 'focus'],
    borderWidth: ['responsive', 'first', 'last', 'hover', 'focus'],
    opacity: ['responsive', 'hover', 'focus', 'disabled'],
    outline: ['focus'],
  }
}