<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;

class PunchLogsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
	}
	
	public function index()
	{
	
		//$this->log($this->request->pass[0]);
		//$this->log(count($this->request->pass));
		if(count($this->request->pass) == 4){//expecting 4 parameters
			$user_id = $this->request->pass[0];
				
			$y = $this->request->pass[1];
			$m = $this->request->pass[2];
			$d = $this->request->pass[3];
			$dte = $d.'-'.$m.'-'.$y;
			$time = strtotime($dte);
				
			$from = date('Y-m-d',$time);
			$to = date('Y-m-d',strtotime("+1 days", strtotime($from)));
				
			$query = $this->PunchLogs->find('all')
			->where(['PunchLogs.user_id'=>$user_id, 'PunchLogs.log_created >= ' => $from, 'PunchLogs.log_created <='=>$to]);
			$punchLogs =  $query->all();
			foreach ($punchLogs as $punchLog){
				$time = Time::now();
				$this->log($time);
			}
				
			$this->viewBuilder()->options([
					'pdfConfig' => [
					'binary' => 'E:\programs\wkhtmltopdf\bin\wkhtmltopdf.exe', // set the correct path here
					'engine' => 'CakePdf.WkHtmlToPdf',
					//'orientation' => 'landscape',
					'filename' => 'Invoice_.pdf' ,
					//'download' => false,
						
					]
					]);
				
			//$this->RequestHandler->renderAs($this, 'pdf');
			$this->set('punchLogs',$punchLogs);
				
			$this->loadModel('Users');
			$this->set('selectedUser',$this->Users->get($user_id));
			$this->set('selectedDate',$from);
		}
	
	}
	
	public function indexPDF()
	{
		
		//$this->log($this->request->pass[0]);
		//$this->log(count($this->request->pass));
		if(count($this->request->pass) == 4){//expecting 4 parameters
			$user_id = $this->request->pass[0];
			
			$y = $this->request->pass[1];
			$m = $this->request->pass[2];
			$d = $this->request->pass[3];
			$dte = $d.'-'.$m.'-'.$y;
			$time = strtotime($dte);
			
			$from = date('Y-m-d',$time);
			$to = date('Y-m-d',strtotime("+1 days", strtotime($from)));
			
			$query = $this->PunchLogs->find('all')
				->where(['PunchLogs.user_id'=>$user_id, 'PunchLogs.log_created >= ' => $from, 'PunchLogs.log_created <='=>$to]);
			$punchLogs =  $query->all();
			foreach ($punchLogs as $punchLog){
				$time = Time::now();
				$this->log($time);
			}
			
			$this->viewBuilder()->options([
						'pdfConfig' => [
					'binary' => 'E:\programs\wkhtmltopdf\bin\wkhtmltopdf.exe', // set the correct path here
							'engine' => 'CakePdf.WkHtmlToPdf',
							//'orientation' => 'landscape',
							'filename' => 'Invoice_.pdf' ,
							//'download' => false,
							
						]
					]);
			
			$this->RequestHandler->renderAs($this, 'pdf');
			$this->set('punchLogs',$punchLogs);
			
			$this->loadModel('Users');
			$this->set('selectedUser',$this->Users->get($user_id));
			$this->set('selectedDate',$from);
		}
		
	}
}