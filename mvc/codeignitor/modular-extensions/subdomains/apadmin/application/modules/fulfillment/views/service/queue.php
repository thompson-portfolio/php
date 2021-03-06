<?php

//$this->debug->show($services);

?>
<script>
	$(document).ready(function() {
	
	$(".notesview").click(function(){
		
		$("#notesbody").html("<center><img src='<?php echo $this->config->item('subdir');?>/resources/apadmin/img/346.gif'></center>");
		var heading = $(this).attr('title');
		$("#noteheader").html(heading);
		
		var id = $(this).attr('id').replace('notes_','');
		$.ajax({
			type: "POST",
			url: "<?php echo $this->config->item('subdir');?>/ajax/apadmin/fulfillment/notes",
			data: "id=" + id ,
			  success: function(data){
					$("#notesbody").html(data);
				  }
		});
		
	});
	$(".revokeit").click(function(){
		
		$("#notesbody").html("<center><img src='<?php echo $this->config->item('subdir');?>/resources/apadmin/img/346.gif'></center>");
		var heading = $(this).attr('title');
		$("#noteheader").html(heading);
		
		var id = $(this).attr('id').replace('revoke_','');
		
		$.ajax({
			type: "POST",
			url: "<?php echo $this->config->item('subdir');?>/ajax/apadmin/fulfillment/revokeorder",
			data: "pack_id=" + id ,
			  success: function(data){
					$("#notesbody").html(data);
				  }
		});
	});
	$(".fulfillit").click(function(){
		
		$("#notesbody").html("<center><img src='<?php echo $this->config->item('subdir');?>/resources/apadmin/img/346.gif'></center>");
		var heading = $(this).attr('title');
		$("#noteheader").html(heading);
		
		var id = $(this).attr('id').replace('fulfill_','');
		
		$.ajax({
			type: "POST",
			url: "<?php echo $this->config->item('subdir');?>/ajax/apadmin/fulfillment/fulfillorder",
			data: "pack_id=" + id ,
			  success: function(data){
					$("#notesbody").html(data);
				  }
		});
	});
	$(".notesadd").click(function(){
		
		var heading = $(this).attr('title');
		$("#noteadd").html(heading);
		$("#helplink_text").html('');
		var id = $(this).attr('id').replace('addnotes_','');
		$("#pack_id").val(id);
		
	});
	$("#savenote").click(function(e){
		e.preventDefault();
		var id = $("#pack_id").val();
		var notes = $("#newnote").val();
		$.ajax({
			type: "POST",
			url: "<?php echo $this->config->item('subdir');?>/ajax/apadmin/fulfillment/addnote",
			data: "id=" + id + "&notes=" + notes,
			  success: function(data){
					$("#helplink_text").html(data);
					$("#newnote").val('');
					$("#pack_id").val('');
					setTimeout(function(){$(".modal").modal('hide');},5000)
				  }
		});
	});
	$(".close").click(function(){
		$(".modal").modal('hide');
	});
});
</script>

		
		<h3 class="heading">Available Services</h3>
		<form method="post" action="<?php echo $this->config->item('subdir');?>/fulfillment/service/queue">
			
		</form>
		<div id="service_table_wrapper" class="dataTables_wrapper form-inline" role="grid">

			<table class="table table-striped table-bordered table-condensed dTableR uafix" id="service_table" aria-describedby="service_table_info">
				<thead>
					<tr class="nosort" role="row">
						<!-- <th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th> -->
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Pack ID</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Client ID</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Plan ID</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Name</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Created</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Renew</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Paid</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Fulfilled</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Fulfilled Date</th>
						<th class="sorting" role="columnheader" tabindex="0" aria-controls="service_table" rowspan="1" colspan="1">Active</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">

					<?php
					// iterate services
					$i=0;
					
					foreach ($queue AS $key => $value):

						// set odd/even class variable
						$class = ($i % 2 == 0)? 'even': 'odd';
					?>

						<tr id="record_<?php echo $value['id']; ?>" class="<?php echo $class; ?>">
							<!-- <td><input type="checkbox" name="row_sel" class="row_sel" /></td> -->
							<td><a href="http://my.hostingaccountsetup.com/admin/clientmgr/client_service_details.php?packid=<?php echo $value['pack_id']; ?>" target="_blank"><?php echo $value['pack_id']; ?></a></td>
							<td><a href="http://my.hostingaccountsetup.com/admin/clientmgr/client_profile.php?clientid=<?php echo $value['client_id']; ?>" target="_blank"><?php echo $value['client_id']; ?></a></td>
							<td><?php echo $value['plan_id']; ?></td>
							<td><?php echo $value['package_name']; ?></td>
							<td><?php echo date("m/d/y",strtotime($value['created_date'])); ?></td>
							<td><?php echo date("m/d/y",strtotime($value['renew_date'])); ?></td>
							<td><?php echo $value['paid']; ?></td>
							<td><?php echo $value['fulfilled']; ?></td>
							<td><?php echo $value['fulfilled'] == 1  ? date("m/d/y",strtotime($value['fulfill_date'])) : '&nbsp'; ?></td>
							<td><?php echo $value['active']; ?></td>
							<td>
								<a data-toggle="modal" data-backdrop="static" href="#notesmodel" title="Notes for #<?php echo $value['pack_id'];?> <?php echo $value['package_name'];?>" class="notesview" id="notes_<?php echo $value['pack_id'];?>">
									<i class="splashy-document_copy"></i>
								</a>&nbsp;&nbsp;
								<a data-toggle="modal" data-backdrop="static" href="#addnote" title="Notes for #<?php echo $value['pack_id'];?> <?php echo $value['package_name'];?>" class="notesadd" id="addnotes_<?php echo $value['pack_id'];?>">
								<i class="splashy-document_letter_add"></i></a>&nbsp;&nbsp;
							
								<?php if(  empty($value['fulfilled'])) : ?>
								<a data-toggle="modal" data-backdrop="static" href="#notesmodel" title="Fulfilling #<?php echo $value['pack_id'];?> <?php echo $value['package_name'];?>" class="fulfillit" id="fulfill_<?php echo $value['pack_id'];?>">
								<i class="splashy-thumb_up"></i>
								</a>&nbsp;&nbsp;
								<?php else: ?>
								<a data-toggle="modal" data-backdrop="static" href="#notesmodel" title="Revoking #<?php echo $value['pack_id'];?> <?php echo $value['package_name'];?>" class="revokeit" id="revoke_<?php echo $value['pack_id'];?>">
								<i class="splashy-thumb_down"></i>
								</a>&nbsp;&nbsp;
							<?php endif; ?>
								<?php if( ! empty($value['errorid'])) : ?>
								<a href="<?php echo $this->config->item('subdir');?>/fulfillment/service/errors/<?php echo $value['pack_id']; ?>" title="Go to error page"><i class="splashy-error"></i></a>&nbsp;&nbsp;
							<?php endif; ?>
							</td>
						</tr>


					<?php
						// increment counter
						$i++;

					endforeach;
					?>

				</tbody>
			</table>

		</div>
		<div class="modal hide" id="notesmodel">
			<div class="modal-header">
				<button class="close closemodel" data-dismiss="modal">×</button>
				<h3 id="noteheader">Modal header</h3>
			</div>
			<div class="modal-body" id="notesbody">
			</div>
			<div class="modal-footer">
				<a href="javascript:void(0);" class="btn close" data-dismiss="modal" class>Close</a>
			</div>
		</div>
<div class="modal hide" id="addnote">
	<form method="post" action="">
			<div class="modal-header">
				<button class="close closemodel" data-dismiss="modal">×</button>
				<h3 id="noteadd">Add Note</h3>
			</div>
			<div class="modal-body" id="addbody">
			
			<div class="formSep">
				<div class="row-fluid">
					<div class="span8">
						<label>Note <span class="f_req">*</span></label>
						<textarea id="newnote" name="newnote"></textarea>
						<span class="help-block" id="helplink_text"></span>
					</div>
				</div>
					
			</div>
			</div>
			<div class="modal-footer">
					<input type="hidden" id="pack_id" name="pack_id" value=''>

					<button class="btn btn-danger closemodal" type="button">Close</button>	
					<button class="btn btn-inverse" id="savenote" type="button" role="button">Add Note</button>
			</div>
		</form>
</div>
<!--
	</div>

</div>
-->
