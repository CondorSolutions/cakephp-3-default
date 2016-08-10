<?= $this->Html->script('user_calendar.js') ?>
<h1 class="text-light">Calendar<span class="mif-calendar place-right"></span></h1>
<hr class="thin bg-grayLighter">
<h3 id="full_name"><?= $user->full_name?></h3>
<hr class="thin bg-grayLighter">
<div class="flex-grid demo-grid">
	<div class="row">
		<div class="cell size3"><!-- LEFT -->
			<div class="calendar-container">
				<div class="calendar" data-role="calendar" data-day-click="day_click"></div>
			</div>
		</div>
		
		<div class="cell size6"><!-- CENTER -->
			<div id="days-container"  ><!-- style="max-height: 300px; overflow: scroll; overflow-x: hidden;" -->
				
			</div>
		</div>
		
		<div class="cell size3" style="padding-left: 10px;"><!-- RIGHT -->
			<div class="right-panel-container">
				<h4 class="fg-green">Standard Shifts</h4>
				<div id="standard-shift-container">
					<!-- Standard Shifts -->
				</div>
				<div id="">
					<a href="javascript:void(0)"><button class="button primary mini-button" onclick="showAddStandardShift();"><span class="mif-plus"></span> Add Standard Shifts</button></a>
				</div>
				<hr class="thin bg-grayLighter">
				<!-- temp disabled for TMM
				<h4 class="fg-green">Custom Repeating Shifts</h4>
				<div id="custom-repeating-shift-container">
					
				</div>
				<div id="">
					<a href="javascript:void(0)"><button class="button primary mini-button" onclick="showAddCustomRepeatingShift();"><span class="mif-plus"></span> Add Custom Repeating Shifts</button></a>
				</div>
				<hr class="thin bg-grayLighter">
				 -->
				 <!-- temp disabled for TMM
				<div id="special-shift-container">

				</div>
				<div id="">
					<a href="javascript:void(0)"><button class="button primary mini-button" onclick="showAddSpecialShifts();"><span class="mif-plus"></span> Add Special Shifts</button></a>
				</div>
				<hr class="bg-black">
				 -->
				 
				<h4 class="fg-red">Standard Day Offs</h4>
				<div id="standard-day-offs-container">
					<!-- Standard Day Offs -->
				</div>
				<div id="">
					<a href="javascript:void(0)"><button class="button primary mini-button" onclick="showAddStandardDayOffs();"><span class="mif-plus"></span> Add Standard Day Offs</button></a>
				</div>
				<hr class="thin bg-grayLighter">
				<!-- temp disabled for TMM
				<h4 class="fg-red">Custom Repeating Day Offs</h4>
				<div id="custom-repeating-day-off-container">
					
				</div>
				
				<div id="">
					<a href="javascript:void(0)"><button class="button primary mini-button" onclick="showAddCustomRepeatingDayOff();"><span class="mif-plus"></span> Add Custom Repeating Day Off</button></a>
				</div>
				<hr class="thin bg-grayLighter">
				 -->
				 <!-- temp disabled for TMM
				<div id="special-day-off-container">

				</div>
				<div id="">
					<a href="javascript:void(0)"><button class="button primary mini-button" onclick="showAddSpecialDayOffs();"><span class="mif-plus"></span> Add Special Day Offs</button></a>
				</div>
				-->
			</div>
		</div>
	</div>
</div>
<div class="right-panel">
</div>
<!-- Hiddens -->
	<div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_standard_shifts_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Select Standard Shifts</h3>
	    <div id="select_standard_shifts_container">
	    	<!-- Standard Shifts Selection -->
	    </div>
	</div>
	
	<div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_special_shifts_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Special Shifts</h3>
	    <div id="select_special_shifts_container">
	    	<!-- Custom Repeating Shifts Selection -->x
	    </div>
	</div>
	
	<div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_repeating_shifts_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Custom Repeating Shift</h3>
	    <div id="select_custom_repeating_shifts_container">
	    	<!-- Custom Repeating Shifts Selection -->x
	    </div>
	</div>
	
	<div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_standard_day_offs_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Select Standard Shifts</h3>
	    <div id="select_standard_day_offs_container">
	    	<!-- Standard Day Offs Selection -->x
	    </div>
	</div>
	
	<div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_repeating_day_offs_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Custom Repeating Day Offs</h3>
	    <div id="select_custom_repeating_day_offs_container">
	    	<!-- Custom Repeating Day Offs Selection -->x
	    </div>
	</div>
	
	<div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_special_day_offs_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Special Shifts</h3>
	    <div id="select_special_day_offs_container">
	    	<!-- Custom Special Dayoff Selection -->
	    </div>
	</div>
<!--  -->
<script type="text/javascript">
var today = new Date();
$().ready(function() {
	currentMonth = today.getMonth()+1;
	currentYear = today.getFullYear();
	
	user_id = <?= $user->id?>;
	standardShifts = <?= $standardShifts;?>;
	usersStandardShifts = <?= $usersStandardShifts;?>;
	buildUsersStandardShifts();

	userRepeatedShifts = <?= $userRepeatedShifts;?>;
	buildUsersCustomRepeatingShifts();

	standardDayOffs = <?= $standardDayOffs;?>;
	usersStandardDayOffs = <?= $usersStandardDayOffs;?>;
	buildUsersStandardDayOffs();

	userRepeatedDayOffs = <?= $userRepeatedDayOffs;?>;
	buildUsersCustomRepeatingDayOffs();

	userSpecialShifts = <?= $userSpecialShifts;?>;
	buildUserSpecialShifts();

	userSpecialDayOffs = <?= $userSpecialDayOffs;?>;
	buildUserSpecialDayOffs();
	
	//buildMonth(currentMonth,currentYear);
	getMonthShifts(currentMonth, currentYear).done(handleData);
	
	var $calendarContainer = $(".calendar-container");
	$(window).scroll(function(){			
		$calendarContainer
			.stop()
			.animate({"marginTop": ($(window).scrollTop() +0) + "px"}, "slow" );			
	});
	
	/* var $rightPanelContainer = $(".right-panel-container");
	$(window).scroll(function(){			
		$rightPanelContainer
			.stop()
			.animate({"marginTop": ($(window).scrollTop() + 10) + "px"}, "slow" );			
	}); */
});
</script>
<style>
.calendar-container{width: 242px;}
.right-panel{width: 300px;float:right;}
.day-container{padding: 5px; height: 50px;}
.date-label{
	font-size: 10px;
    border-radius: 5px;
    background: #106271;
    padding: 5px;
    float: left;
    color: #fff;
    text-align: center;
}

.date-label-today{
	font-weight: bold;
	background: #60a917;
}


.shift-label{
	font-size: 10px;
    border-radius: 5px;
    background: #ccc;
    padding: 5px;
    float: left;
    text-align: left;
    margin-left: 20px;
}

.day-selected{
	border: 1px solid #59cde2;
}
</style>
