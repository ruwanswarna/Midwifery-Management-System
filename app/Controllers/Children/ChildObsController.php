<?php

declare(strict_types=1);

class ChildObsController extends Controller
{
    private ChildObsService $service;
    private ChildService $childService;
    public function __construct()
    {
        parent::__construct();
        $this->service = new ChildObsService();
        $this->childService = new ChildService();
    }

    public function index(): void
    {
        $this->view->render(
            'children/age-observations',
            [
                'title' => 'Child Development Observations',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Children' => '/children',
                    'Observations' => null
                ],
                'moduleNav' => ChildNavigation::items(),
                'activeModuleNav' => '/children/observations',
                'observations' => $this->service->getAll(),
                'alerts' => $this->service->getAlerts()
            ]
        );
    }

    public function show(int $childId): void
    {
        $child = $this->childService->findById($childId);
        if ($child === null) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'children/child-profile/observations/show',
            [
                'title' => 'Development Observations',
                'breadcrumbs' =>
                [
                    'Dashboard' => '/dashboard',
                    'Children' => '/children',
                    $child['full_name'] => "/children/{$childId}",
                    'Observations' => null
                ],
                'moduleNav' => ChildProfileNavigation::items($childId),
                'activeModuleNav' => "/children/{$childId}/observations",
                'child' => $child,
                'observations' => $this->service->getObservationsByChildId($childId),
                'milestones' => $this->service->getMilestones(),
            ]
        );
    }

    public function create(int $childId): void
    {
        $child = $this->childService->findById($childId);
        if ($child === null) {
            Response::notFound();
            return;
        }
        $this->form('children/child-profile/observations/create', 'Record Development Observation', $childId, ['child' => $child] + $this->service->formOptions());
    }

    public function store(int $childId): void
    {
        if ($this->service->addObservation($childId, $this->request->all()) === null) $this->response->redirect(APP_URL . "/children/{$childId}/observations/create");
        unset($_SESSION['observationData']);
        $_SESSION['success'] = 'Development observation recorded successfully.';
        $this->response->redirect(APP_URL . "/children/{$childId}/observations");
    }

    public function edit(int $childId, int $observationId): void
    {
        $child = $this->childService->findById($childId);
        $record = $this->service->findRecord($childId, $observationId);
        if ($child === null || $record === null) {
            Response::notFound();
            return;
        }
        $this->form('children/child-profile/observations/edit', 'Edit Development Observation', $childId, ['child' => $child, 'record' => $record] + $this->service->formOptions());
    }

    public function update(int $childId, int $observationId): void
    {
        if (!$this->service->updateObservation($childId, $observationId, $this->request->all())) $this->response->redirect(APP_URL . "/children/{$childId}/observations/{$observationId}/edit");
        unset($_SESSION['observationData']);
        $_SESSION['success'] = 'Development observation updated successfully.';
        $this->response->redirect(APP_URL . "/children/{$childId}/observations");
    }

    private function form(string $view, string $title, int $childId, array $data): void
    {
        $this->view->render(
            $view,
            [
                'title' => $title,
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Children' => '/children',
                    'Child Details' => "/children/{$childId}",
                    'Observations' => "/children/{$childId}/observations",
                    $title => null
                ],
                'moduleNav' => ChildProfileNavigation::items($childId),
                'activeModuleNav' => "/children/{$childId}/observations"
            ] + $data
        );
    }
}
