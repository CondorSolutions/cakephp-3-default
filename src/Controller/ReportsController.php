<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

class ReportsController extends AppController
{
	
	
	public function index(){
		$this->loadModel('Users');
		$usersQuery = $this->Users->find('all');
		$this->set('users',$usersQuery->all());
		
		$this->loadModel('Departments');
		$departmentsQuery = $this->Departments->find('list');
		$this->set('departmentList', $departmentsQuery->toArray());
		
		$this->loadModel('Positions');
		$positionsQuery = $this->Positions->find('list');
		$this->set('positionList', $positionsQuery->toArray());
		
		$this->loadModel('Agencies');
		$agenciesQuery = $this->Agencies->find('list');
		$this->set('agencyList', $agenciesQuery->toArray());
	}
	
	
	public function ajaxGetPunchLogs(){
		$date1 = new \DateTime(str_replace(".", "-",$this->request->data['from']));
		$date2 = new \DateTime(str_replace(".", "-",$this->request->data['to']));
		//$interval = $date1->diff($date2);
		/* $this->log($interval);
		$this->log($interval->days);
		 */
		$interval = \DateInterval::createFromDateString('1 day');
		$period = new \DatePeriod($date1, $interval, $date2->modify('+1 day'));
		
		/* foreach ( $period as $dt )
			$this->log($dt->format( "l Y-m-d H:i:s\n" )); */
			//echo $dt->format( "l Y-m-d H:i:s\n" );
		
		
		$this->loadModel('PunchLogs');
		$punchLogsQuery = $this->PunchLogs->find('all')
			->where(['PunchLogs.user_id'=>$this->request->data['user_id'], 'PunchLogs.log_created >='=>$this->request->data['from'], 'PunchLogs.log_created <='=>$this->request->data['to']]);
		
		$dates = array();
		foreach ( $period as $dt ){
			$strip = $dt->format('Y-m-d');
			$dates[$strip] = array();
		}
		
		foreach ($punchLogsQuery->all() as $punchLog){
			//$this->log($punchLog->log_created->format('Y-m-d'));
			 foreach ( $period as $dt ){
				 $strip = $dt->format('Y-m-d');
				/*$this->log($dt->format( "l Y-m-d H:i:s\n" )); */
				if($strip ==$punchLog->log_created->format('Y-m-d') ){
					array_push($dates[$strip], $punchLog);
				}
			} 
		} 
		
		$dataDates = array();
		foreach ($dates as $date=>$punchLogs){
			//First In
			foreach ($punchLogs as $punchLog){
				if($punchLog->is_log_in){
					$dataDates[$date]['first_in'] = $punchLog;
					break;
				}
			}
			//Last Out
			if(count($punchLogs)>2){
				$lastOut = $punchLogs[count($punchLogs)-1];
				if($lastOut->is_log_in)
					$lastOut = $punchLogs[count($punchLogs)-2];
				$dataDates[$date]['last_out'] = $lastOut;
			}
			
		}
		$this->log($dataDates);
		$this->set('dates', json_encode($dataDates));
	}
	
	public function reportCreator(){
		/* $from = "2016.07.01";
		$to = "2016.07.07";
		$user_id = "1"; */
		$user_id = $this->request->pass[0];
		$from = $this->request->pass[1];
		$to = $this->request->pass[2];
		
		
		$this->loadModel('Users');
		$usersQuery = $this->Users->findById($user_id);
		$this->set('user', $usersQuery->first());
		
		$dateFrom = new \DateTime(str_replace(".", "-",$from));//$this->request->data['from']
		$this->set('dateFrom', $dateFrom->format('Y-m-d'));
		$dateTo = new \DateTime(str_replace(".", "-",$to));
		$this->set('dateTo', $dateTo->format('Y-m-d'));
		
		$interval = \DateInterval::createFromDateString('1 day');
		$period = new \DatePeriod($dateFrom, $interval, $dateTo->modify('+1 day'));
		$dates = array();
		$dateShifts = array();
		foreach ( $period as $dt ){
			$strip = $dt->format('Y-m-d');
			$dates[$strip] = array();
			$dateShifts[$strip] = $this->_getShift($user_id, $strip);
		}
		$this->loadModel('PunchLogs');
		$punchLogsQuery = $this->PunchLogs->find('all')
			->where(['PunchLogs.user_id'=>$user_id, 'PunchLogs.log_created >='=>$from, 'PunchLogs.log_created <='=>$to]);
		
		foreach ($punchLogsQuery->all() as $punchLog){
			//$this->log($punchLog->log_created->format('Y-m-d'));
			foreach ( $period as $dt ){
				$strip = $dt->format('Y-m-d');
				if($strip ==$punchLog->log_created->format('Y-m-d') ){
					array_push($dates[$strip], $punchLog);
				}
			}
		}
		
		$filledDates = array();
		foreach ($dates as $date=>$punchLogs){
			//First In
			$first_in = null;
			foreach ($punchLogs as $punchLog){
				if($punchLog->is_log_in){
					$first_in = $punchLog;
					$filledDates[$date]['first_in'] =$first_in ;
					break;
				}
			}
			//Last Out
			$lastOut = null;
			if(count($punchLogs)>1){//must consider half shift
				$lastOut = $punchLogs[count($punchLogs)-1];
				if($lastOut->is_log_in)
					$lastOut = $punchLogs[count($punchLogs)-2];
				$filledDates[$date]['last_out'] = $lastOut;
			}
			//First Out and Second In
			$inBetweenCount = 0;
			$firstInFound = false;
			if($first_in!=null&&$lastOut!=null){
				foreach ($punchLogs as $punchLog){
					if($punchLog->id ==$first_in->id ){
						$firstInFound = true;
						continue;
					}
					if($punchLog->id == $lastOut->id)
						break;
					if($firstInFound)
						$inBetweenCount ++;
				}
			}
			
			
			$firstOut = null;
			$secondIn = null;
			if($inBetweenCount==2){
				$firstInFound = false;
				if($first_in!=null&&$lastOut!=null){
					foreach ($punchLogs as $punchLog){
						if($punchLog->id ==$first_in->id ){
							$firstInFound = true;
							continue;
						}
						if($punchLog->id == $lastOut->id)
							break;
						if($firstInFound){
							if($firstOut == null && !$punchLog->is_log_in){
								$firstOut = $punchLog;
							}
							elseif($punchLog->is_log_in){
								$secondIn = $punchLog;
							}
						}
							$inBetweenCount ++;
					}
				}
				$filledDates[$date]['first_out'] = $firstOut;
				$filledDates[$date]['second_in'] = $secondIn;
			}
			//$this->log($date . ': inBetweenCount = '.$inBetweenCount);
		}
		
		
		//$this->log($filledDates);
		$this->set('dates',$dates);
		$this->set('datesJSON', json_encode($dates));
		$this->set('filledDates', json_encode($filledDates));
		$this->set('dateShifts', json_encode($dateShifts));
	}
	
	public function generateReportCreator(){
		//$this->log($this->request->data);
		
		$dateFrom = new \DateTime($this->request->data['date_from']);
		$this->set('dateFrom', $dateFrom->format('Y-m-d'));
		$dateTo = new \DateTime($this->request->data['date_to']);
		$this->set('dateTo', $dateTo->format('Y-m-d'));
		
		$this->loadModel('PunchLogs');
		$punchLogsQuery = $this->PunchLogs->find('list',[
		    'keyField' => 'id',
		    'valueField' => 'log_created'
		])
		->where(['PunchLogs.user_id'=>$this->request->data['user_id'], 'PunchLogs.log_created >='=>$this->request->data['date_from'], 'PunchLogs.log_created <='=>$this->request->data['date_to']]);
		
		$punchLogs = $punchLogsQuery->toArray();
		
		$interval = \DateInterval::createFromDateString('1 day');
		$period = new \DatePeriod($dateFrom, $interval, $dateTo->modify('+1 day'));
		
		$rows = array();
		foreach ( $period as $dt ){
			$strip = $dt->format('Y-m-d');
			//$this->log($strip);
			$row = array();
			array_push($row, d($strip));
			array_push($row, $this->request->data['shift_' . $strip]);
			(isset($this->request->data[$strip . '_first_in'])&&$this->request->data[$strip . '_first_in']!=0) 			? array_push($row, $punchLogs[$this->request->data[$strip . '_first_in']]->format('H:i'))		:array_push($row, '');
			(isset($this->request->data[$strip . '_first_out'])&&$this->request->data[$strip . '_first_out']!=0) 		? array_push($row, $punchLogs[$this->request->data[$strip . '_first_out']]->format('H:i'))	:array_push($row, '');
			(isset($this->request->data[$strip . '_second_in'])&&$this->request->data[$strip . '_second_in']!=0) 	? array_push($row, $punchLogs[$this->request->data[$strip . '_second_in']]->format('H:i'))	:array_push($row, '');
			(isset($this->request->data[$strip . '_last_out'])&&$this->request->data[$strip . '_last_out']!=0) 		? array_push($row, $punchLogs[$this->request->data[$strip . '_last_out']]->format('H:i'))		:array_push($row, '');
			(isset($this->request->data['late_minutes_'.$strip]))	? array_push($row, $this->request->data['late_minutes_'.$strip])							:array_push($row, '');
			(isset($this->request->data['input_ot_start_'.$strip]))? array_push($row, $this->request->data['input_ot_start_'.$strip])							:array_push($row, '');
			(isset($this->request->data['input_ot_end_'.$strip]))	? array_push($row, $this->request->data['input_ot_end_'.$strip])							:array_push($row, '');
			(isset($this->request->data['ot_hours_'.$strip]))			? array_push($row, $this->request->data['ot_hours_'.$strip])									:array_push($row, '');
			(isset($this->request->data['ot_reason_'.$strip]))		? array_push($row, $this->request->data['ot_reason_'.$strip])									:array_push($row, '');
			
			array_push($rows, $row);
		}
		
		$data = [
	        ['Employee:', $this->request->data['last_name'] . ', '. $this->request->data['first_name']],
	        ['Period:', d($this->request->data['date_from'] ). ' to '.  d($this->request->data['date_to'] )],
	        ['', '', 				 'Morning',''				, 'Afternoon',''			 ,'Lates'	,'Overtime','','# of'		 , ''],
	        ['Date', 'Shift', 'Time In','Time Out', 'Time In','Time Out','(mins.)','Start','End','Hours OT', 'Reason for OT'],
	    ];
		
		foreach ($rows as $rowK=>$rowV){
			array_push($data,$rowV);
		}
		array_push($data,[
				"Totals: " . $this->request->data['input_days_total'] . ' days','','','','',
				"Total Lates: ", $this->request->data['input_lates_total'],'',
				"Total OT: ", $this->request->data['input_ot_total'],
			]
		);
		//$this->log($data);
	    $_serialize = 'data';
	
	    if($this->request->data['file_format']=='csv'){
	    	$filename = $this->request->data['last_name'] . '_'. $this->request->data['first_name'] . '_';
	    	$filename .= $dateFrom->format('Y-m-d') . '_to_' . $dateTo->format('Y-m-d');
	    	$filename .= '.csv';
	    	$this->response->download($filename); // <= setting the file name
	    	$this->viewBuilder()->className('CsvView.Csv');
	    }
	    else if($this->request->data['file_format']=='pdf'){
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
	    	$this->set('request_data',$this->request->data);
	    }
	    else{
	    	//html
	    }
	    
	    $this->set(compact('data', '_serialize'));
	}
	
	
	private function _getShift($user_id, $date){
		$dayShift = array();
		$date_arr = explode("-", $date);
		$year = $date_arr[0];
		 $month=$date_arr[1];
		 $day  = $date_arr[2];
		//$date =$year . '/'. $month .'/'.$day;
		/* $this->log($date);
		 $this->log(date('N', mktime(0, 0, 0, $month, $day, $year))); */
		//A. Day Offs
		//A.2. Custom Repeating Offs
		$this->loadModel('DayOffs');
		$dayOffsQuery = $this->DayOffs->find('all')
		->where(['DayOffs.user_id'=>$user_id, 'DayOffs.date is'=>null])
		->contain(['Repeats']);
		$customRepeatingDayOffs = $dayOffsQuery->all();
		$userCustomRepeatingDayOff = null;
		//$this->log($customRepeatingDayOffs);
		foreach ($customRepeatingDayOffs as $customRepeatingDayOff){
			//$this->log($customRepeatingDayOff->repeat);
			for($i = 1; $i <= 7; $i++){
				if(date('N', mktime(0, 0, 0, $month, $day, $year)) == $i && $customRepeatingDayOff->repeat['day_' . $i] ==1 )
					$userCustomRepeatingDayOff = $customRepeatingDayOff;
			}
		}
		if($userCustomRepeatingDayOff != null){
			$dayShift['day_off'] = $userCustomRepeatingDayOff;
		}
		else {//check standard day off
			$this->loadModel('UsersStandardDayOffs');
			$usersStandardDayOffsQuery = $this->UsersStandardDayOffs->find('all')
			->where(['UsersStandardDayOffs.user_id'=>$user_id])
			->contain(['StandardDayOffs']);
			$usersStandardDayOffs = $usersStandardDayOffsQuery->all();
			foreach ($usersStandardDayOffs as $usersStandardDayOff){
				if($usersStandardDayOff->standard_day_off->day != null){//weekly
					if(date('N', mktime(0, 0, 0, $month, $day, $year))==$usersStandardDayOff->standard_day_off->day){
						$dayShift['day_off'] = $usersStandardDayOff;
					}
				}
				else{//holidays
					if(date('n/j/y', mktime(0, 0, 0, $month, $day, $year)) == date($usersStandardDayOff->standard_day_off->date)){//off found
						$dayShift['day_off'] = $usersStandardDayOff;
					}
				}
			}
		}
		 
		$this->loadModel('Shifts');
		if(!isset($dayShift['day_off'])){
			//-----
			$shiftsQuery = $this->Shifts->find('all')
			->where(['Shifts.user_id'=>$user_id, 'Shifts.date is'=>null])
			->contain(['Repeats']);
			$customRepeatingShifts = $shiftsQuery->all();
			$usercustomRepeatingShifts = array();
			foreach ($customRepeatingShifts as $customRepeatingShift){
				for($i = 1; $i <= 7; $i++){
					if(date('N', mktime(0, 0, 0, $month, $day, $year)) == $i && $customRepeatingShift->repeat['day_' . $i] ==1 )
						array_push($usercustomRepeatingShifts,$customRepeatingShift);
				}
			}
			if(count($usercustomRepeatingShifts)>0){
				$dayShift['shifts'] = $usercustomRepeatingShifts;
			}
			else{//check standard shifts
				$this->loadModel('UsersStandardShifts');
				$usersStandardShiftsQuery = $this->UsersStandardShifts->find('all')
				->where(['UsersStandardShifts.user_id'=>$user_id])
				->contain(['StandardShifts']);
				$usersStandardShifts = $usersStandardShiftsQuery->all();
				$usersStandardShiftsArray = array();
				foreach ($usersStandardShifts as $usersStandardShift){
					array_push($usersStandardShiftsArray, $usersStandardShift);
				}
				$dayShift['shifts'] = $usersStandardShiftsArray;
			}
		}
		 
		//override with special shift
		$shiftsQuery = $this->Shifts->find('all')
		->where(['Shifts.user_id'=>$user_id, 'Shifts.date'=>$date]);
		$specialShifts = $shiftsQuery->all();
		if(count($specialShifts) > 0){
			unset($dayShift['day_off']);
			$dayShift['shifts'] = $specialShifts;
		}
		 
		//override with special day off
		$dayOffsQuery = $this->DayOffs->find('all')
		->where(['DayOffs.user_id'=>$user_id, 'DayOffs.date'=>$date]);
		$specialDayOffs = $dayOffsQuery->first();
		if(count($specialDayOffs) > 0){
			unset($dayShift['shifts']);
			$dayShift['day_off'] = $specialDayOffs;
		}
		
		//$this->log($dayShift);
		return $dayShift;
	}
}