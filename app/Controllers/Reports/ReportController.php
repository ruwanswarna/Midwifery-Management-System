<?php

declare(strict_types=1);
class ReportController extends Controller
{
    private ReportService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new ReportService();
    }
    public function index(): void
    {
        $this->view->render(
            'reports/index',
            ['title' => 'Reports', 'reports' => $this->service->getAll()]
        );
    }
    public function show(int $id): void
    {
        $report = $this->service->findById($id);
        if (!$report) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'reports/show',
            ['title' => 'Report Submission', 'report' => $report]
        );
    }
    public function create(): void
    {
        $this->view->render(
            'reports/create',
            ['title' => 'Submit Report', 'staff' => $this->service->staff()]
        );
    }
    public function store(): void
    {
        $id = $this->service->create($this->request->all());
        if (!$id) $this->response->back();
        $_SESSION['success'] = 'Report submitted successfully.';
        $this->response->redirect(APP_URL . '/reports/' . $id);
    }
}
