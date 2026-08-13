<?php

declare(strict_types=1);
class FamilyHomeRepository extends Repository
{
    public function findByFamily(int $id): ?array
    {
        return $this->findOne('SELECT f.*, pa.phm_area_name, ma.moh_name FROM family f INNER JOIN phm_area pa ON pa.phm_area_id=f.phm_area_id INNER JOIN moh_area ma ON ma.moh_area_id=pa.moh_area_id WHERE f.family_id=:id', ['id' => $id]);
    }
    public function update(int $id, array $data): bool
    {
        $this->execute('UPDATE family SET address=:address,status=:status,remarks=:remarks WHERE family_id=:id', ['id' => $id, 'address' => trim((string)$data['address']), 'status' => $data['status'] ?? 'Active', 'remarks' => trim((string)($data['remarks'] ?? '')) ?: null]);
        return true;
    }
}
