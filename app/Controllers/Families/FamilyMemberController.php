<?php

declare(strict_types=1);

class FamilyMemberController extends Controller
{
	private FamilyMemberService $memberService;
	public function __construct()
	{
		parent::__construct();
		$this->memberService = new FamilyMemberService();
	}

	// List members of selected family
	public function index(int $familyId): void
	{
		// Validate family existence
		$family = $this->memberService->getFamilyById($familyId);

		if (!$family) {
			$this->response->notFound();
			return;
		}
		$familyMembers = $this->memberService->getAllFamilyMembers($familyId);



		$this->view->render(
			'families/family-profile/members/index',
			[
				'title' => 'Family Members',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					e($family['registration_number']) => '/families/' . $familyId,
					'Members' => null,

				],
				'moduleNav' => FamilyProfileNavigation::items($familyId),
				'activeModuleNav' => '/families/' . $familyId . '/members',
				'familyId' => $familyId,
				'familyMembers' => $familyMembers
			]
		);
	}

	// display family member profile
	public function show(int $familyId, int $memberId): void
	{
		$family = $this->memberService->getFamilyById($familyId);
		if (!$family) {
			$this->response->notFound();
			return;
		}
		$familyMember = $this->memberService->getFamilyMemberById($memberId);
		if (!$familyMember) {
			$this->response->notFound();
			return;
		}
		$this->view->render(
			'families/family-profile/members/show',
			[
				'title' => 'Family Member Profile',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					e($family['registration_number']) => '/families/' . $familyId,
					'Members' => '/families/' . $familyId . '/members',
					e($familyMember['first_name']) . ' ' . e($familyMember['last_name']) => null,
				],
				'moduleNav' => FamilyProfileNavigation::items($familyId),
				'activeModuleNav' => '/families/' . $familyId . '/members',
				'familyId' => $familyId,
				'familyMember' => $familyMember
			]
		);
	}

	// display create family member form
	public function create(int $familyId): void
	{

		$family = $this->memberService->getFamilyById($familyId);
		if (!$family) {
			$this->response->notFound();
			return;
		}

		$personRoles = $this->memberService->getPersonRoles();

		$this->view->render(
			'families/family-profile/members/create',
			[
				'title' => 'Register Family Member',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					e($family['registration_number']) => '/families/' . $familyId,
					'Add Member' => null,
				],
				'moduleNav' => FamilyProfileNavigation::items($familyId),
				'activeModuleNav' => '/families/' . $familyId . '/members',
				'familyId' => $familyId,
				'personRoles' => $personRoles
			]

		);
	}
	// Add family member to family 
	public function store(int $familyId): void
	{
		$personData = $this->request->post('personData');
		$rowCount = $this->memberService->registerFamilyMember($familyId, $personData);

		if ($rowCount !== 1) {

			$_COOKIE['error'] = 'Failed to register family member.';
			$_COOKIE['personData'] = $personData;
			$this->response->redirect('/families/' . $familyId . '/members/create');
		} else {
			$_COOKIE['success'] = 'Family member registered successfully.';
			$this->response->redirect('/families/' . $familyId . '/members/' . $personData['person_id']);
		}
	}

	// display edit family member form
	public function edit(int $familyId, int $memberId): void
	{
		$family = $this->memberService->getFamilyById($familyId);
		if (!$family) {
			$this->response->notFound();
			return;
		}
		if (!$this->memberService->isMemberOfFamily($memberId, $familyId)) {
			$this->response->notFound();
			return;
		}
		$personRoles = $this->memberService->getPersonRoles();

		$currentMemberData = $this->memberService->getFamilyMemberById($memberId);

		$this->view->render(
			'families/family-profile/members/edit',
			[
				'title' => 'Edit Family Member',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					e($family['registration_number']) => '/families/' . $familyId,
					'Members' => '/families/' . $familyId . '/members',
					e($currentMemberData['person_id']) => '/families/' . $familyId . '/members/' . $memberId,
					'Edit Member' => null,
				],
				'moduleNav' => FamilyProfileNavigation::items($familyId),
				'activeModuleNav' => '/families/' . $familyId . '/members',
				'familyId' => $familyId,
				'personRoles' => $personRoles,
				'currentMemberData' => $currentMemberData
			],


		);
	}
	// Update member relationship, household-head status, etc.
	public function update(int $familyId, int $memberId): void
	{

		$personData = $this->request->post('personData');

		$rowCount = $this->memberService->updateFamilyMember($memberId, $personData);

		if ($rowCount < 0) {

			$_COOKIE['error'] = 'Failed to update family member.';
			$_COOKIE['personData'] = $personData;
			$this->response->redirect('/families/' . $familyId . '/members/' . $memberId . '/edit');
		} else {
			$_COOKIE['success'] = 'Family member updated successfully.';
			$this->response->redirect('/families/' . $familyId . '/members/' . $memberId);
		}
	}
	// End or delete a family member from the family 
	public function remove(int $familyId, int $memberId): void
	{

		// Implement the logic to end or delete a family member from the family
	}
}
