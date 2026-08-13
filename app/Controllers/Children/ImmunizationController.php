<?php

declare(strict_types=1);

class ImmunizationController extends Controller
{
    private ImmunizationService $service;
    private ChildService $childService;
    public function __construct()
    {
        parent::__construct();
        $this->service = new ImmunizationService();
        $this->childService = new ChildService();
    }

    public function index(): void
    {
        $this->summary('children/immunization-overview', 'Child Immunizations');
    }
    public function indexVaccinationSummary(): void
    {
        $this->summary('vaccinations/index', 'Vaccination Summary');
    }

    private function summary(string $view, string $title): void
    {
        $this->view->render($view, [
            'title' => $title,
            'breadcrumbs' => [
                'Dashboard' => '/dashboard',
                'Children' => '/children',
                'Immunizations' => null
            ],
            'moduleNav' => ChildNavigation::items(),
            'activeModuleNav' => '/children/vaccinations',
            'records' => $this->service->getAll(),
            'statistics' => $this->service->getStatistics(),
            'dueChildren' => $this->service->getDueChildren(),
            'alerts' => $this->service->getAlerts()
        ]);
    }

    public function childrenDueVaccinations(): void
    {
        $this->view->render('vaccinations/children-due', [
            'title' => 'Vaccinations Due and Overdue',
            'breadcrumbs' => [
                'Dashboard' => '/dashboard',
                'Children' => '/children',
                'Immunizations' => '/children/vaccinations',
                'Due' => null
            ],
            'moduleNav' => ChildNavigation::items(),
            'activeModuleNav' => '/children/vaccinations',
            'children' => $this->service->getDueChildren()
        ]);
    }

    public function childrenWithAlerts(): void
    {
        $this->view->render('vaccinations/children-alerts', [
            'title' => 'Vaccination Alerts',
            'breadcrumbs' => [
                'Dashboard' => '/dashboard',
                'Children' => '/children',
                'Immunizations' => '/children/vaccinations',
                'Alerts' => null
            ],
            'moduleNav' => ChildNavigation::items(),
            'activeModuleNav' => '/children/vaccinations',
            'alerts' => $this->service->getAlerts()
        ]);
    }

    public function show(int $childId): void
    {
        $child = $this->childService->findById($childId);
        if ($child === null) {
            Response::notFound();
            return;
        }
        $this->view->render('children/child-profile/immunization/show', [
            'title' => 'Child Immunizations',
            'breadcrumbs' => [
                'Dashboard' => '/dashboard',
                'Children' => '/children',
                $child['full_name'] => "/children/{$childId}",
                'Immunizations' => null
            ],
            'moduleNav' => ChildProfileNavigation::items($childId),
            'activeModuleNav' => "/children/{$childId}/vaccinations",
            'child' => $child,
            'schedule' => $this->service->getScheduleForChild($childId),
            'records' => $this->service->getByChildId($childId)
        ]);
    }

    public function create(int $childId): void
    {
        $child = $this->childService->findById($childId);
        if ($child === null) {
            Response::notFound();
            return;
        }
        $this->form('children/child-profile/immunization/create', 'Record Vaccination', $childId, ['child' => $child] + $this->service->formOptions());
    }

    public function store(int $childId): void
    {
        if ($this->service->create($childId, $this->request->all()) === null) $this->response->redirect(APP_URL . "/children/{$childId}/vaccinations/create");
        unset($_SESSION['vaccinationData']);
        $_SESSION['success'] = 'Vaccination recorded successfully.';
        $this->response->redirect(APP_URL . "/children/{$childId}/vaccinations");
    }

    public function edit(int $childId, int $recordId): void
    {
        $child = $this->childService->findById($childId);
        $record = $this->service->findRecord($childId, $recordId);
        if ($child === null || $record === null) {
            Response::notFound();
            return;
        }
        $this->form('children/child-profile/immunization/edit', 'Edit Vaccination', $childId, ['child' => $child, 'record' => $record] + $this->service->formOptions());
    }

    public function update(int $childId, int $recordId): void
    {
        if (!$this->service->update($childId, $recordId, $this->request->all())) $this->response->redirect(APP_URL . "/children/{$childId}/vaccinations/{$recordId}/edit");
        unset($_SESSION['vaccinationData']);
        $_SESSION['success'] = 'Vaccination record updated successfully.';
        $this->response->redirect(APP_URL . "/children/{$childId}/vaccinations");
    }

    private function form(string $view, string $title, int $childId, array $data): void
    {
        $this->view->render($view, ['title' => $title, 'breadcrumbs' => ['Dashboard' => '/dashboard', 'Children' => '/children', 'Child Details' => "/children/{$childId}", 'Immunizations' => "/children/{$childId}/vaccinations", $title => null], 'moduleNav' => ChildProfileNavigation::items($childId), 'activeModuleNav' => "/children/{$childId}/vaccinations"] + $data);
    }
}
