<?php

declare(strict_types=1);
class GuardianshipController extends Controller
{
    private GuardianshipService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new GuardianshipService();
    }
    public function index(int $familyId): void
    {
        $family = $this->family($familyId);
        $this->render(
            'families/family-profile/guardianship/index',
            'Household Guardians',
            $familyId,
            $family,
            ['guardians' => $this->service->getGuardians($familyId), 'children' => $this->service->getChildren($familyId)]
        );
    }
    public function create(int $familyId): void
    {
        $family = $this->family($familyId);
        $this->render(
            'families/family-profile/guardianship/create',
            'Designate Guardian',
            $familyId,
            $family,
            ['candidates' => $this->service->getCandidates($familyId), 'children' => $this->service->getChildren($familyId)]
        );
    }
    public function store(int $familyId): void
    {
        $this->family($familyId);
        if (!$this->service->designate($familyId, $this->request->all())) $this->response->redirect(APP_URL . '/families/' . $familyId . '/guardianship/create');
        $_SESSION['success'] = 'Household guardian designated.';
        $this->response->redirect(APP_URL . '/families/' . $familyId . '/guardianship');
    }
    public function end(int $familyId, int $guardianshipId): void
    {
        $this->family($familyId);
        $this->service->end($familyId, $guardianshipId);
        $_SESSION['success'] = 'Guardian designation ended.';
        $this->response->redirect(APP_URL . '/families/' . $familyId . '/guardianship');
    }
    private function family(int $id): array
    {
        $f = $this->service->getFamilyById($id);
        if ($f === null) {
            Response::notFound();
            exit;
        }
        return $f;
    }
    private function render(string $view, string $title, int $id, array $family, array $data): void
    {
        $this->view->render(
            $view,
            [
                'title' => $title,
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Families' => '/families',
                    $family['registration_number'] => '/families/' . $id,
                    $title => null
                ],
                'moduleNav' => FamilyProfileNavigation::items($id),
                'activeModuleNav' => '/families/' . $id . '/guardianship',
                'family' => $family
            ] + $data
        );
    }
}
