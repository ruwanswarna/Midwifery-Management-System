<?php

declare(strict_types=1);

class ClinicRepository extends Repository
{
    public function getAll(): array
    {
        return $this->findAll(
            'SELECT cs.*, m.moh_name,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS conducted_by_name,
                    COUNT(ca.appointment_id) AS appointment_count
             FROM clinic_session cs
             INNER JOIN moh_area m ON m.moh_area_id = cs.moh_area_id
             INNER JOIN staff s ON s.staff_id = cs.conducted_by
             LEFT JOIN clinic_appointment ca ON ca.clinic_session_id = cs.clinic_session_id
             GROUP BY cs.clinic_session_id
             ORDER BY cs.clinic_date DESC, cs.start_time DESC'
        );
    }

    public function findById(int $id): ?array
    {
        return $this->findOne(
            'SELECT cs.*, m.moh_name,
                    CONCAT_WS(" ", s.first_name, s.middle_name, s.last_name) AS conducted_by_name
             FROM clinic_session cs
             INNER JOIN moh_area m ON m.moh_area_id = cs.moh_area_id
             INNER JOIN staff s ON s.staff_id = cs.conducted_by
             WHERE cs.clinic_session_id = :id',
            ['id' => $id]
        );
    }

    public function getMohAreas(): array
    {
        return $this->findAll('SELECT moh_area_id, moh_name FROM moh_area ORDER BY moh_name');
    }

    public function getActiveStaff(): array
    {
        return $this->findAll(
            'SELECT staff_id, employee_number,
                    CONCAT_WS(" ", first_name, middle_name, last_name) AS full_name
             FROM staff WHERE status = "Active" ORDER BY first_name, last_name'
        );
    }

    public function create(array $data): int
    {
        $this->execute(
            'INSERT INTO clinic_session
             (moh_area_id, conducted_by, session_type, clinic_date, start_time,
              end_time, location, maximum_capacity, remarks)
             VALUES (:moh_area_id, :conducted_by, :session_type, :clinic_date,
                     :start_time, :end_time, :location, :maximum_capacity, :remarks)',
            $this->params($data)
        );
        return $this->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $params = $this->params($data);
        $params['id'] = $id;
        $this->execute(
            'UPDATE clinic_session SET moh_area_id=:moh_area_id, conducted_by=:conducted_by,
             session_type=:session_type, clinic_date=:clinic_date, start_time=:start_time,
             end_time=:end_time, location=:location, maximum_capacity=:maximum_capacity,
             remarks=:remarks WHERE clinic_session_id=:id',
            $params
        );
    }

    public function delete(int $id): void
    {
        $this->execute('DELETE FROM clinic_session WHERE clinic_session_id = :id', ['id' => $id]);
    }

    private function params(array $data): array
    {
        return [
            'moh_area_id' => (int) $data['moh_area_id'],
            'conducted_by' => (int) $data['conducted_by'],
            'session_type' => $data['session_type'],
            'clinic_date' => $data['clinic_date'],
            'start_time' => $data['start_time'] ?: null,
            'end_time' => $data['end_time'] ?: null,
            'location' => trim($data['location']),
            'maximum_capacity' => $data['maximum_capacity'] !== '' ? (int) $data['maximum_capacity'] : null,
            'remarks' => trim($data['remarks'] ?? '') ?: null,
        ];
    }
}
