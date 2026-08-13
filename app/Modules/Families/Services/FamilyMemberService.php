<?php

use function PHPSTORM_META\type;

class FamilyMemberService
{

	private FamilyMemberRepository $memberRepository;
	private FamilyRepository $familyRepository;

	public function __construct()
	{
		$this->memberRepository = new FamilyMemberRepository();
		$this->familyRepository = new FamilyRepository();
	}

	// Register a new family member
	public function registerFamilyMember($familyId, $personData)
	{
		// Validate family existence
		$family = $this->familyRepository->findById($familyId);
		if (!$family) {
			throw new Exception('Family not found.');
		}
		$rowCount = $this->memberRepository->createMember(['family_id' => $familyId, ...$personData]);

		if ($rowCount !== 1) {
			throw new Exception('Failed to create person record.');
		}
		return $rowCount;
	}

	// update family member
	public function updateFamilyMember($memberId, $personData): int
	{
		$rowCount = $this->memberRepository->updateMember(['person_id' => $memberId, ...$personData]);
		if ($rowCount < 0) {
			throw new Exception('Failed to update person record.');
		}
		return $rowCount;
	}

	// Get all family members of a family
	public function getAllFamilyMembers(int $familyId): array
	{
		return $this->memberRepository->findAllByFamilyId($familyId);
	}

	// Get family member details by id
	public function getFamilyMemberById(int $memberId): ?array
	{
		return $this->memberRepository->findById($memberId);
	}

	// Get family details by id
	public function getFamilyById(int $familyId): ?array
	{
		return $this->familyRepository->findById($familyId);
	}

	//check whether a member is a member of a family
	public function isMemberOfFamily(int $memberId, int $familyId): bool
	{

		return ($this->memberRepository->isMemberOfFamily($memberId, $familyId) === 1);
	}

	// Get all person roles
	public function getPersonRoles()
	{
		return $this->memberRepository->findPersonRoles();
	}
}
