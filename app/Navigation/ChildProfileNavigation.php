<?php

declare(strict_types=1);

class ChildProfileNavigation
{
	public static function items(int $childId): array
	{
		$baseUrl = '/children/' . $childId;

		return [
			[	// Overview page for a specific child
				'title' => 'Overview',
				'url' => $baseUrl
			],
			[  // growth data for a specific child
				'title' => 'Growth',
				'url' => $baseUrl . '/growth'
			],
			[	// age observations data for a specific child
				'title' => 'Observations',
				'url' => $baseUrl . '/observations'
			],
			[	// vaccinations data for a specific child
				'title' => 'Vaccinations',
				'url' => $baseUrl . '/vaccinations'
			],
			[	// supplements data for a specific child
				'title' => 'Supplements',
				'url' => $baseUrl . '/supplements'
			]
		];
	}
}
// The child overview can show family and guardianship summaries with links to the Family module
