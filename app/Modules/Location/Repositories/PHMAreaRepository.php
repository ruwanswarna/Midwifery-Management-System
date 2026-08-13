<?php
class PHMAreaRepository extends Repository
{
	public function __construct()
	{
		parent::__construct();
	}
	public function findAllHtmlSelect()
	{
		$sql = "SELECT 
		phm.phm_area_id,
		phm.phm_area_name,
		moh.moh_name,
		dist.district_name 
		FROM phm_area AS phm 
		INNER JOIN moh_area AS moh ON phm.moh_area_id = moh.moh_area_id 
		INNER JOIN district AS dist ON moh.district_id = dist.district_id
		ORDER BY dist.district_name, moh.moh_name, phm.phm_area_name";
		return $this->findAll($sql);
	}
}
