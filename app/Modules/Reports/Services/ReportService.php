<?php
declare(strict_types=1);
class ReportService
{
    private ReportRepository $repository;public function __construct(){$this->repository=new ReportRepository();}public function getAll():array{return $this->repository->getAll();}public function findById(int $id):?array{return $this->repository->findById($id);}public function staff():array{return $this->repository->staff();}
    public function create(array $d):?int{$e=[];foreach(['submitted_by','report_type','reporting_period_start','reporting_period_end','submitted_date'] as $f)if(empty($d[$f]))$e[$f]='This field is required.';if(!empty($d['reporting_period_start'])&&!empty($d['reporting_period_end'])&&$d['reporting_period_start']>$d['reporting_period_end'])$e['reporting_period_end']='End date must not precede start date.';if($e){$_SESSION['errors']=$e;$_SESSION['reportData']=$d;return null;}return $this->repository->create($d);}
}
