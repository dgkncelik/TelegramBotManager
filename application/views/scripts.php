<div class="container">
	<div class="col-md-12" style="margin-top: 20px;">
		<div class="col-md-12">
			<?php
				if(isset($script_result)){
					echo $script_result . '<br><br>';
				}
			?>
		</div>

		<div class="col-md-5 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Currently Existed Scripts</div>
				<div class="panel-body">
					<?php
						if(isset($script_list)){
							foreach ($script_list as $MasterKey => $Mastervalue) {
							echo $script_list[$MasterKey]['name'] .'&nbsp;&nbsp;&nbsp<a href=/dashboard/s/delete/' . $script_list[$MasterKey]['id'] . '>(Delete This Script)</a>' . '<br>';
							echo '<code>'. 'id: ' . $script_list[$MasterKey]['id'] . '<br>' . 'create date(unix time stamp): ' . $script_list[$MasterKey]['create_date'] . '<br>script path: '. $script_list[$MasterKey]['path']. '<br>which bot can access this script(token): ' . $script_list[$MasterKey]['bot_token'].'</code><br><br>'; 
						}
						}


					?>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Create New Script</div>
				<div class="panel-body">
					<form action="/dashboard/scripts/create" method="POST">
					<?php
						if(isset($script_create_message)){
						echo $script_create_message . '<br>';
					}
					?>
					<label>Script Name:</label>
					<input type="text" class="form-control" name="inputScriptName">
					<br>
					<label>Select Which Bot Can Access This Script:</label><br>

						
					
					<?php
					if(isset($bot_list)){
						echo '<select class="form-control" name="inputBotToken">';
						foreach ($bot_list as $MasterKey => $MasterValue) {
							echo '<option value="' . $bot_list[$MasterKey]['token'] . '">' . $bot_list[$MasterKey]['name'] . ' (' . $bot_list[$MasterKey]['token']. ')</option>';
						}
						echo '</select>';
					}else{
						echo "There is no bot";
					}
					?>


					<br>
					<label>Enter full path and file name of script</label>
					<input type="text" class="form-control" name="inputPath"><br>
					<button class="btn btn-default" type="submit">Create Script</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>





