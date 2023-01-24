 
	 <?php 
	 //pr($locationDateData);
	if($locationDateData->error_message->success==1){
		
		$eventDates=$locationDateData->error_message->data;
		//pr($locationDateData);
		//pr($eventDates);
		foreach($eventDates as $key=>$val){
			
		    $val=(array)$val;
		?>
		<div class="card">
			  <div class="time-slot">
				  <input type="radio" id="<?php echo $val['event_id'].'-'.$val['id']?>" class="event_date" name="event_date" value="<?php echo $val['event_id'].'-'.$val['id']?>" onclick="getEventLocationTime('<?php echo $val['event_id'].'-'.$val['id']?>')">
				  <label class="avlbl event_date_label" for="<?php echo $val['event_id'].'-'.$val['id']?>" id="l-<?php echo $val['event_id'].'-'.$val['id']?>">
					  <h2>
						  <p><?php echo strtoupper(date('M',strtotime($val['eventDate'])));?></p>
						  <p><?php echo date('Y',strtotime($val['eventDate']));?></p>
						  <p><?php echo date('d',strtotime($val['eventDate']));?></p>
					  </h2>
					  <div class="info">
						  <div>Available</div>
						  <?php if($val['eventCharges']=='paid'){?>
						  <div class="disc">Paid</div>
						  <?php 
						  }else{?>
							<div class="disc">FREE</div> 
						  <?php 
						  }?>
					  </div>
				  </label>
			  </div>
		  </div>   
		<?php 
	    }
	}else{
		?>
		<div class="alert alert-danger" role="alert">
            Event booking all date is over for selected parameters
        </div>
	<?php 
	    }
	?>
	<!--<div class="card">
		<div class="time-slot">
			<input type="radio" id="rd1" name="radios" value="all">
			<label class="sltd" for="rd1">
				<h2>
		  <p>SEP</p>
		  <p>2022</p>
		  <p>19</p>												
		</h2>
				<div class="info">
					<div>Available</div>
					<div class="disc">FREE</div>
				</div>
			</label>
		</div>
	</div>
	
	<!--<div class="card">
		<div class="time-slot">
			<input type="radio" id="rd2" name="radios" value="all">
			<label class="lmtd-seat" for="rd2">
				<h2>
		  <p>SEP</p>
		  <p>2022</p>
		  <p>19</p>												
		 </h2>
				<div class="info">
					<div>Limited Seats Left</div>
					<div class="disc">inr 499</div>
				</div>
			</label>
		</div>
	</div>
	
	<div class="card">
		<div class="time-slot full-time-slot">
			<input type="radio" id="rd3" name="radios" value="all">
			<label class="slt-full" for="rd3">
				<h2>
		  <p>SEP</p>
		  <p>2022</p>
		  <p>19</p>												
		</h2>
				<div class="info">
					<div>Slot Full</div>
					<div class="disc">inr 499</div>
				</div>
			</label>
		</div>
	</div>

	<div class="card">
		<div class="time-slot">
			<input type="radio" id="rd4" name="radios" value="all">
			<label class="filling-fast" for="rd4">
				<h2>
		  <p>SEP</p>
		  <p>2022</p>
		  <p>19</p>												
		</h2>
				<div class="info">
					<div>Filling Fast</div>
					<div class="disc">inr 499</div>
				</div>
			</label>
		</div>
	</div>

	<div class="card">
		<div class="time-slot">
			<input type="radio" id="rd5" name="radios" value="all">
			<label class="avlbl" for="rd5">
				<h2>
		  <p>SEP</p>
		  <p>2022</p>
		  <p>19</p>												
		</h2>
				<div class="info">
					<div>Available</div>
					<div class="disc">FREE</div>
				</div>
			</label>
		</div>
	</div>
	
	<div class="card">
		<div class="time-slot">
			<input type="radio" id="rd6" name="radios" value="all">
			<label class="filling-fast" for="rd6">
				<h2>
		  <p>SEP</p>
		  <p>2022</p>
		  <p>19</p>												
		</h2>
				<div class="info">
					<div>Filling Fast</div>
					<div class="disc">inr 499</div>
				</div>
			</label>
		</div>
	</div>-->
	