<?php
namespace App\Controller;

use App\Controller\AppController;

class AdminController extends AppController
{
	public function index(){
		$this->loadModel('StandardShifts');
		$standardShiftsQuery = $this->StandardShifts->find('all');
		$this->set('standardShifts', $standardShiftsQuery->all());
		
		$this->loadModel('StandardDayOffs');
		$standardDayOffsQuery = $this->StandardDayOffs->find('all');
		$this->set('standardDayOffs', $standardDayOffsQuery->all());
		
		//Maintenance Data
		$this->loadModel('Departments');
		$departmentsQuery = $this->Departments->find('all');
		$this->set('departments', $departmentsQuery->all());
		$this->set('departments_JSON', json_encode($departmentsQuery->all()));
		
		$this->loadModel('Positions');
		$positionsQuery = $this->Positions->find('all')
			->contain(['Departments']);
		$this->set('positions', $positionsQuery->all());
		
		$this->loadModel('Agencies');
		$agenciesQuery = $this->Agencies->find('all');
		
		$this->set('agencies', $agenciesQuery->all());
	}
	
	
}