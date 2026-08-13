<?php

declare(strict_types=1);
class FieldVisitRepository extends Repository
{
    public function getAll(): array
    {
        return $this->findAll('SELECT fv.*, f.registration_number, CONCAT_WS(" ",p.first_name,p.middle_name,p.last_name) person_name, CONCAT_WS(" ",s.first_name,s.middle_name,s.last_name) staff_name FROM field_visit fv INNER JOIN family f ON f.family_id=fv.family_id INNER JOIN staff s ON s.staff_id=fv.staff_id LEFT JOIN person p ON p.person_id=fv.person_id ORDER BY fv.visit_date DESC');
    }
    public function findById(int $id): ?array
    {
        return $this->findOne('SELECT fv.*, f.registration_number, f.address, CONCAT_WS(" ",p.first_name,p.middle_name,p.last_name) person_name, CONCAT_WS(" ",s.first_name,s.middle_name,s.last_name) staff_name FROM field_visit fv INNER JOIN family f ON f.family_id=fv.family_id INNER JOIN staff s ON s.staff_id=fv.staff_id LEFT JOIN person p ON p.person_id=fv.person_id WHERE fv.visit_id=:id', ['id' => $id]);
    }
    public function byFamily(int $id): array
    {
        return parent::findAll('SELECT fv.*, f.registration_number, CONCAT_WS(" ",p.first_name,p.middle_name,p.last_name) person_name, CONCAT_WS(" ",s.first_name,s.middle_name,s.last_name) staff_name FROM field_visit fv INNER JOIN family f ON f.family_id=fv.family_id INNER JOIN staff s ON s.staff_id=fv.staff_id LEFT JOIN person p ON p.person_id=fv.person_id WHERE fv.family_id=:id ORDER BY fv.visit_date DESC', ['id' => $id]);
    }
    public function families(): array
    {
        return $this->findAll('SELECT family_id, registration_number FROM family ORDER BY registration_number');
    }
    public function staff(): array
    {
        return $this->findAll('SELECT staff_id, CONCAT_WS(" ",first_name,middle_name,last_name) full_name FROM staff WHERE status="Active" ORDER BY first_name');
    }
    public function people(): array
    {
        return $this->findAll('SELECT person_id, family_id, CONCAT_WS(" ",first_name,middle_name,last_name) full_name FROM person WHERE status="Active" ORDER BY first_name');
    }
    public function create(array $d): int
    {
        $this->execute('INSERT INTO field_visit (family_id,staff_id,person_id,pregnancy_id,visit_date,visit_type,visit_status,follow_up_required,follow_up_date,observations,risk_identified) VALUES (:family_id,:staff_id,:person_id,:pregnancy_id,:visit_date,:visit_type,:visit_status,:follow_up_required,:follow_up_date,:observations,:risk_identified)', $this->params($d));
        return $this->lastInsertId();
    }
    public function update(int $id, array $d): void
    {
        $p = $this->params($d);
        $p['id'] = $id;
        $this->execute('UPDATE field_visit SET family_id=:family_id,staff_id=:staff_id,person_id=:person_id,pregnancy_id=:pregnancy_id,visit_date=:visit_date,visit_type=:visit_type,visit_status=:visit_status,follow_up_required=:follow_up_required,follow_up_date=:follow_up_date,observations=:observations,risk_identified=:risk_identified WHERE visit_id=:id', $p);
    }
    public function delete(int $id): void
    {
        $this->execute('DELETE FROM field_visit WHERE visit_id=:id', ['id' => $id]);
    }
    private function params(array $d): array
    {
        return ['family_id' => (int)$d['family_id'], 'staff_id' => (int)$d['staff_id'], 'person_id' => ($d['person_id'] ?? '') !== '' ? (int)$d['person_id'] : null, 'pregnancy_id' => ($d['pregnancy_id'] ?? '') !== '' ? (int)$d['pregnancy_id'] : null, 'visit_date' => $d['visit_date'], 'visit_type' => $d['visit_type'], 'visit_status' => $d['visit_status'] ?? 'Completed', 'follow_up_required' => isset($d['follow_up_required']) ? 1 : 0, 'follow_up_date' => ($d['follow_up_date'] ?? '') ?: null, 'observations' => trim($d['observations'] ?? '') ?: null, 'risk_identified' => isset($d['risk_identified']) ? 1 : 0];
    }
}
