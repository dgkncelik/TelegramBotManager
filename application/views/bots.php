<div class="container">
	<div class="col-md-12" style="margin-top:20px;">
		<?php 
		if(isset($result)){	
			if($result != '' or $result != NULL){
				echo $result;
			}
		}
		?>
	</div>
	<div class="col-md-5 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Currently Existed Bots</div>
			<div class="panel-body">
				<?php
				if(isset($bot_list)){
					if($bot_list != '' or $bot_list){
						foreach ($bot_list as $MasterKey => $Mastervalue) {
							echo $bot_list[$MasterKey]['name'] .'&nbsp;&nbsp;&nbsp<a href=/dashboard/b/delete/' . $bot_list[$MasterKey]['token'] . '>(Delete This Bot)</a>' . '<br>';
							echo '<code>'. 'token: ' . $bot_list[$MasterKey]['token'] . '<br>' . 'create date(unix time stamp): ' . $bot_list[$MasterKey]['create_date'] . '</code><br><br>'; 
						}
					}
				}
				?>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">Create New Bot</div>
			<div class="panel-body">
				<form action="/dashboard/b/create" method="POST">
					<label>Bot Name:</label>					
					<input type="text" class="form-control" name="inputBotName">
					<br>
					<label>Bot Token</label>
					<input type="text" class="form-control" name="inputToken">
					<br>
					<label>Info</label>
					<input type="text" class="form-control" name="inputInfo">
					<br>
					<button class="btn btn-default" type="submit">Create New Bot</button>
				</form>
			</div>
		</div>
	</div>
</div>
