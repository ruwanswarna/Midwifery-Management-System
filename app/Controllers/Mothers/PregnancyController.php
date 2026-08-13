<?php

declare(strict_types=1);

class PregnancyController extends Controller
{
    private PregnancyService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new PregnancyService();
    }

    public function index(): void
    {
        $this->render(
            'pregnancies/index',
            'Pregnancies',
            '/pregnancies',
            ['pregnancies' => array_slice($this->service->getAll('', 'Ongoing'), 0, 8), 'statistics' => $this->service->getStatistics()]
        );
    }

    public function registry(): void
    {
        $search = (string) $this->request->query('search', '');
        $status = $this->request->query('status');
        $status = in_array($status, ['Ongoing', 'Delivered', 'Transferred', 'Terminated'], true) ? $status : null;
        $this->render(
            'pregnancies/registry',
            'Pregnancy Registry',
            '/pregnancies/registry',
            ['pregnancies' => $this->service->getAll($search, $status), 'search' => $search, 'statusFilter' => $status, 'statistics' => $this->service->getStatistics()],
            ['Registry' => null]
        );
    }

    public function create(): void
    {
        $this->form('pregnancies/create', 'Register Pregnancy', ['mothers' => $this->service->getMothers()]);
    }

    public function store(): void
    {
        if (!$this->service->create($this->request->all())) $this->response->redirect(APP_URL . '/pregnancies/create');
        unset($_SESSION['pregnancyData']);
        $_SESSION['success'] = 'Pregnancy registered successfully.';
        $this->response->redirect(APP_URL . '/pregnancies/registry');
    }

    public function show(int $id): void
    {
        $pregnancy = $this->pregnancy($id);
        $this->render(
            'pregnancies/show',
            'Pregnancy Details',
            '/pregnancies/registry',
            ['pregnancy' => $pregnancy],
            ['Pregnancy #' . $id => null]
        );
    }

    public function pregnancyByMother(int $id): void
    {
        $mother = $this->service->findMotherById($id);
        if ($mother === null) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'mothers/mother-profile/pregnancies',
            [
                'title' => 'Pregnancies for ' . $mother['full_name'],
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Mothers' => '/mothers',
                    $mother['full_name'] => "/mothers/{$id}",
                    'Pregnancies' => null
                ],
                'moduleNav' => MotherProfileNavigation::items($id),
                'activeModuleNav' => "/mothers/{$id}/pregnancies",
                'mother' => $mother,
                'pregnancies' => $this->service->getPregnanciesByMother($id)
            ]
        );
    }

    public function edit(int $id): void
    {
        $this->form('pregnancies/edit', 'Edit Pregnancy', ['pregnancy' => $this->pregnancy($id), 'mothers' => $this->service->getMothers()], $id);
    }

    public function update(int $id): void
    {
        if (!$this->service->update($id, $this->request->all())) $this->response->redirect(APP_URL . "/pregnancies/{$id}/edit");
        unset($_SESSION['pregnancyData']);
        $_SESSION['success'] = 'Pregnancy updated successfully.';
        $this->response->redirect(APP_URL . "/pregnancies/{$id}");
    }

    public function delete(int $id): void
    {
        try {
            $this->service->delete($id);
            $_SESSION['success'] = 'Pregnancy record deleted.';
        } catch (PDOException) {
            $_SESSION['errors'] = ['This pregnancy has related clinical records and cannot be deleted.'];
        }
        $this->response->redirect(APP_URL . '/pregnancies/registry');
    }

    public function highRisk(): void
    {
        $this->render(
            'pregnancies/high-risk',
            'High Risk Pregnancies',
            '/pregnancies/high-risk',
            ['pregnancies' => $this->service->getHighRiskPregnancies()],
            ['High Risk' => null]
        );
    }
    public function expectedDeliveries(): void
    {
        $this->render(
            'pregnancies/expected-deliveries',
            'Expected Deliveries',
            '/pregnancies/expected-deliveries',
            ['pregnancies' => $this->service->getExpectedDeliveries()],
            ['Expected Deliveries' => null]
        );
    }
    public function visits(): void
    {
        $this->render(
            'pregnancies/visits',
            'Pregnancy Visits and Follow-ups',
            '/pregnancies/visits',
            ['visits' => $this->service->getVisits()],
            ['Visits and Follow-ups' => null]
        );
    }
    public function birthOutcomes(): void
    {
        $this->render(
            'pregnancies/birth-outcomes',
            'Pregnancy Birth Outcomes',
            '/pregnancies/birth-outcomes',
            ['outcomes' => $this->service->getBirthOutcomes()],
            ['Birth Outcomes' => null]
        );
    }
    public function reports(): void
    {
        $this->render(
            'pregnancies/reports',
            'Pregnancy Reports',
            '/pregnancies/reports',
            ['pregnancies' => $this->service->getAll(), 'statistics' => $this->service->getStatistics(), 'outcomes' => $this->service->getBirthOutcomes()],
            ['Reports' => null]
        );
    }

    public function recordBirthOutcome(int $id): void
    {
        $this->render(
            'pregnancies/record-birth-outcome',
            'Record Birth Outcome',
            '/pregnancies/birth-outcomes',
            ['pregnancy' => $this->pregnancy($id)],
            ['Pregnancy #' . $id => "/pregnancies/{$id}", 'Record Outcome' => null]
        );
    }

    public function storeBirthOutcome(int $id): void
    {
        $this->pregnancy($id);
        if (!$this->service->createBirthOutcome($id, $this->request->all())) $this->response->redirect(APP_URL . "/pregnancies/{$id}/birth-outcome");
        unset($_SESSION['outcomeData']);
        $_SESSION['success'] = 'Birth outcome recorded successfully.';
        $this->response->redirect(APP_URL . "/pregnancies/{$id}");
    }

    public function showEddCalculator(): void
    {
        $this->render(
            'pregnancies/edd-calculator',
            'EDD Calculator',
            '/pregnancies/edd-calculator',
            [],
            ['EDD Calculator' => null]
        );
    }
    public function calculateEdd(): void
    {
        $lmp = (string) $this->request->post('last_menstrual_period', '');
        if ($lmp === '') {
            $_SESSION['errors'] = ['Enter the last menstrual period date.'];
            $this->response->back();
        }
        $_SESSION['eddResult'] = $this->service->calculateExpectedDeliveryDate($lmp, (int) $this->request->post('cycle_length', 28));
        $this->response->back();
    }

    private function pregnancy(int $id): array
    {
        $record = $this->service->findById($id);
        if ($record === null) {
            Response::notFound();
            exit;
        }
        return $record;
    }
    private function form(string $view, string $title, array $data, ?int $id = null): void
    {
        $this->render(
            $view,
            $title,
            $id === null ? '/pregnancies/create' : '/pregnancies/registry',
            $data,
            [$title => null]
        );
    }
    private function render(string $view, string $title, string $active, array $data = [], array $tail = []): void
    {
        $this->view->render(
            $view,
            ['title' => $title, 'breadcrumbs' => ['Dashboard' => '/dashboard', 'Pregnancies' => '/pregnancies'] + $tail, 'moduleNav' => PregnancyNavigation::items(), 'activeModuleNav' => $active] + $data
        );
    }
}
