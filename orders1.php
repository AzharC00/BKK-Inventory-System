
<?php 
require_once 'php_action/db_connect.php'; 
require_once 'includes/header.php'; 

if($_GET['o'] == 'add') { 
// add complaint
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') { 
	echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') { 
	echo "<div class='div-request div-hide'>editOrd</div>";
} // /else manage complaint


?>
	<div class="container">
<ol class="breadcrumb">
  <li><a href="dashboard.php">Home</a></li>
  <li>complaint</li>
  <li class="active">
  	<?php if($_GET['o'] == 'add') { ?>
  		Add complaint
		<?php } else if($_GET['o'] == 'manord') { ?>
			Manage complaint
		<?php } // /else manage complaint ?>
  </li>
</ol>





<div class="panel panel-default">
	<div class="panel-heading" style="    background-image: linear-gradient(to right, #70aefa, #3bc5eb, #3da1e0);    border: none;
    border-radius: 0;color:white">

		<?php if($_GET['o'] == 'add') { ?>
  		<i class="glyphicon glyphicon-plus-sign"></i>	Add complaint
		<?php } else if($_GET['o'] == 'manord') { ?>
			<i class="glyphicon glyphicon-edit"></i> Manage complaint
		<?php } else if($_GET['o'] == 'editOrd') { ?>
			<i class="glyphicon glyphicon-edit"></i> Edit complaint
		<?php } ?>

	</div> <!--/panel-->	
	<div class="panel-body">
			
		<?php if($_GET['o'] == 'add') { 
			// add complaint
			?>			

			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/createOrder1.php" id="createcomplaintForm">
		  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">STAFF NAME</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="" autocomplete="off" required/>
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="complaintDate" class="col-sm-2 control-label">DATE </label>
			    <div class="col-sm-10">
			      <input type="date" class="form-control" id="complaintDate" name="complaintDate" autocomplete="off" required/>
			    </div>
			  </div> <!--/form-group-->


			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">ISSUE/COMPLAINT</label>
			    <div style="height:200px" class="col-sm-10">
			      <input style="height:200px" type="textarea" class="form-control" id="issue" name="issue" placeholder="" autocomplete="off" required/>
			    </div>
			  </div> <!--/form-group-->
			  	  

			  <div class="form-group submitButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
		

			      <button type="submit" id="createcomplaintBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Submit</button>

			      <button type="reset" class="btn btn-default" onclick="resetcomplaintForm()"><i class="glyphicon glyphicon-erase"></i> Cancel</button>
			    </div>
			  </div>
			</form>
		<?php } else if($_GET['o'] == 'manord') { 
			// manage complaint
			?>

			<div id="success-messages"></div>
			
			<table class="table" id="managecomplaintTable">
				<thead>
					<tr>
						<th>DATE</th>
						<th>STAFF NAME</th>
						<th>ISSUE</th>
						<th>STATUS</th>

					
					</tr>
				</thead>
			</table>

		<?php 
		// /else manage complaint
		} else if($_GET['o'] == 'editOrd') {
			// get complaint
			?>
			
			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/editcomplaint.php" id="editcomplaintForm">

  			<?php $complaintId = $_GET['i'];

  			$sql = "SELECT * FROM complaints 	
					WHERE complaint_id = {$complaintId}";

				$result = $connect->query($sql);
				$data = $result->fetch_row();				
  			?>

			  <div class="form-group">
			    <label for="complaintDate" class="col-sm-2 control-label">TARIKH</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="complaintDate" name="complaintDate" autocomplete="off" value="<?php echo $data[1] ?>" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">DIKELUARKAN KEPADA</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" value="<?php echo $data[2] ?>" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="receiverName" class="col-sm-2 control-label">NAMA PENERIMA</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="receiverName" name="receiverName" placeholder="Contact Number" autocomplete="off" value="<?php echo $data[3] ?>" />
			    </div>
			  </div> <!--/form-group-->			  

			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Product</th>
						  <th style="width:15%;">Available Quantity</th>	
			  			<th style="width:15%;">Quantity</th>			  					  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
		
			  	<tbody>
			  		<?php

			  		$complaintItemSql = "SELECT complaint_item.complaint_item_id, complaint_item.complaint_id, complaint_item.product_id, complaint_item.complaint_quantity  FROM complaint_item WHERE complaint_item.complaint_id = {$complaintId}";
						$complaintItemResult = $connect->query($complaintItemSql);
						// $complaintItemData = $complaintItemResult->fetch_all();						
						
						// print_r($complaintItemData);
			  		$arrayNumber = 0;
			  		// for($x = 1; $x <= count($complaintItemData); $x++) {
			  		$x = 1;
			  		while($complaintItemData = $complaintItemResult->fetch_array()) { 
			  			// print_r($complaintItemData); ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php


			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $complaintItemData['product_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
			  				</td>
							  <td style="padding-left:20px;">
			  					<div class="form-group">
									<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $complaintItemData['product_id']) { 
			  									echo "<p id='available_quantity".$row['product_id']."'>".$row['quantity']."</p>";
											}
			  								 else {
			  									$selected = "";
			  								}

			  								//echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} // /while 

			  						?>
									
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $complaintItemData['complaint_quantity ']; ?>" />
			  					</div>
			  				</td>
			  				
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

			
	

			  <div class="form-group editButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

			    <input type="hidden" name="complaintId" id="complaintId" value="<?php echo $_GET['i']; ?>" />

			    <button type="submit" id="editcomplaintBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
			      
			    </div>
			  </div>
			</form>

			<?php
		} // /get complaint else  ?>


	</div> <!--/panel-->	
</div> <!--/panel-->	


<!-- edit complaint -->



<!-- remove complaint -->
<div class="modal fade" tabindex="-1" role="dialog" id="removecomplaintModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove complaint</h4>
      </div>
      <div class="modal-body">

      	<div class="removecomplaintMessages"></div>

        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removecomplaintBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove complaint-->


<script src="custom/js/complaint.js"></script>

<?php require_once 'includes/footer.php'; ?>


	