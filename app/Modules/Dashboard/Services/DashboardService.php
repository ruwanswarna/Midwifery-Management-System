<?php

final class DashboardService
{
	private DashboardRepository $repository;

	public function __construct()
	{
		$this->repository = new DashboardRepository();
	}

	public function getDashboardStatistics2(?string $period = null, ?string $category = null): array
	{
		$rawData = $this->repository->findStatistics2($period, $category);

		$data = [];
		if (isset($rawData['families'])) {
			$data['families'] = [
				'value' => $rawData['families']['current'],
				'period' => $category === 'families' ? $period : 'month',
				'trend' => $this->calculateTrend(
					$rawData['families']['current'],
					$rawData['families']['previous'],
					$period
				)
			];
		}

		if (isset($rawData['pregnancies'])) {
			$data['pregnancies'] = [
				'value' => $rawData['pregnancies']['current'],
				'period' => $category === 'pregnancies' ? $period : 'month',
				'trend' => $this->calculateTrend(
					$rawData['pregnancies']['current'],
					$rawData['pregnancies']['previous'],
					$period
				)
			];
		}

		if (isset($rawData['activePregnancies'])) {
			$data['activePregnancies'] = $rawData['activePregnancies'];
		}

		if (isset($rawData['children'])) {
			$data['children'] = $rawData['children'];
		}

		if (isset($rawData['growthAlerts'])) {
			$data['growthAlerts'] = $rawData['growthAlerts'];
		}

		if (isset($rawData['highRiskPregnancies'])) {
			$data['highRiskPregnancies'] = $rawData['highRiskPregnancies'];
		}
		//dd($data);
		return $data;
	}

	// public function getTrendStatistics(string $category, String $period = 'month'): array
	// {
	// 	return $this->repository->findTrendStatistics($category, $period);
	// }

	public function getRecentActivity(int $limitDays): array
	{
		$data =  $this->repository->findRecentActivity($limitDays);

		$activities = [];
		// Format the family activity data for display
		// Family activities
		foreach ($data['family'] ?? [] as $family) {
			//TEST
			//dd($family);
			$activities[] = [
				'type' => 'Family',
				'reference' => $family['registration_number'],
				'description' => $this->formatFamilyName(
					$family['members'] ?? []
				) . ' - ' . $family['address'],
				'date_group' => $this->getDateGroup(
					//$family['registered_date']
					$family['created_at'] ?? $family['registered_date']
				),
				'time' => $this->formatActivityDate(
					$family['created_at'] ?? $family['registered_date']
				),
				'url' => APP_URL . '/families/' . $family['family_id'],

				// Internal value used for sorting
				'_date' => $family['created_at'] ?? $family['registered_date'],
			];
		}

		// Pregnancy activities
		foreach ($data['pregnancy'] ?? [] as $pregnancy) {
			//TEST
			//dd($pregnancy);
			$activities[] = [
				'type' => 'Pregnancy',
				'reference' => $pregnancy['registration_number'],
				'description' => $this->formatPersonName($pregnancy) .
					' (' . $pregnancy['nic'] . ') - EDD: ' . $pregnancy['expected_delivery_date'],
				'date_group' => $this->getDateGroup(
					$pregnancy['created_at'] ?? $pregnancy['registered_date']
				),
				'time' => $this->formatActivityDate(
					$pregnancy['created_at'] ?? $pregnancy['registered_date']
				),
				'url' => APP_URL . '/pregnancies/' . $pregnancy['pregnancy_id'],

				'_date' => $pregnancy['created_at'] ?? $pregnancy['registered_date'],
			];
		}

		// Child activities
		foreach ($data['child'] ?? [] as $child) {
			//TEST
			//dd($child);
			$activities[] = [
				'type' => 'Child',
				'reference' => $child['registration_number'],
				'description' => $this->formatPersonName($child) . ' (' . $child['birth_weight'] . 'kg) - At birth',
				'date_group' => $this->getDateGroup(
					$child['created_at'] ?? $child['registered_date']
				),
				'time' => $this->formatActivityDate(
					$child['created_at'] ?? $child['registered_date']
				),
				'url' => APP_URL . '/children/' . $child['person_id'],

				'_date' => $child['created_at'] ?? $child['registered_date'],
			];
		}

		// Newest activity first
		usort(
			$activities,
			fn($a, $b) => strtotime($b['_date']) <=> strtotime($a['_date'])
		);

		// Remove internal sorting field
		foreach ($activities as &$activity) {
			unset($activity['_date']);
		}
		//TEST
		//dd($activities);
		return $activities;
	}

	public function getAttentionRequired(): array
	{

		return $this->repository->findRequiredAttention();
	}

	public function getClinicSchedule(): array
	{
		return $this->repository->findClinicSchedule();
	}

	public function getUpcomingBirths(): array
	{
		return $this->repository->findUpcomingBirths();
	}

	public function getUpcomingFollowups(): array
	{
		return $this->repository->findUpcomingFollowups();
	}

	public function getChartData(): array
	{
		return $this->repository->findChartData();
	}

	private function calculateTrend(
		int $current,
		int $previous,
		string $period
	): array {
		$difference = $current - $previous;
		$percentage = $previous === 0 ? 0 : ($difference / $previous) * 100;


		return [

			'value' => abs($difference),
			'percentage' => round($percentage, 1),
			'direction' => $difference >= 0 ? 'up' : 'down',
			'period' => $period !== 'all' ? match ($period) {
				'week' => 'previous week',
				'month' => 'previous month',
				'year' => 'previous year',
			} : ''
		];
	}

	private function formatFamilyName(array $members): string
	{
		$names = [];
		foreach ($members as $member) {
			$names[] = $this->formatPersonName($member);
		}
		return implode(' & ', $names);
	}

	private function formatPersonName(array $person): string
	{
		$name = $person['first_name'];
		if (!empty($person['middle_name'])) {
			$name .= ' ' . mb_substr($person['middle_name'], 0, 1) . '.';
		}
		if (!empty($person['last_name'])) {
			$name .= ' ' . $person['last_name'];
		}
		return $name;
	}

	private function getDateGroup(string $date): string
	{
		$date = date('Y-m-d', strtotime($date));
		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', strtotime('-1 day'));

		if ($date === $today) {
			return 'Today';
		}

		if ($date === $yesterday) {
			return 'Yesterday';
		}

		return 'Earlier';
	}

	private function formatActivityDate(string $date): string
	{
		$timestamp = strtotime($date);

		if (date('Y-m-d', $timestamp) === date('Y-m-d')) {
			return date('h:i A', $timestamp);
		}

		if (date('Y-m-d', $timestamp) === date('Y-m-d', strtotime('-1 day'))) {
			return date('h:i A', $timestamp);
		}

		return date('d M Y', $timestamp);
	}
}
