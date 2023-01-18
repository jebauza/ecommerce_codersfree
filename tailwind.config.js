const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        {
          pattern: /bg-(orange|red)-(100|200|300|400|500|600|700|800|900)/,
          variants: ['hover', 'active'],
        },
        {
          pattern: /border-(orange|red)-(100|200|300|400|500|600|700|800|900)/,
          variants: ['focus'],
        },
        {
          pattern: /ring-(orange|red)-(100|200|300|400|500|600|700|800|900)/,
          variants: ['focus'],
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            // colors: {
            //     transparent: 'transparent',
            //     current: 'currentColor',
            //     black: colors.black,
            //     blue: colors.blue,
            //     cyan: colors.cyan,
            //     emerald: colors.emerald,
            //     fuchsia: colors.fuchsia,
            //     slate: colors.slate,
            //     gray: colors.gray,
            //     neutral: colors.neutral,
            //     stone: colors.stone,
            //     green: colors.green,
            //     indigo: colors.indigo,
            //     lime: colors.lime,
            //     orange: colors.orange,
            //     pink: colors.pink,
            //     purple: colors.purple,
            //     red: colors.red,
            //     rose: colors.rose,
            //     sky: colors.sky,
            //     teal: colors.teal,
            //     violet: colors.violet,
            //     yellow: colors.amber,
            //     white: colors.white,
            // },
        }
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
