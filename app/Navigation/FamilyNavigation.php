<?php

declare(strict_types=1);

class FamilyNavigation
{
	public static function items(): array
	{
		return [
			[	// Overview page for families and recent activity
				'title' => 'Overview',
				'url' => '/families'
			],
			[	// list of families in the registry
				'title' => 'Registry',
				'url' => '/families/registry'
			],
			[	// add new family form page
				'title' => 'Register',
				'url' => '/families/create'
			],
			// [  // household data
			// 	'title' => 'Households',
			// 	'url' => '/families/households'
			// ],
			[	// reports
				'title' => 'Reports',
				'url' => '/families/reports'
			]
		];
	}
}
