module.exports = function ()
{
	'use strict';

	var config =
	{
		languages:
		{
			src:
			[
				'languages/en.json'
			],
			dest: 'build/parser_language.json',
			options:
			{
				remove:
				[
					'_package',
					'_index'
				]
			}
		}
	};

	return config;
};