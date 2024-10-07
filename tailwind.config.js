module.exports = {
//   important: true,
  content: [
    './resources/**/*.antlers.html',
    './resources/**/*.blade.php',
    './content/**/*.md'
  ],
  darkMode: 'class',
  theme: {
    fontFamily: {
      sans: ['Lexend', 'Inter','system-ui'],
      serif: ['p22-mackinac-pro', 'system-ui'],
      mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', "Liberation Mono", "Courier New", 'monospace'],
    },
    // extend: {
    //   typography: (theme) => ({
    //     DEFAULT: {
    //       css: {
    //         h1: {
    //           fontWeight: theme('fontWeight.light'),
    //           fontSize: theme('fontSize.3xl')
    //         },
    //       },
    //     },
    //   }),
    // },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
