<?php

declare(strict_types=1);
class SupplementDistributionController extends Controller
{
    private SupplimentDistService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new SupplimentDistService();
    }
    public function edit(int $id): void
    {
        $record = $this->record($id);
        $person = $record['recipient_type'] === 'Child' ? (new ChildService())->findById((int)$record['person_id']) : (new MotherService())->findById((int)$record['person_id']);
        if ($person === null) {
            Response::notFound();
            return;
        }
        $this->view->render(
            'supplements/edit',
            [
                'title' => 'Edit Supplement Distribution',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Supplements' => '/supplements',
                    'Edit Distribution' => null
                ],
                'moduleNav' => SupplementNavigation::items(),
                'activeModuleNav' => '/supplements',
                'record' => $record,
                'person' => $person,
                'recipientType' => $record['recipient_type']
            ] + $this->service->formOptions($record['recipient_type'])
        );
    }
    public function update(int $id): void
    {
        $record = $this->record($id);
        if (!$this->service->update((int)$record['person_id'], $id, $this->request->all())) $this->response->redirect(APP_URL . '/supplements/distributions/' . $id . '/edit');
        $_SESSION['success'] = 'Supplement distribution updated.';
        $this->response->redirect(APP_URL . '/supplements');
    }
    public function voidRecord(int $id): void
    {
        $this->record($id);
        $this->service->delete($id);
        $_SESSION['success'] = 'Incorrect supplement distribution removed.';
        $this->response->redirect(APP_URL . '/supplements');
    }
    private function record(int $id): array
    {
        $record = $this->service->findById($id);
        if ($record === null) {
            Response::notFound();
            exit;
        }
        return $record;
    }
}
