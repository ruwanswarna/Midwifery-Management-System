<?php

declare(strict_types=1);
class FamilyController extends Controller
{
	private FamilyService $service;
	public function __construct()
	{
		parent::__construct();
		$this->service = new FamilyService();
	}
	// display families overview
	public function index(): void
	{
		$this->view->render(
			'families/index',
			[
				'title' => 'Families Overview',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => null,
				],
				'moduleNav' => FamilyNavigation::items(),
				'activeModuleNav' => '/families',
				'families' => $this->service->getAllRegistry(),
				'followupsDue' => 0,
			],

		);
	}
	// display families registry - list of families
	public function registry(): void
	{
		$queryParams = ['page' => $this->request->query('page')];
		$data = $this->service->getRegistry($queryParams);
		$this->view->render(
			'families/registry',
			[
				'title' => 'Family Registry',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					'Registry' => null,
				],
				'moduleNav' => FamilyNavigation::items(),
				'activeModuleNav' => '/families/registry',
				'families' => $data['families'],
				'pagination' => $data['pagination']
			]
		);
	}
	// display form to create a new family
	public function create(): void
	{

		$this->view->render(
			'families/create',
			[
				'title' => 'Register New Family',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					'Register' => null,
				],
				'moduleNav' => FamilyNavigation::items(),
				'activeModuleNav' => '/families/create',
				'phmAreas' => $this->service->getPHMAreas()
			]
		);
	}
	// handle the submission of the new family form
	public function store(): void
	{
		$familyData =  $this->request->post('familyData');
		$contactPersonData = $this->request->post('personData');
		[
			'family_id' => $familyId,
			'contact_person_id' => $contactPersonId,
		] = $this->service->registerFamily($familyData, $contactPersonData);
		$_COOKIE['success'] = 'Family registered successfully.';
		$this->response->redirect('/families/' . $familyId);
	}

	//display selected family profile
	public function show(int $id): void
	{
		$data = $this->service->getFamilyProfile($id);
		if ($data === null) {
			Response::notFound();
			return;
		}

		$family = $data['family'];
		$familyMembers = $data['family_members'];
		$summary = $data['summary'];
		$this->view->render(
			'families/family-profile/index',
			[
				'title' => e($family['registration_number']),
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					'Registry' => '/families/registry',
					e($family['registration_number']) => null,
				],

				'moduleNav' => FamilyProfileNavigation::items($id),
				'activeModuleNav' => '/families/' . $id,
				'family' => $family,
				'family_members' => $familyMembers,
				'summary' => $summary
			]
		);
	}
	// reports
	public function reports(): void
	{

		$this->view->render(
			'families/reports',
			[
				'title' => 'Family Reports',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					'Reports' => null,
				],
				'moduleNav' => FamilyNavigation::items(),
				'activeModuleNav' => '/families/reports',
			]
		);
	}
	public function documents(): void {}
	// display edit family profile form
	public function edit(int $id)
	{
		$family = $this->service->getById($id);
		if (!$family) {
			$this->response->notFound();
			return;
		}
		$this->view->render(
			'families/family-profile/edit',
			[
				'title' => 'Edit Family Profile',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					e($family['registration_number']) => '/families/' . $id,
					'Edit' => null,
				],
				'moduleNav' => FamilyProfileNavigation::items($id),
				'activeModuleNav' => '/families/' . $id . '/edit',
				'family' => $family,
				'phmAreas' => $this->service->getPHMAreas()
			]
		);
	}
	// update family profile
	public function update(int $id): void
	{
		if ($this->service->update($id, $_POST)) {

			$_SESSION['success'] =
				'Family updated successfully.';

			$this->response->redirect(
				APP_URL . '/families/' . $id
			);
		}

		$this->response->back();
	}
	// delete family delete family profile
	public function delete(int $id): void
	{
		if ($this->service->delete($id)) {
			$_SESSION['success'] =
				'Family deleted successfully.';

			$this->response->redirect(
				APP_URL . '/families/registry'
			);
		}

		$this->response->back();
	}

	// display households for all families
	public function households(): void
	{
		$middleware = new AuthMiddleware();
		$middleware->handle();
		$this->view->render(
			'families/households',
			[
				'title' => 'Households',
				'breadcrumbs' => [
					'Dashboard' => '/dashboard',
					'Families' => '/families',
					'Households' => null,
				],
				'moduleNav' => FamilyNavigation::items(),
				'activeModuleNav' => '/families/households',
				// 'households' => $this->service->getAllHouseholds(),
			]
		);
	}
}
