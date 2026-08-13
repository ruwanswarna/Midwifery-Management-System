<?php

declare(strict_types=1);

class ChildController extends Controller
{
    private ChildService $service;
    public function __construct() { parent::__construct(); $this->service = new ChildService(); }

    public function index(): void
    {
        $data = $this->service->overview();
        $this->render('children/index', 'Children Overview', '/children', [
            'children' => $data['children'], 'statistics' => $data['statistics'],
        ]);
    }

    public function registry(): void
    {
        $search = (string) $this->request->query('search', '');
        $children = $this->service->getAll($search);
        $this->render('children/registry', 'Children Registry', '/children/registry', [
            'children' => $children, 'search' => $search,
        ], ['Registry' => null]);
    }

    public function create(): void
    {
        $this->render('children/create', 'Register Child', '/children/create', $this->service->formOptions(), ['Register Child' => null]);
    }

    public function store(): void
    {
        $data = $this->request->all();
        if (!$this->service->create($data)) { $this->response->redirect(APP_URL . '/children/create'); }
        unset($_SESSION['childData']);
        $_SESSION['success'] = 'Child health record registered successfully.';
        $this->response->redirect(APP_URL . '/children/' . (int) $data['person_id']);
    }

    public function show(int $id): void
    {
        $child = $this->service->findById($id);
        if ($child === null) { Response::notFound(); return; }
        $this->render('children/child-profile/show', $child['full_name'], "/children/{$id}", [
            'child' => $child,
            'growthRecords' => (new GrowthService())->getByChildId($id),
            'vaccinationSchedule' => (new ImmunizationService())->getScheduleForChild($id),
            'observations' => (new ChildObsService())->getObservationsByChildId($id),
            'supplements' => (new SupplimentDistService())->getByPerson($id),
        ], [$child['full_name'] => null], true, $id);
    }

    public function edit(int $id): void
    {
        $child = $this->service->findById($id);
        if ($child === null) { Response::notFound(); return; }
        $options = $this->service->formOptions();
        $options['child'] = $child;
        $this->render('children/child-profile/edit', 'Edit Child Health Record', "/children/{$id}", $options, [$child['full_name'] => "/children/{$id}", 'Edit' => null], true, $id);
    }

    public function update(int $id): void
    {
        if (!$this->service->update($id, $this->request->all())) { $this->response->redirect(APP_URL . "/children/{$id}/edit"); }
        unset($_SESSION['childData']);
        $_SESSION['success'] = 'Child health record updated successfully.';
        $this->response->redirect(APP_URL . "/children/{$id}");
    }

    public function archive(int $id): void
    {
        if ($this->service->archive($id)) {
            $_SESSION['success'] = 'Child record archived.';
        }
        $this->response->redirect(APP_URL . '/children/registry');
    }

    public function reports(): void
    {
        $data = $this->service->overview();
        $this->render('children/reports', 'Children Reports', '/children/reports', $data, ['Reports' => null]);
    }

    public function byFamily(int $id): void
    {
        $family = (new FamilyRepository())->findById($id);
        if ($family === null) { Response::notFound(); return; }
        $this->view->render('families/family-profile/children/index', [
            'title' => 'Children in ' . $family['registration_number'],
            'breadcrumbs' => ['Dashboard' => '/dashboard', 'Families' => '/families', $family['registration_number'] => '/families/' . $id, 'Children' => null],
            'moduleNav' => FamilyProfileNavigation::items($id),
            'activeModuleNav' => '/families/' . $id . '/children',
            'family' => $family,
            'children' => $this->service->getByFamily($id),
        ]);
    }

    private function render(string $view, string $title, string $active, array $data = [], array $tail = [], bool $profile = false, int $id = 0): void
    {
        $breadcrumbs = ['Dashboard' => '/dashboard', 'Children' => '/children'] + $tail;
        $this->view->render($view, ['title' => $title, 'breadcrumbs' => $breadcrumbs,
            'moduleNav' => $profile ? ChildProfileNavigation::items($id) : ChildNavigation::items(),
            'activeModuleNav' => $active] + $data);
    }
}
