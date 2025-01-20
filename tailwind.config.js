import colors from 'tailwindcss/colors';
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

import flowbite from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
	content: [
		'./app/**/*.php',
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./node_modules/flowbite/**/*.js',
		'./resources/**/*.blade.php',
		'./resources/**/*.js',
		'./resources/**/*.scss',
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['Figtree', ...defaultTheme.fontFamily.sans],
			},
		},
		colors: {
			...colors,

			primary: 'rgb(var(--tw-rgb-primary) / <alpha-value>)',
			secondary: 'rgb(var(--tw-rgb-secondary) / <alpha-value>)',
			accent: 'rgb(var(--tw-rgb-accent) / <alpha-value>)',

			success: 'rgb(var(--tw-rgb-success) / <alpha-value>)',
			error: 'rgb(var(--tw-rgb-error) / <alpha-value>)',
			warning: 'rgb(var(--tw-rgb-warning) / <alpha-value>)',
			info: 'rgb(var(--tw-rgb-info) / <alpha-value>)',

			text: 'rgb(var(--tw-rgb-color) / <alpha-value>)',
			body: 'rgb(var(--tw-rgb-bg) / <alpha-value>)',
		}
	},
	plugins: [
		forms,
		flowbite
	],
	darkMode: [
		'variant',
		[
			'@media (prefers-color-scheme: dark) { &:not(.light, .light *, [data-tw-theme="light"], [data-tw-theme="light"] *) }',
			'&:where([data-tw-theme="dark"], [data-tw-theme="dark"] *)',
		]
	]
};
