import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/ts/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    '50': '#eefbf3',
                    '100': '#d6f5e1',
                    '200': '#b1e9c8',
                    '300': '#7dd8a8',
                    '400': '#48bf84', // def
                    '500': '#25a469',
                    '600': '#178454',
                    '700': '#136946',
                    '800': '#115438',
                    '900': '#0f4530',
                    '950': '#07271b',
                },
                secondary: {
                    '50': '#f6f6f6',
                    '100': '#e7e7e7',
                    '200': '#d1d1d1',
                    '300': '#b0b0b0',
                    '400': '#888888',
                    '500': '#6d6d6d',
                    '600': '#5d5d5d',
                    '700': '#4f4f4f',
                    '800': '#454545', // def
                    '900': '#3d3d3d',
                    '950': '#262626',
                },
                dark: {
                    '50': '#f0f4fd',
                    '100': '#e4ebfb',
                    '200': '#cedaf7',
                    '300': '#b0c1f1',
                    '400': '#90a0e9',
                    '500': '#7581df',
                    '600': '#5a5fd1',
                    '700': '#4a4cb8',
                    '800': '#3e4195',
                    '900': '#383b77',
                    '950': '#1f2041', //def
                },
                dark_primary: {
                    '50': '#f1f2fc',
                    '100': '#e6e6f9',
                    '200': '#d3d2f3',
                    '300': '#b8b6eb',
                    '400': '#a098e1',
                    '500': '#8e7fd5',
                    '600': '#7e65c6',
                    '700': '#6d55ad',
                    '800': '#59478c',
                    '900': '#4b3f72', // def
                    '950': '#2c2442',
                },
                dark_secondary: {
                    '50': '#f6f6f6',
                    '100': '#e7e7e7',
                    '200': '#d1d1d1',
                    '300': '#b0b0b0',
                    '400': '#888888',
                    '500': '#6d6d6d',
                    '600': '#5d5d5d',
                    '700': '#4f4f4f',
                    '800': '#454545', // def
                    '900': '#3d3d3d',
                    '950': '#262626',
                },
                danger: {
                    '50': '#fbf6f5',
                    '100': '#f8eceb',
                    '200': '#f1dada',
                    '300': '#e6bbbc',
                    '400': '#d79597',
                    '500': '#c1666b', //def
                    '600': '#ae505a',
                    '700': '#913f49',
                    '800': '#7a3742',
                    '900': '#69323d',
                    '950': '#39181d',
                },

            },
            keyframes: {
                progress: {
                '0%': { width: '0%' },
                '100%': { width: '100%' },
                },
            },
            animation: {
                progress: 'progress 2s ease forwards',
            }
        },
    },

    plugins: [forms, typography],
};
