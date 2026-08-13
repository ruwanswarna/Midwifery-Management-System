<?php

declare(strict_types=1);

class MotherController extends Controller
{
    private MotherService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new MotherService();
    }

    public function index(): void
    {
        $stats = $this->service->getStatistics();
        $this->render(
            'mothers/index',
            'Mother Overview',
            '/mothers',
            ['mothers' => array_slice($this->service->getAll(), 0, 8), 'statistics' => $stats]
        );
    }

    public function registry(): void
    {
        $search = (string) $this->request->query('search', '');
        $this->render(
            'mothers/registry',
            'Mother Registry',
            '/mothers/registry',
            ['mothers' => $this->service->getAll($search), 'search' => $search, 'statistics' => $this->service->getStatistics()],
            ['Registry' => null]
        );
    }

    public function create(): void
    {
        $this->render(
            'mothers/create',
            'Register Mother',
            '/mothers/create',
            ['eligibleWomen' => $this->service->getEligibleWomen()],
            ['Register Mother' => null]
        );
    }

    public function store(): void
    {
        if (!$this->service->create($this->request->all())) $this->response->redirect(APP_URL . '/mothers/create');
        unset($_SESSION['motherData']);
        $_SESSION['success'] = 'Maternal profile registered successfully.';
        $this->response->redirect(APP_URL . '/mothers/' . (int) $this->request->post('person_id'));
    }

    public function show(int $id): void
    {
        $mother = $this->mother($id);
        $this->renderProfile(
            'mothers/mother-profile/show',
            $mother['full_name'],
            $id,
            ['mother' => $mother, 'pregnancies' => $this->service->getPregnanciesByMother($id), 'clinicVisits' => $this->service->getClinicVisitsByMother($id), 'fieldVisits' => $this->service->getFieldVisitsByMother($id), 'supplements' => $this->service->getSupplementsByMother($id)]
        );
    }

    public function pregnancyByMother(int $id): void
    {
        $mother = $this->mother($id);
        $this->renderProfile(
            'mothers/mother-profile/pregnancies',
            'Pregnancies for ' . $mother['full_name'],
            $id,
            ['mother' => $mother, 'pregnancies' => $this->service->getPregnanciesByMother($id)],
            'Pregnancies'
        );
    }

    public function clinicVisitsByMother(int $id): void
    {
        $mother = $this->mother($id);
        $this->renderProfile(
            'mothers/mother-profile/clinic-visits',
            'Clinic Visits for ' . $mother['full_name'],
            $id,
            ['mother' => $mother, 'clinicVisits' => $this->service->getClinicVisitsByMother($id)],
            'Clinic Visits'
        );
    }

    public function fieldVisitsByMother(int $id): void
    {
        $mother = $this->mother($id);
        $this->renderProfile(
            'mothers/mother-profile/field-visits',
            'Field Visits for ' . $mother['full_name'],
            $id,
            ['mother' => $mother, 'fieldVisits' => $this->service->getFieldVisitsByMother($id)],
            'Field Visits'
        );
    }

    public function supplementsByMother(int $id): void
    {
        $mother = $this->mother($id);
        $this->renderProfile(
            'mothers/mother-profile/suppliments',
            'Supplements for ' . $mother['full_name'],
            $id,
            ['mother' => $mother, 'distributions' => $this->service->getSupplementsByMother($id)],
            'Supplements'
        );
    }

    public function edit(int $id): void
    {
        $mother = $this->mother($id);
        $this->renderProfile(
            'mothers/edit',
            'Edit Mother',
            $id,
            ['mother' => $mother],
            'Edit'
        );
    }

    public function update(int $id): void
    {
        if (!$this->service->update($id, $this->request->all())) $this->response->redirect(APP_URL . "/mothers/{$id}/edit");
        unset($_SESSION['motherData']);
        $_SESSION['success'] = 'Mother details updated successfully.';
        $this->response->redirect(APP_URL . "/mothers/{$id}");
    }

    public function delete(int $id): void
    {
        $_SESSION['errors'] = ['Maternal profiles are retained for clinical history and cannot be deleted.'];
        $this->response->redirect(APP_URL . "/mothers/{$id}");
    }

    public function pregnancies(): void
    {
        $this->registry();
    }

    public function highRisk(): void
    {
        $mothers = array_values(array_filter($this->service->getAll(), static fn(array $m): bool => ($m['risk_status'] ?? '') === 'High'));
        $this->render('mothers/high-risk', 'High Risk Mothers', '/mothers/high-risk', ['mothers' => $mothers], ['High Risk' => null]);
    }

    public function expectedDeliveries(): void
    {
        $mothers = array_values(array_filter($this->service->getAll(), static fn(array $m): bool => !empty($m['expected_delivery_date']) && $m['expected_delivery_date'] >= date('Y-m-d') && $m['expected_delivery_date'] <= date('Y-m-d', strtotime('+60 days'))));
        $this->render(
            'mothers/expected-deliveries',
            'Expected Deliveries',
            '/mothers/expected-deliveries',
            ['mothers' => $mothers],
            ['Expected Deliveries' => null]
        );
    }

    public function reports(): void
    {
        $this->render(
            'mothers/reports',
            'Mother Reports',
            '/mothers/reports',
            ['mothers' => $this->service->getAll(), 'statistics' => $this->service->getStatistics()],
            ['Reports' => null]
        );
    }

    private function mother(int $id): array
    {
        $mother = $this->service->findById($id);
        if ($mother === null) {
            Response::notFound();
            exit;
        }
        return $mother;
    }

    private function render(string $view, string $title, string $active, array $data = [], array $tail = []): void
    {
        $this->view->render(
            $view,
            ['title' => $title, 'breadcrumbs' => ['Dashboard' => '/dashboard', 'Mothers' => '/mothers'] + $tail, 'moduleNav' => MotherNavigation::items(), 'activeModuleNav' => $active] + $data
        );
    }

    private function renderProfile(string $view, string $title, int $id, array $data, string $leaf = 'Overview'): void
    {
        $mother = $data['mother'];
        $this->view->render(
            $view,
            [
                'title' => $title,
                'breadcrumbs' => ['Dashboard' => '/dashboard', 'Mothers' => '/mothers', $mother['full_name'] => "/mothers/{$id}", $leaf => null],
                'moduleNav' => MotherProfileNavigation::items($id),
                'activeModuleNav' => $leaf === 'Overview' ? "/mothers/{$id}" : "/mothers/{$id}/" . strtolower(str_replace(' ', '-', $leaf))
            ] + $data
        );
    }
}
