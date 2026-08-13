<?php

declare(strict_types=1);
class GuardianshipRepository extends Repository
{
    public function family(int $id): ?array
    {
        return $this->findOne('SELECT * FROM family WHERE family_id=:id', ['id' => $id]);
    }
    public function guardians(int $id): array
    {
        return $this->findAll('SELECT person_id,CONCAT_WS(" ",first_name,middle_name,last_name) full_name,nic,phone FROM person WHERE family_id=:id AND is_guardian=1 ORDER BY first_name', ['id' => $id]);
    }
    public function candidates(int $id): array
    {
        return $this->findAll('SELECT person_id,CONCAT_WS(" ",first_name,middle_name,last_name) full_name,nic,phone FROM person WHERE family_id=:id AND status="Active" AND is_guardian=0 AND TIMESTAMPDIFF(YEAR,date_of_birth,CURDATE())>=18 ORDER BY first_name', ['id' => $id]);
    }
    public function children(int $id): array
    {
        return $this->findAll('SELECT p.person_id,CONCAT_WS(" ",p.first_name,p.middle_name,p.last_name) full_name,p.date_of_birth FROM person p INNER JOIN child c ON c.person_id=p.person_id WHERE p.family_id=:id ORDER BY p.date_of_birth', ['id' => $id]);
    }
    public function designate(int $familyId, int $personId): bool
    {
        $this->execute('UPDATE person SET is_guardian=1 WHERE family_id=:family_id AND person_id=:person_id', ['family_id' => $familyId, 'person_id' => $personId]);
        return true;
    }
    public function end(int $familyId, int $personId): bool
    {
        $this->execute('UPDATE person SET is_guardian=0 WHERE family_id=:family_id AND person_id=:person_id', ['family_id' => $familyId, 'person_id' => $personId]);
        return true;
    }
}
