<?php

declare(strict_types=1);
class FieldVisitController extends Controller
{
    private FieldVisitService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new FieldVisitService();
    }
    public function index(): void
    {
        $this->view->render(
            'field-visits/index',
            ['title' => 'Field Visits', 'visits' => $this->service->getAll()]
        );
    }
    public function show(int $id): void
    {
        $visit = $this->service->findById($id);
        if (!$visit) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'field-visits/show',
            ['title' => 'Field Visit', 'visit' => $visit]
        );
    }
    public function create(): void
    {
        $this->view->render(
            'field-visits/create',
            array_merge(['title' => 'Record Field Visit'], $this->service->options())
        );
    }
    public function store(): void
    {
        $id = $this->service->create($this->request->all());
        if (!$id) $this->response->back();
        $_SESSION['success'] = 'Field visit recorded.';
        $this->response->redirect(APP_URL . '/field-visits/' . $id);
    }
    public function edit(int $id): void
    {
        $visit = $this->service->findById($id);
        if (!$visit) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'field-visits/edit',
            array_merge(['title' => 'Edit Field Visit', 'visit' => $visit], $this->service->options())
        );
    }
    public function update(int $id): void
    {
        if (!$this->service->update($id, $this->request->all())) $this->response->back();
        $_SESSION['success'] = 'Field visit updated.';
        $this->response->redirect(APP_URL . '/field-visits/' . $id);
    }
    public function destroy(int $id): void
    {
        $this->service->delete($id);
        $_SESSION['success'] = 'Field visit deleted.';
        $this->response->redirect(APP_URL . '/field-visits');
    }
    public function byFamily(int $id): void
    {
        $family = (new FamilyRepository())->findById($id);
        if ($family === null) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'families/family-profile/field-visits/index',
            [
                'title' => 'Family Field Visits',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Families' => '/families',
                    $family['registration_number'] => '/families/' . $id,
                    'Field Visits' => null
                ],
                'moduleNav' => FamilyProfileNavigation::items($id),
                'activeModuleNav' => '/families/' . $id . '/field-visits',
                'family' => $family,
                'visits' => $this->service->getByFamily($id)
            ]
        );
    }
}
