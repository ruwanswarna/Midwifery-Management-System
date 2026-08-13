<?php
class FamilyRepository extends Repository
{

	public function __construct()
	{
		parent::__construct();
	}

	public function findRegistry(
		array $filters = [],
		int $limit = 20,
		int $offset = 0
	) {
		$sql = 'SELECT 
		f.family_id, 
		f.registration_number, 
		f.address, 
		f.status, 
		f.registered_date, 
		p.phm_area_name AS phm_area
		FROM family AS f 
		INNER JOIN phm_area AS p ON f.phm_area_id = p.phm_area_id  
		LIMIT :limit OFFSET :offset';
		return $this->findAll($sql, ['limit' => $limit, 'offset' => $offset]);
	}

	public function findRecentActivity(int $limitDays): array
	{
		$sql = '
        SELECT
            family_id,
			registration_number,
			address,
			registered_date,
			created_at

        FROM family
        WHERE registered_date >= DATE_SUB(CURDATE(), INTERVAL :limitDays DAY)
        ORDER BY registered_date DESC
    	';
		$params = [
			'limitDays' => $limitDays
		];

		return $this->findAll($sql, $params);
	}

	public function findProfile($id): ?array
	{
		$sql1 = 'SELECT f.*,
		p.phm_area_name AS phm_name,
		COUNT(DISTINCT pe.person_id) AS member_count,
		SUM(
                    CASE
                        WHEN pe.date_of_birth IS NOT NULL
                         AND TIMESTAMPDIFF(
                                YEAR,
                                pe.date_of_birth,
                                CURDATE()
                             ) < 5
                        THEN 1
                        ELSE 0
                    END
                ) AS under_five_count
		FROM family AS f
		INNER JOIN phm_area AS p ON f.phm_area_id = p.phm_area_id
		LEFT JOIN person AS pe ON f.family_id = pe.family_id
		WHERE f.family_id = :id
		GROUP BY f.family_id';

		$sql2 = 'SELECT p.phone
					FROM person AS p
					WHERE p.family_id = :id
					AND p.phone IS NOT NULL';
		$family = $this->findOne($sql1, ['id' => $id]);
		if ($family === null) {
			return null;
		}
		$contacts = $this->findAll($sql2, ['id' => $id]);
		$family['contacts'] = array_column($contacts, 'phone'); // get only phone numbers from associative array
		return $family;
	}

	public function findProfileSummary(int $id): array
	{
		$sql = ' SELECT
                (
                    SELECT COUNT(*)
                    FROM pregnancy AS preg
                    INNER JOIN person AS p
                        ON p.person_id = preg.mother_id
                    WHERE p.family_id = :pregnancy_fid
                ) AS total_pregnancies,
				(
                    SELECT COUNT(*)
                    FROM child AS ch
                    INNER JOIN person AS p
                        ON p.person_id = ch.person_id
                    WHERE p.family_id = :child_fid
				) AS registered_children,
				(
                    SELECT MAX(fv.visit_date)
                    FROM field_visit AS fv
                    WHERE fv.family_id = :visit_fid
                ) AS latest_field_visit_date';

		return $this->findOne($sql, ['pregnancy_fid' => $id, 'child_fid' => $id, 'visit_fid' => $id]);
	}

	public function findMembers($id)
	{
		$sql = 'SELECT p.*,pr.role_name AS person_role,
		CONCAT_WS(" ", p.first_name,CONCAT(LEFT(p.middle_name,1),"."),p.last_name) AS full_name,
		TIMESTAMPDIFF(
            YEAR,
            p.date_of_birth,
            CURDATE()
        ) AS age,
		CASE
            WHEN ch.person_id IS NOT NULL THEN 1
            ELSE 0
        END AS is_registered_child,
		CASE
            WHEN EXISTS (
            SELECT 1
            FROM pregnancy AS preg
                WHERE preg.mother_id = p.person_id
                    AND preg.current_status = "Ongoing"
            )
            THEN 1
            ELSE 0      
        END AS has_active_pregnancy,
		(
            SELECT COUNT(*)
            FROM pregnancy AS preg
            WHERE preg.mother_id = p.person_id
        ) AS pregnancy_count
		FROM person AS p
		INNER JOIN person_role AS pr ON p.person_role_id = pr.person_role_id
		LEFT JOIN child AS ch ON p.person_id = ch.person_id  WHERE p.family_id = :id
		ORDER BY p.first_name';
		return $this->findAll($sql, ['id' => $id]);
	}

	public function createFamily(array $data): int
	{

		$sql = 'INSERT INTO family (phm_area_id, address, registration_number, registered_date, status)
				VALUES (:phm_area_id, :address, :registration_number, :registered_date, :status)';
		$params = [
			'phm_area_id' => $data['phm_area_id'],
			'address' => $data['address'],
			'registration_number' => $data['registration_number'],
			'registered_date' => $data['registered_date'],
			'status' => $data['status']
		];
		return $this->execute($sql, $params);
	}

	public function setContactPerson(int $familyId, int $personId): int
	{
		$sql = 'UPDATE family SET contact_person_id = :person_id WHERE family_id = :family_id';
		$params = [
			'person_id' => $personId,
			'family_id' => $familyId
		];
		return $this->execute($sql, $params);
	}

	public function findById($id)
	{
		$sql = 'SELECT * FROM family WHERE family_id = :id';
		return $this->findOne($sql, ['id' => $id]);
	}

	public function updateFamily(int $id, array $data): bool
	{
		$this->execute('UPDATE family SET phm_area_id=:phm_area_id,address=:address,status=:status,remarks=:remarks WHERE family_id=:id', [
			'id' => $id,
			'phm_area_id' => (int)$data['phm_area_id'],
			'address' => trim((string)$data['address']),
			'status' => $data['status'] ?? 'Active',
			'remarks' => trim((string)($data['remarks'] ?? '')) ?: null,
		]);
		return true;
	}

	public function archiveFamily(int $id): bool
	{
		$this->execute('UPDATE family SET status="Inactive" WHERE family_id=:id', ['id' => $id]);
		return true;
	}

	// Count families in the registry, optionally filtered by a time period, provide the period as 'week', 'month', or 'year' and set $prevPeriod to true for the previous period.
	public function countRegistry(
		?string $period = null,
		bool $prevPeriod = false
	): int {
		$sql = 'SELECT COUNT(*) FROM family';
		$params = [];

		if ($period !== null) {
			$start = null;
			$end = null;
			switch ($period) {
				case 'week':
					$start = $prevPeriod
						? date('Y-m-d', strtotime('monday last week')) : date('Y-m-d', strtotime('monday this week'));
					$end = $prevPeriod
						? date('Y-m-d', strtotime('monday this week')) : date('Y-m-d', strtotime('monday next week'));
					break;
				case 'month':
					$start = $prevPeriod
						? date('Y-m-d', strtotime('first day of last month'))
						: date('Y-m-d', strtotime('first day of this month'));

					$end = $prevPeriod
						? date('Y-m-d', strtotime('first day of this month'))
						: date('Y-m-d', strtotime('first day of next month'));
					break;
				case 'year':
					$start = $prevPeriod
						? date('Y-m-d', strtotime('first day of last year'))
						: date('Y-m-d', strtotime('first day of this year'));

					$end = $prevPeriod
						? date('Y-m-d', strtotime('first day of this year'))
						: date('Y-m-d', strtotime('first day of next year'));
					break;

				default:
					return $this->findScalar($sql);
			}
			$sql .= ' WHERE registered_date >= :start AND registered_date < :end';
			$params = [
				':start' => $start,
				':end' => $end
			];
			return $this->findScalar($sql, $params);
		} else return $this->findScalar($sql, $params);
	}

	public function findLastRegistrationNumber(): ?string
	{
		$sql = "
        SELECT registration_number
        FROM family
        ORDER BY family_id DESC
        LIMIT 1
    	";

		$registrationNumber = $this->findScalar($sql);

		return (string) $registrationNumber;
	}
}
