<?php
class FamilyMemberRepository extends Repository
{
	public function __construct()
	{
		parent::__construct();
	}

	// Create family member
	public function createMember(array $data): int
	{	//dd($data);
		$sql = 'INSERT INTO person (family_id,person_role_id,nic, first_name, middle_name, last_name, gender,date_of_birth,phone, email, education_level, occupation, blood_group, marital_status, is_guardian, status)
				VALUES (:family_id, :person_role_id, :nic, :first_name, :middle_name, :last_name,  :gender, :date_of_birth, :phone, :email, :education_level, :occupation, :blood_group, :marital_status, :is_guardian, :status)';
		$params = [
			'family_id' => $data['family_id'],
			'person_role_id' => $data['person_role_id'],
			'nic' => $data['nic'],
			'first_name' => $data['first_name'],
			'middle_name' => $data['middle_name'],
			'last_name' => $data['last_name'],
			'gender' => $data['gender'],
			'date_of_birth' => $data['date_of_birth'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'education_level' => $data['education_level'],
			'occupation' => $data['occupation'],
			'blood_group' => $data['blood_group'] !== '' ? $data['blood_group'] : null,
			'marital_status' => $data['marital_status'],
			'is_guardian' => $data['is_guardian'],
			'status' => $data['status']
		];

		return $this->execute($sql, $params);
	}

	// Update family member
	public function updateMember(array $data): int
	{
		$sql = 'UPDATE person SET
				person_role_id = :person_role_id,
				nic = :nic,
				first_name = :first_name,
				middle_name = :middle_name,
				last_name = :last_name,
				gender = :gender,
				date_of_birth = :date_of_birth,
				phone = :phone,
				email = :email,
				education_level = :education_level,
				occupation = :occupation,
				blood_group = :blood_group,
				marital_status = :marital_status,
				is_guardian = :is_guardian,
				status = :status
				WHERE person_id = :person_id';

		$params = [
			'person_role_id' => $data['person_role_id'],
			'nic' => $data['nic'],
			'first_name' => $data['first_name'],
			'middle_name' => $data['middle_name'],
			'last_name' => $data['last_name'],
			'gender' => $data['gender'],
			'date_of_birth' => $data['date_of_birth'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'education_level' => $data['education_level'],
			'occupation' => $data['occupation'],
			'blood_group' => $data['blood_group'] !== '' ? $data['blood_group'] : null,
			'marital_status' => $data['marital_status'],
			'is_guardian' => $data['is_guardian'],
			'status' => $data['status'],
			'person_id' => $data['person_id']
		];

		return $this->execute($sql, $params);
	}
	// Get all family members of a family filtered by person roles
	public function findAllByFamilyId(
		int $familyId,
		array $personRoles = []
	): array {
		$sql = 'SELECT p.*
		,pr.role_name,
		TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) AS age 
		FROM person AS p
		INNER JOIN person_role AS pr ON pr.person_role_id = p.person_role_id
		WHERE p.family_id = :family_id';

		$params = ['family_id' => $familyId];

		if (!empty($personRoles)) {
			$placeholders = [];
			foreach ($personRoles as $index => $role) {
				$placeholder = ':role_' . $index;
				$placeholders[] = $placeholder;
				$params['role_' . $index] = $role;
			}
			$sql .= ' AND pr.role_name IN (' . implode(',', $placeholders) . ')';
		}
		return $this->findAll($sql, $params) ?? [];
	}

	// Get family member by id
	public function findById(int $id): ?array
	{
		$sql = $sql = 'SELECT p.*
		,pr.role_name,
		TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) AS age 
		FROM person AS p
		INNER JOIN person_role AS pr ON pr.person_role_id = p.person_role_id
		WHERE p.person_id = :person_id';
		return $this->findOne($sql, ['person_id' => $id]);
	}

	// Get all person roles
	public function findPersonRoles()
	{
		$sql = 'SELECT * FROM person_role';
		return $this->findAll($sql);
	}

	// check family membership
	public function isMemberOfFamily(int $memberId, int $familyId)
	{
		$sql = 'SELECT 1 FROM person WHERE person_id = :member_id AND family_id = :family_id';

		return $this->findScalar($sql, ['member_id' => $memberId, 'family_id' => $familyId]);
	}
}
