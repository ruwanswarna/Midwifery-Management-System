<?php

declare(strict_types=1);
class FamilyHomeController extends Controller
{
    private FamilyHomeService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new FamilyHomeService();
    }
    public function index(int $familyId): void
    {
        $home = $this->home($familyId);
        $this->render('families/family-profile/household/index', 'Household Details', $familyId, $home);
    }
    public function edit(int $familyId): void
    {
        $home = $this->home($familyId);
        $this->render('families/family-profile/household/edit', 'Edit Household Details', $familyId, $home);
    }
    public function update(int $familyId): void
    {
        if (!$this->service->update($familyId, $this->request->all())) $this->response->redirect(APP_URL . '/families/' . $familyId . '/home/edit');
        unset($_SESSION['homeData']);
        $_SESSION['success'] = 'Household details updated.';
        $this->response->redirect(APP_URL . '/families/' . $familyId . '/home');
    }
    private function home(int $id): array
    {
        $home = $this->service->getById($id);
        if ($home === null) {
            Response::notFound();
            exit;
        }
        return $home;
    }
    private function render(string $view, string $title, int $id, array $home): void
    {
        $this->view->render($view, ['title' => $title, 'breadcrumbs' => ['Dashboard' => '/dashboard', 'Families' => '/families', $home['registration_number'] . ' ' => '/families/' . $id, $title => null], 'moduleNav' => FamilyProfileNavigation::items($id), 'activeModuleNav' => '/families/' . $id . '/household', 'home' => $home]);
    }
}
