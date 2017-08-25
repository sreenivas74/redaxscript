module.exports = function ()
{
	'use strict';

	var config =
	{
		modules:
		{
			src:
			[
				'modules/*/assets/images/*.svg'
			],
			expand: true
		},
		templates:
		{
			src:
			[
				'templates/*/assets/images/*.svg'
			],
			expand: true
		},
		options:
		{
			plugins:
			[
				{
					removeViewBox: false
				}
			]
		}
	};

	return config;
};