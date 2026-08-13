<?php

declare(strict_types=1);

class SupplimentDistController extends Controller
{
    private SupplimentDistService $service;
    private ChildService $childService;
    private MotherService $motherService;
    public function __construct()
    {
        parent::__construct();
        $this->service = new SupplimentDistService();
        $this->childService = new ChildService();
        $this->motherService = new MotherService();
    }

    public function index(): void
    {
        $this->view->render(
            'supplements/index',
            $this->pageData('Supplements Overview', '/supplements') + ['distributions' => $this->service->getAll(), 'statistics' => $this->service->getStatistics(), 'dueRecipients' => $this->service->getDueRecipients()]
        );
    }

    public function childrenSupplementIndex(): void
    {
        $this->view->render(
            'supplements/children/index',
            $this->pageData('Child Supplement Distribution', '/supplements/children') + ['distributions' => $this->service->getRecentChildDistributions(), 'dueRecipients' => $this->service->getDueRecipients('Child')]
        );
    }

    public function mothersSupplementIndex(): void
    {
        $this->view->render(
            'supplements/mothers/index',
            $this->pageData('Mother Supplement Distribution', '/supplements/mothers') + ['distributions' => $this->service->getRecentMaternalDistributions(), 'dueRecipients' => array_values(array_filter($this->service->getDueRecipients(), static fn(array $row): bool => $row['recipient_type'] !== 'Child'))]
        );
    }

    public function dueAndOverdue(): void
    {
        $this->view->render('supplements/due', $this->pageData('Due & Overdue Supplements', '/supplements/due') + ['recipients' => $this->service->getDueRecipients()]);
    }

    public function showChildSuppliments(int $childId): void
    {
        $child = $this->childService->findById($childId);
        if ($child === null) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'children/child-profile/suppliments/show',
            [
                'title' => 'Child Supplement History',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Children' => '/children',
                    $child['full_name'] => "/children/{$childId}",
                    'Supplements' => null
                ],
                'moduleNav' => ChildProfileNavigation::items($childId),
                'activeModuleNav' => "/children/{$childId}/supplements",
                'person' => $child,
                'distributions' => $this->service->getByPerson($childId)
            ]
        );
    }

    public function byChild(int $childId): void
    {
        $this->showChildSuppliments($childId);
    }

    public function showMotherSuppliments(int $motherId): void
    {
        $mother = $this->motherService->findById($motherId);
        if ($mother === null) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'mothers/mother-profile/suppliments',
            [
                'title' => 'Mother Supplement History',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Mothers' => '/mothers',
                    $mother['full_name'] => "/mothers/{$motherId}",
                    'Supplements' => null
                ],
                'moduleNav' => MotherProfileNavigation::items($motherId),
                'activeModuleNav' => "/mothers/{$motherId}/supplements",
                'mother' => $mother,
                'distributions' => $this->service->getByPerson($motherId)
            ]
        );
    }

    public function create(int $personId): void
    {
        $isMother = str_contains($_SERVER['REQUEST_URI'] ?? '', '/mothers/');
        $person = $isMother ? $this->motherService->findById($personId) : $this->childService->findById($personId);
        if ($person === null) {
            Response::notFound();
            return;
        }
        $type = $isMother ? 'Pregnant Mother' : 'Child';
        $view = $isMother ? 'supplements/mothers/create' : 'children/child-profile/suppliments/create';
        $this->view->render(
            $view,
            [
                'title' => 'Record Supplement Distribution',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    ($isMother ? 'Mothers' : 'Children') => ($isMother ? '/mothers' : '/children'),
                    $person['full_name'] => ($isMother ? '/mothers/' : '/children/') . $personId,
                    'Supplements' => null
                ],
                'moduleNav' => $isMother ? MotherProfileNavigation::items($personId) : ChildProfileNavigation::items($personId),
                'activeModuleNav' => ($isMother ? '/mothers/' : '/children/') . $personId . '/supplements',
                'person' => $person,
                'recipientType' => $type
            ] + $this->service->formOptions($type)
        );
    }

    public function store(int $personId): void
    {
        $isMother = str_contains($_SERVER['REQUEST_URI'] ?? '', '/mothers/');
        $type = $isMother ? 'Pregnant Mother' : 'Child';
        $base = ($isMother ? '/mothers/' : '/children/') . $personId . '/supplements';
        if ($this->service->create($personId, $type, $this->request->all()) === null) $this->response->redirect(APP_URL . $base . '/create');
        unset($_SESSION['supplementData']);
        $_SESSION['success'] = 'Supplement distribution recorded successfully.';
        $this->response->redirect(APP_URL . $base);
    }

    public function edit(int $childId, int $distributionId): void
    {
        $child = $this->childService->findById($childId);
        $record = $this->service->findRecord($childId, $distributionId);
        if ($child === null || $record === null) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'children/child-profile/suppliments/edit',
            [
                'title' => 'Edit Supplement Distribution',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Children' => '/children',
                    $child['full_name'] => "/children/{$childId}",
                    'Supplements' => "/children/{$childId}/supplements",
                    'Edit' => null
                ],
                'moduleNav' => ChildProfileNavigation::items($childId),
                'activeModuleNav' => "/children/{$childId}/supplements",
                'person' => $child,
                'record' => $record,
                'recipientType' => 'Child'
            ] + $this->service->formOptions('Child')
        );
    }

    public function update(int $childId, int $distributionId): void
    {
        if (!$this->service->update($childId, $distributionId, $this->request->all())) $this->response->redirect(APP_URL . "/children/{$childId}/supplements/{$distributionId}/edit");
        unset($_SESSION['supplementData']);
        $_SESSION['success'] = 'Supplement distribution updated successfully.';
        $this->response->redirect(APP_URL . "/children/{$childId}/supplements");
    }

    public function reports(): void
    {
        $this->view->render(
            'supplements/reports',
            $this->pageData('Supplement Distribution Reports', '/supplements/reports') + ['distributions' => $this->service->getAll(), 'statistics' => $this->service->getStatistics()]
        );
    }

    private function pageData(string $title, string $active): array
    {
        return ['title' => $title, 'breadcrumbs' => ['Dashboard' => '/dashboard', 'Supplements' => $active === '/supplements' ? null : '/supplements', $title => null], 'moduleNav' => SupplementNavigation::items(), 'activeModuleNav' => $active];
    }
}
