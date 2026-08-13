<?php

declare(strict_types=1);

class ClinicController extends Controller
{
    private ClinicService $service;
    public function __construct() { parent::__construct(); $this->service = new ClinicService(); }
    public function index(): void
    {
        $this->view->render('clinics/index', ['title'=>'Clinic Sessions','clinics'=>$this->service->getAll()]);
    }
    public function show(int $id): void
    {
        $clinic = $this->service->findById($id);
        if (!$clinic) { Response::notFound(); return; }
        $this->view->render('clinics/show', ['title'=>'Clinic Session','clinic'=>$clinic]);
    }
    public function create(): void
    {
        $this->view->render('clinics/create', array_merge(['title'=>'Schedule Clinic'], $this->service->getFormOptions()));
    }
    public function store(): void
    {
        $id = $this->service->create($this->request->all());
        if (!$id) { $this->response->back(); }
        $_SESSION['success']='Clinic session scheduled successfully.';
        $this->response->redirect(APP_URL.'/clinics/'.$id);
    }
    public function edit(int $id): void
    {
        $clinic=$this->service->findById($id);
        if (!$clinic) { Response::notFound(); return; }
        $this->view->render('clinics/edit', array_merge(['title'=>'Edit Clinic','clinic'=>$clinic], $this->service->getFormOptions()));
    }
    public function update(int $id): void
    {
        if (!$this->service->update($id, $this->request->all())) { $this->response->back(); }
        $_SESSION['success']='Clinic session updated successfully.';
        $this->response->redirect(APP_URL.'/clinics/'.$id);
    }
    public function destroy(int $id): void
    {
        $this->service->delete($id);
        $_SESSION['success']='Clinic session deleted.';
        $this->response->redirect(APP_URL.'/clinics');
    }
}
