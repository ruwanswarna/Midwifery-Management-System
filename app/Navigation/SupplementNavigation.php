<?php

declare(strict_types=1);

class SupplementNavigation
{
	public static function items(): array
	{
		return [
			[
				'title' => 'Overview',
				'url' => '/supplements'
			],
			[
				'title' => 'Children',
				'url' => '/supplements/children'
			],
			[
				'title' => 'Mothers',
				'url' => '/supplements/mothers'
			],
			[
				'title' => 'Due & Overdue',
				'url' => '/supplements/due'
			],
			[
				'title' => 'Reports',
				'url' => '/supplements/reports'
			]
		];
	}
}
