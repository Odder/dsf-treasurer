/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: colors.blue,
                secondary: colors.slate,
                dark: colors.gray,
                green: colors.emerald,
            },
        },
    },
    plugins: [],
};
