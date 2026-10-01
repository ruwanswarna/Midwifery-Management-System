<?php
declare(strict_types=1);
class FamilyService
{
	private FamilyRepository $repository;
	private FamilyMemberRepository $memberRepository;
	private PHMAreaRepository $phmAreaRepository;
	public function __construct()
	{
		$this->repository = new FamilyRepository();
		$this->memberRepository = new FamilyMemberRepository();
		$this->phmAreaRepository = new PHMAreaRepository();
	}
	// Get family registry with pagination
	public function getRegistry(array $queryParams): array
	{
		// get page prameter from query parameters and validate
		// integer and default to 1, minimum of 1
		$page = filter_var(
			$queryParams['page'] ?? 1,
			FILTER_VALIDATE_INT,
			[
				'options' => [
					'default' => 1,
					'min_range' => 1
				]
			]
		);
		$recordsPerPage = 20;
		$totalRecords = $this->repository->countRegistry();
		$totalPages = max(1, (int) ceil($totalRecords / $recordsPerPage));
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $recordsPerPage;
		return [
			'families' => $this->repository->findRegistry([], $recordsPerPage, $offset),
			'pagination' => [
				'currentPage' => $page,
				'recordsPerPage' => $recordsPerPage,
				'totalRecords' => $totalRecords,
				'totalPages' => $totalPages,
				'from' => $totalRecords === 0 ? 0 : $offset + 1,
				'to' => min($offset + $recordsPerPage, $totalRecords),

			]
		];
	}

	// Get registry all without pagination
	public function getAllRegistry(): array
	{
		return $this->repository->findRegistry([], PHP_INT_MAX, 0);
		// PHP_INT_MAX is used to fetch all records without pagination. hold maximum integer value for int type
	}
	// Get family profile by ID
	public function getFamilyProfile($id)
	{
		$family = $this->repository->findProfile($id);
		if ($family === null) {
			return null;
		}

		return [
			'family' => $family,
			'family_members' => $this->repository->findMembers($id),
			'summary' => $this->repository->findProfileSummary($id)
		];
	}

	public function countFamilies(){
		
		return $this->repository->countRegistry();
	}

	// Register a new family
	public function registerFamily(array $familyData, array $contactPersonData): array
	{
		$db = Database::getDBConnection();
		$db->beginTransaction();
		try {

			// create new registration number for the family
			$newRegistrationNumber = $this->generateRegistrationNumber();
			$familyData['registration_number'] = $newRegistrationNumber;

			// get the current date for registered_date
			$familyData['registered_date'] = date('Y-m-d');

			$rowCount = $this->repository->createFamily($familyData);
			if ($rowCount !== 1) {
				throw new Exception('Failed to create family record.');
			}
			$familyId = (int) $db->lastInsertId();

			$rowCount = $this->memberRepository->createMember([...$contactPersonData, 'family_id' => $familyId, 'person_role_id' => 1]); // Assuming 1 is the role ID for contact person - Always Mother
			if ($rowCount !== 1) {
				throw new Exception('Failed to create family record.');
			}
			$personId = (int) $db->lastInsertId();

			$rowCount = $this->repository->setContactPerson($familyId, $personId);
			if ($rowCount !== 1) {
				throw new Exception('Failed to create family record.');
			}

			$db->commit();
			return ['family_id' => $familyId, 'contact_person_id' => $personId];
		} catch (Exception $e) {
			if ($db->inTransaction()) {
				$db->rollBack();
			}
			throw $e;
		}
	}

	// Get all PHM areas for the family registration form
	public function getPHMAreas(): array
	{
		return $this->phmAreaRepository->findAllHtmlSelect();
	}

	// Get family by id
	public function getFamilyById(int $id)
	{
		return $this->repository->findById($id);
	}

	public function getById(int $id): ?array
	{
		return $this->repository->findById($id);
	}

	public function update(int $id, array $data): bool
	{
		if ($this->repository->findById($id) === null) return false;
		if ((int)($data['phm_area_id']??0)<1 || trim((string)($data['address']??''))==='') {
			$_SESSION['errors']=['Complete the PHM area and address.'];
			$_SESSION['familyData']=$data;
			return false;
		}
		return $this->repository->updateFamily($id,$data);
	}

	public function delete(int $id): bool
	{
		return $this->repository->findById($id)!==null && $this->repository->archiveFamily($id);
	}

	// generate new registration number
	private function generateRegistrationNumber(): string
	{
		$lastRegistrationNumber =
			$this->repository->findLastRegistrationNumber();

		if ($lastRegistrationNumber === null) {
			return 'FAM000001';
		}
		$nextNumber = (int) substr($lastRegistrationNumber, 3) + 1;

		$registrationNumber = sprintf('FAM%06d', $nextNumber);

		return $registrationNumber;
	}
}
