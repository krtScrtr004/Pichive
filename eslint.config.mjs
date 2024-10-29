import globals from 'globals'
import pluginJs from '@eslint/js'

export default [
	{ languageOptions: { globals: { ...globals.browser, ...globals.node } } },
	pluginJs.configs.recommended,
	{
		rules: {
			'no-unused-vars': 1,
			'no-undef': 2,
			'no-use-before-define': 1,
			'no-unused-expressions': 1,
			'no-var': 2,
			'prefer-const': 1,
			'no-multi-spaces': 1,
			'no-shadow': 2,
			'no-redeclare': 2,
			eqeqeq: [2, 'always'],
			quotes: [1, 'single'],
			semi: [0, 'always'],
			indent: [2, 'space'],
			curly: 2,
		},
	},
]
