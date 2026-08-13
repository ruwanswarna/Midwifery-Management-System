<?php

declare(strict_types=1);

class PregnancyNavigation
{
	public static function items(): array
	{
		return [
			[
				'title' => 'Overview',
				'url' => '/pregnancies'
			],
			[
				'title' => 'Registry',
				'url' => '/pregnancies/registry'
			],
			[
				'title' => 'Register Pregnancy',
				'url' => '/pregnancies/create'
			],
			[
				'title' => 'High Risk',
				'url' => '/pregnancies/high-risk'
			],
			[
				'title' => 'Expected Deliveries',
				'url' => '/pregnancies/expected-deliveries'
			],
			[
				'title' => 'visits and follow-ups',
				'url' => '/pregnancies/visits'
			],
			[
				'title' => 'Birth Outcomes',
				'url' => '/pregnancies/birth-outcomes'
			],
			[
				'title' => 'Reports',
				'url' => '/pregnancies/reports'
			]
		];
	}
}
