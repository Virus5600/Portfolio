import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import basicSsl from '@vitejs/plugin-basic-ssl';
import tailwindcss from 'tailwindcss';
import 'dotenv/config';

/**
 * All resource assets to compile will be defined here.
 *
 * @type array
 */
const COMPILE_LIST = [
	// GENERAL FILES (For all pages)
	'resources/scss/app.scss',
	'resources/js/app.js',

	// UTILITY FILES
	// Confirm Leave
	'resources/js/util/confirm-leave.js',
];

/**
 * Defines the URL of the web application. If no URL is defined, it will default
 * to `localhost` value instead.
 *
 * The HOST can be defined by adding it inside a `.env` file with a
 * `APP_URL` key.
 *
 * @type string
 */
const HOST = process.env.APP_URL?.replaceAll(/https?:\/\//g, '') ?? 'localhost';

/**
 * Defines the path to where the SSL key and certificates are located. If the
 * URL is a secure URL (HTTPS) while there are no path defined, the assets
 * compiled by vite will not be loaded due to an SSL issue.
 *
 * The SSL path can be defined by adding it inside a `.env` file with a
 * `APP_SSL_PATH` key.
 *
 * @type string | undefined
 */
const SSL_PATH = process.env.APP_SSL_PATH ?? undefined;

/**
 * Contains an array of objects that contains the plugin and its condition on when to add it.
 *
 * Plugins with `condition` keys that results to true will be added while those that produces
 * `false` value will not be added.
 *
 * @type array
 */
const OPTIONAL_PLUGINS = [
	{ "value": basicSsl(), "condition": SSL_PATH == undefined }
];

/**
 * This function is the one being called when the optional plugins will be added.
 *
 * The function will iterate through the provided array, checking their conditions
 * and finally adding them to another array that will be returned.
 *
 * To inject the content of the returned value, simply add a spread operator (denoted
 * by `...`) to the returned value like shown below:
 *
 * ```javascript
 * // ...
 * {
 * 	plugins: [
 * 		...insertOptionalPlugins()
 * 	],
 * }
 * // ...
 * ```
 *
 * @returns array
 */
function insertOptionalPlugins() {
	let toInsert = [];

	for (let item of OPTIONAL_PLUGINS)
		if (item.condition)
			toInsert.push(item.value);

	return toInsert;
}

export default defineConfig({
	server: {
		host: HOST ?? undefined,
		https: SSL_PATH ? {
			cert: `${SSL_PATH}/${HOST}.crt`,
			key: `${SSL_PATH}/${HOST}.key`
		} : undefined
	},
	plugins: [
		...insertOptionalPlugins(),
		tailwindcss(),
		laravel({
			input: COMPILE_LIST,
			refresh: true,
		}),
	],
});
