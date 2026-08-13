<?php

declare(strict_types=1);

class GrowthController extends Controller
{
    private GrowthService $growthService;
    private ChildService $childService;
    public function __construct()
    {
        parent::__construct();
        $this->growthService = new GrowthService();
        $this->childService = new ChildService();
    }

    public function index(): void
    {
        $this->overview('children/growth-monitoring', 'Growth Monitoring');
    }
    public function indexGrowthSummary(): void
    {
        $this->overview('growth/index', 'Growth Summary');
    }

    private function overview(string $view, string $title): void
    {
        $this->view->render($view, [
            'title' => $title,
            'breadcrumbs' => [
                'Dashboard' => '/dashboard',
                'Children' => '/children',
                $title => null
            ],
            'moduleNav' => ChildNavigation::items(),
            'activeModuleNav' => '/children/growth',
            'growthRecords' => $this->growthService->getAll(),
            'statistics' => $this->growthService->getStatistics(),
            'dueChildren' => $this->growthService->getDueChildren(),
            'alerts' => $this->growthService->getActiveAlerts()
        ]);
    }

    public function childrenDueMeasurement(): void
    {
        $this->view->render(
            'growth/children-due',
            [
                'title' => 'Due for Growth Monitoring',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Children' => '/children',
                    'Growth Monitoring' => '/children/growth',
                    'Due' => null
                ],
                'moduleNav' => ChildNavigation::items(),
                'activeModuleNav' => '/children/growth',
                'children' => $this->growthService->getDueChildren()
            ]
        );
    }

    public function childrenWithAlerts(): void
    {
        $this->view->render('growth/children-alerts', [
            'title' => 'Growth Alerts',
            'breadcrumbs' => [
                'Dashboard' => '/dashboard',
                'Children' => '/children',
                'Growth Monitoring' => '/children/growth',
                'Alerts' => null
            ],
            'moduleNav' => ChildNavigation::items(),
            'activeModuleNav' => '/children/growth',
            'alerts' => $this->growthService->getActiveAlerts()
        ]);
    }

    // Child Profile Growth Management
    public function show(int $id): void
    {   

        // find whether the child exists
        $child = $this->childService->findById($id);
        if ($child === null) {
            $this->response->notFound();
            return;
        }
        $this->view->render('children/child-profile/growth/show', [
            'title' => 'Growth History',
            'breadcrumbs' => [
                'Dashboard' => '/dashboard',
                'Children' => '/children',
                $child['full_name'] => "/children/{$id}",
                'Growth' => null
            ],
            'moduleNav' => ChildProfileNavigation::items($id),
            'activeModuleNav' => "/children/{$id}/growth",
            'child' => $child,
            'growthRecords' => $this->growthService->getByChildId($id)
        ]);
    }

    public function create(int $id): void
    {
        $child = $this->childService->findById($id);
        if ($child === null) {
            $this->response->notFound();
            return;
        }
        $this->form('children/child-profile/growth/create', 'Add Growth Measurement', $id, ['child' => $child, 'staff' => $this->growthService->getStaffOptions()]);
    }

    public function store(int $id): void
    {
        if ($this->growthService->create($id, $this->request->all()) === null) $this->response->redirect(APP_URL . "/children/{$id}/growth/create");
        unset($_SESSION['growthData']);
        $_SESSION['success'] = 'Growth measurement recorded successfully.';
        $this->response->redirect(APP_URL . "/children/{$id}/growth");
    }

    public function edit(int $id, int $measurementId): void
    {
        $child = $this->childService->findById($id);
        $record = $this->growthService->findRecord($id, $measurementId);
        if ($child === null || $record === null) {
            $this->response->notFound();
            return;
        }
        $this->form('children/child-profile/growth/edit', 'Edit Growth Measurement', $id, ['child' => $child, 'record' => $record, 'staff' => $this->growthService->getStaffOptions()]);
    }

    public function update(int $id, int $measurementId): void
    {
        if (!$this->growthService->update($id, $measurementId, $this->request->all())) $this->response->redirect(APP_URL . "/children/{$id}/growth/{$measurementId}/edit");
        unset($_SESSION['growthData']);
        $_SESSION['success'] = 'Growth measurement updated successfully.';
        $this->response->redirect(APP_URL . "/children/{$id}/growth");
    }

    private function form(string $view, string $title, int $id, array $data): void
    {
        $this->view->render(
            $view,
            [
                'title' => $title,
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Children' => '/children',
                    'Child Details' => "/children/{$id}",
                    'Growth' => "/children/{$id}/growth",
                    $title => null
                ],
                'moduleNav' => ChildProfileNavigation::items($id),
                'activeModuleNav' => "/children/{$id}/growth"
            ] + $data
        );
    }
}
