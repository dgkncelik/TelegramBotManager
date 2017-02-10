<div class="container">
	<div class="col-md-12" style="margin-top:20px;">
		<div class="col-md-12">
			<?php
				if(isset($delete_result)){
					echo $delete_result . '<br><br>';
				}
			?>			
		</div>
		
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Recorded Messages</div>
				<div class="panel-body">
					<code>Please select which bot's message you want to view.</code><br><br>
					<form action="/dashboard/messages/view" method="POST">
						<?php 
							if(!is_array($bot_list)){
								echo $bot_list;
							}elseif(is_array($bot_list)){
								echo '<select class="form-control" name="inputBotName">';
								foreach ($bot_list as $MasterKey => $MasterValue) {
									
									echo '<option value="' . $bot_list[$MasterKey]['id'] .'">' . $bot_list[$MasterKey]['name'] . '</option>';

								}
								echo '</select><br>';
								echo '<button class="btn btn-default" type="submit">View Messages</button>';
							}

						?>
					</form>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Messages</div>
				<div class="panel-body">
				<?php 
					if(isset($message_result)){
						if(is_array($message_result)){
							foreach ($message_result as $MasterKey => $MasterValue) {
								
								echo '<pre>';
								echo '<b>message id:</b> ' . $message_result[$MasterKey]['id']  .'&nbsp;&nbsp;&nbsp;<a href="/dashboard/message/delete/' . $message_result[$MasterKey]['id']. '">' . 'Delete this message</a><br>' ;
								echo '<b>save date(unix time stamp):</b> ' . $message_result[$MasterKey] ['save_date'] . '<br>';
								echo '<b>mesage(JSON):</b> ' . $message_result[$MasterKey]['message']; 
								echo '</pre><br>';
								
							}
						}else{
							echo $message_result;
						} 
					}
				?>
				<div>
			</div>
		</div>
	</div>
</div>

