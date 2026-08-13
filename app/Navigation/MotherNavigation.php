<?php

declare(strict_types=1);

class MotherNavigation
{
	public static function items(): array
	{
		return [
			[
				'title' => 'Overview',
				'url' => '/mothers'
			],
			[
				'title' => 'Registry',
				'url' => '/mothers/registry'
			],
			[
				'title' => 'Pregnancies',
				'url' => '/pregnancies'
			],
			[
				'title' => 'Supplements',
				'url' => '/supplements/mothers'
			],
			// [
			// 	'title' => 'High Risk',
			// 	'url' => '/mothers/high-risk'
			// ],
			// [
			// 	'title' => 'Expected Deliveries',
			// 	'url' => '/mothers/expected-deliveries'
			// ],
			[
				'title' => 'Reports',
				'url' => '/mothers/reports'
			]
		];
	}
}
