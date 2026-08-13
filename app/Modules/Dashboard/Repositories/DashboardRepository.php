<?php
class DashboardRepository
{
	private FamilyRepository $familyRepository;
	private FamilyMemberRepository $memberRepository;
	private PregnancyRepository $pregnancyRepository;
	private ChildRepository $childRepository;
	private GrowthRepository $growthRepository;

	public function __construct()
	{
		$this->familyRepository = new FamilyRepository();
		$this->memberRepository = new FamilyMemberRepository();
		$this->pregnancyRepository = new PregnancyRepository();
		$this->childRepository = new ChildRepository();
		$this->growthRepository = new GrowthRepository();
	}

	// public function  findStatistics(string $period): array
	// {
	// 	$families = $this->familyRepository->findFamilyTrend($period);
	// 	$pregnancies = $this->pregnancyRepository->findPregnancyTrend($period);
	// 	$active = $this->pregnancyRepository->countPregnancy('active');
	// 	$children = $this->childRepository->countByAgeRange(0, 60);
	// 	$alerts = $this->growthRepository->countGrowthAlerts();
	// 	$highRisk = $this->pregnancyRepository->countPregnancy('high-risk');

	// 	$data = [
	// 		'registeredFamilies' => $families,
	// 		'registeredPregnancies' => $pregnancies,
	// 		'activePregnancies' => $active,
	// 		'children' => $children,
	// 		'growthAlerts' => $alerts,
	// 		'highRiskPregnancies' => $highRisk,
	// 	];

	// 	return $data;
	// }

	public function findStatistics2(
		?string $period = null,
		?string $category = null
	): array {
		$data = [];
		// Trends
		// Registered Families
		if ($category === null || $category === 'families') {
			$currentFamilies = $this->familyRepository->countRegistry($period);
			$previousFamilies = $this->familyRepository->countRegistry($period, true);
			$data['families']['current'] = $currentFamilies;
			$data['families']['previous'] = $previousFamilies;
		}

		// Registered Pregnancies
		if ($category === null || $category === 'pregnancies') {
			$currentPregnaancies = $this->pregnancyRepository->countPregnancy('all', $period);
			$previousPregnancies = $this->pregnancyRepository->countPregnancy('all', $period, true);
			$data['pregnancies']['current'] = $currentPregnaancies;
			$data['pregnancies']['previous'] = $previousPregnancies;
		}

		// first load only
		if ($category === null) {

			// Active Pregnancies
			$data['activePregnancies']['value'] =
				$this->pregnancyRepository->countPregnancy('active');
			$data['activePregnancies']['dueSoon'] = $this->pregnancyRepository->countDueSoon(14); // within 14 days

			// Children
			$childrenCountPeriod = 'month';
			$data['children']['value'] = $this->childRepository->countByAgeRange(0, 60);
			$data['children']['registeredCount']['value'] = $this->childRepository->countByRegisteredDate($childrenCountPeriod);
			$data['children']['registeredCount']['period'] = 'this ' . $childrenCountPeriod;


			// Growth Alerts
			$growthAlertsPeriod = 'week';
			$data['growthAlerts']['value'] =
				$this->growthRepository->countGrowthAlerts();
			$data['growthAlerts']['newCases'] =
				$this->growthRepository->countGrowthAlerts($growthAlertsPeriod);

			// High-Risk Pregnancies
			$data['highRiskPregnancies']['value'] =
				$this->pregnancyRepository->countPregnancy('high-risk');
			$data['highRiskPregnancies']['needFollowup'] =
				$this->pregnancyRepository->countHighRiskFollowup();
		}
		return $data;
	}

	// public function findTrendStatistics(string $category, string $period): array
	// {
	// 	$families = [];
	// 	$pregnancies = [];
	// 	if ($category === 'families') {
	// 		$families = $this->familyRepository->findFamilyTrend($period);
	// 		return [
	// 			'registeredFamilies' => $families,
	// 		];
	// 	} else if ($category === 'pregnancies') {
	// 		$pregnancies = $this->pregnancyRepository->findPregnancyTrend($period);
	// 		return [
	// 			'registeredPregnancies' => $pregnancies
	// 		];
	// 	} else return [];
	// 	// return [
	// 	// 	'registeredFamilies' => $families,
	// 	// 	'registeredPregnancies' => $pregnancies
	// 	// ];
	// }

	public function findRecentActivity(int $limitDays): array
	{	// get recent records from famuily then get family members for each family 
		$family = $this->familyRepository->findRecentActivity($limitDays) ?? [];
		if (!empty($family)) {
			foreach ($family as &$f) {
				$members = $this->memberRepository->findAllByFamilyId($f['family_id'], ['Mother', 'Father', 'Spouse', 'Guardian']) ?? [];
				$memberArray = [];
				foreach ($members as $member) {
					$memberArray[] = [
						'person_id' => $member['person_id'],
						'first_name' => $member['first_name'],
						'middle_name' => $member['middle_name'],
						'last_name' => $member['last_name'],
						'gender' => $member['gender'],
						'date_of_birth' => $member['date_of_birth'],
					];
				}
				$f['members'] = $memberArray;
			}
		}
		// get recent records from pregnancy repository
		$pregnancy = $this->pregnancyRepository->findRecentActivity($limitDays) ?? [];
		// get recent records from child repository
		$child = $this->childRepository->findRecentActivity($limitDays) ?? [];
		$activities = ['family' => $family, 'pregnancy' => $pregnancy, 'child' => $child];
		//TEST 
		//dd($activities);
		return $activities;
	}

	public function findRequiredAttention(): array
	{
		return [];
	}

	public function findClinicSchedule(): array
	{
		return [];
	}

	public function findUpcomingFollowups(): array
	{
		return [];
	}

	public function findUpcomingBirths(): array
	{
		return [];
	}

	public function findChartData(): array
	{
		return [];
	}
}
