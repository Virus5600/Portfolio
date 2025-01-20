import { defineConfig } from 'vite';
import { qrcode } from 'vite-plugin-qrcode';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import laravel from 'laravel-vite-plugin';
import basicSsl from '@vitejs/plugin-basic-ssl';
import tailwindcss from 'tailwindcss';
import 'dotenv/config';


/**
 * Contains all paths that will be used in this configuration file.
 * @type object
 */
const PATHS = (() => {
	const toRet = {};

	toRet.BASE = `node_modules`;
	toRet.fontawesome = `${toRet.BASE}/@fortawesome/fontawesome-free`;

	return toRet;
})();

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
	'resources/js/util/confirm-leave.js',
	'resources/js/util/swal-flash.js',
];

/**
 * All resource assets that will be copied to the public directory will be defined here.
 * Each item should be their own object, containing a `src` and `dest` keys. The
 * `src` key will be the source file or directory to copy from, while the `dest`
 * will be the destination directory to copy the source file or directory to.
 *
 * The format of the object will be as follows:
 * ```
 * {
 * 	src: 'source-file-or-directory',
 * 	dest: 'destination-directory'
 * }
 * ```
 * @type array
 */
const COPY_LIST = [
	{ src: `${PATHS.fontawesome}/webfonts`, dest: `../storage/fonts/fontwesome/webfonts` }
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
 * Defines the app's SSL certificate.
 *
 * The SSL certificate can be defined by adding it inside a `.env` file with a
 * `APP_CERT` key.
 *
 * @type string | undefined
 */
const APP_CERT = process.env.APP_CERT ?? undefined;

/**
 * Defines the app's SSL certificate's key.
 *
 * The SSL certificate key can be defined by adding it inside a `.env` file with a
 * `APP_CERT_KEY` key.
 *
 * @type string | undefined
 */
const APP_CERT_KEY = process.env.APP_CERT_KEY ?? undefined;

/**
 * Contains an array of objects that contains the plugin and its condition on when to add it.
 *
 * Plugins with `condition` keys that results to true will be added while those that produces
 * `false` value will not be added.
 *
 * @type array
 */
const OPTIONAL_PLUGINS = [
	{ "value": basicSsl(), "condition": [undefined, "basicSsl"].includes(SSL_PATH) && HOST.includes('https') },
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

/**
 * The manual chunking strategy that Vite will use to chunk the assets. Useful for
 * lowering the asset bundles' size and thus, improving the performance of the web
 * application.
 *
 * Each chunk will be named based on the returned string value. If there's no
 * returned value, the current `id` won't be chunked.
 *
 * @param {string} id The chunk ID. The node module path.
 * @returns {void | string} The chunk's name.
 */
function manualChunkingStrategy(id) {
	if (id.includes('fontawesome'))
		if (id.includes('solid'))
			return 'fontawesome-solid';
		else if (id.includes('regular'))
			return 'fontawesome-regular';
		else if (id.includes('brands'))
			return 'fontawesome-brands';
		else
			return 'fontawesome';
	else if (id.includes('flowbite'))
		return 'flowbite';
}

export default defineConfig({
	server: {
		host: HOST ?? undefined,
		https: (SSL_PATH && SSL_PATH != "basicSsl" && APP_CERT && APP_CERT_KEY) ? {
			cert: `${SSL_PATH}/${APP_CERT}`,
			key: `${SSL_PATH}/${APP_CERT_KEY}`
		} : undefined,
	},
	plugins: [
		...insertOptionalPlugins(),
		tailwindcss(),
		qrcode(),
		laravel({
			input: COMPILE_LIST,
			refresh: true,
		}),
		viteStaticCopy({
			targets: COPY_LIST,
		})
	],
	build: {
		chunkSizeWarningLimit: 1024, // Actual is just 600KB. Upped to 1MB.
		rollupOptions: {
			output: {
				manualChunks: manualChunkingStrategy
			}
		}
	}
});
