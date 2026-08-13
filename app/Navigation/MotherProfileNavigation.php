<?php

declare(strict_types=1);

class MotherProfileNavigation
{
	public static function items(int $motherId): array
	{
		$baseUrl = '/mothers/' . $motherId;

		return [
			[
				'title' => 'Overview',
				'url' => $baseUrl
			],
			[
				'title' => 'Pregnancies',
				'url' => $baseUrl . '/pregnancies'
			],
			[
				'title' => 'Clinic Visits',
				'url' => $baseUrl . '/clinic-visits'
			],
			[
				'title' => 'Field Visits',
				'url' => $baseUrl . '/field-visits'
			],
			[
				'title' => 'Supplements',
				'url' => $baseUrl . '/supplements'
			],
			// [
			// 	'title' => 'Documents',
			// 	'url' => $baseUrl . '/documents'
			// ],
			// [
			// 	'title' => 'Timeline',
			// 	'url' => $baseUrl . '/timeline'
			// ]
		];
	}
}
