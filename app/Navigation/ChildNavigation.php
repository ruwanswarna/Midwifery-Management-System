<?php

declare(strict_types=1);

class ChildNavigation
{
	public static function items(): array
	{
		return [
			[	// Overview page for children and recent activity
				'title' => 'Overview',
				'url' => '/children'
			],
			[   // list of children in the registry
				'title' => 'Registry',
				'url' => '/children/registry'
			],
			[	// add new child form page
				'title' => 'Register',
				'url' => '/children/create'
			],
			[	// growth data
				'title' => 'Growth',
				'url' => '/children/growth'
			],
			[	// age observations data
				'title' => 'Observations',
				'url' => '/children/observations'
			],
			[	// vaccinations data
				'title' => 'Vaccinations',
				'url' => '/children/vaccinations'
			],
			[   // supplements data
				'title' => 'Supplements',
				'url' => '/supplements/children'
			],
			[	// reports
				'title' => 'Reports',
				'url' => '/children/reports'
			]
		];
	}
}
