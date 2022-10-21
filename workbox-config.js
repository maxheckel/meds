module.exports = {
	globDirectory: 'public/',
	globPatterns: [
		'**/*.{js,css,json,ico}'
	],
	swDest: 'public/sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};