<?php require_once 'includes/header.php';

$userId = $_SESSION['userId']; // retrieve the username from the session

?>
<?php 

$sql = "SELECT * FROM users WHERE user_id = $userId";
$query = $connect->query($sql);
$userData = $query->fetch_assoc();
$username = $userData['username'];

$orderASql = "SELECT * FROM orders WHERE order_status = 1 AND user_id = $userId AND active = 1";
$orderAQuery = $connect->query($orderASql);
$countOrderA = $orderAQuery->num_rows;

$orderRSql = "SELECT * FROM orders WHERE order_status = 1 AND user_id = $userId AND active = 2";
$orderRQuery = $connect->query($orderRSql);
$countOrderR = $orderRQuery->num_rows;


$orderSql = "SELECT * FROM orders WHERE order_status = 1 AND user_id = $userId";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$complaintSql = "SELECT * FROM complaint";
$complaintQuery = $connect->query($complaintSql);
$countCom = $complaintQuery->num_rows;



$connect->close();

?>

</html>



<style>

	/*******************************/
/******* Section Header ********/
/*******************************/
.section-header {

    width: 100%;
    max-width: 550px;
    text-align: center;


}




.section-header p {
    margin-bottom: 10px;
    font-size: 15px;
}

.section-header h2 {
    color: #black;
    font-size: 25px;
    font-weight: 100;
}

.section-header.left {
    text-align: left;
}

.section-header.left::before {
    width: 60px;
    left: 0;
    background: linear-gradient(to left, #FFD662, #00539C, #00539C);
    border-radius: 0 100% 100% 0;
}

.section-header.left::after {
    left: 0;
    border-radius: 5px;
}
.parallaxtitle {
  width: 100%;
  height: 30vh;
  background-image: url("assests/Banner.png"); /* Replace with the path to your image */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;  background-size: 100% auto;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.parallaxtitle2 {
  width: 100%;
  height: 15vh;
  color: black;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
}


.headline {
  
  font-size: 3vw;
  color: white;
  text-align: center;
  text-shadow: 1px 1px 10px rgba(0, 0, 0, 0.1);
}

.headline2 {
  
  font-size: 3vw;
  color: black;
  text-align: center;
  text-shadow: 1px 1px 10px rgba(0, 0, 0, 0.1);
}
.welcome-box {
  background-color: #f2f2f2;
  border: 2px solid #ccc;
  padding: 20px;
  text-align: center;
  width: 300px;
  margin: 0 auto;
}

.welcome-box h3 {
  color: #333;
  font-size: 20px;
  margin: 0;
}

</style>





<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">

	<div class="container">
  <div class="col-md-14">
		

<div class="parallaxtitle">

  </div></div><br><br>

<div class="row">


<div class="col-md-12 row-md-6">

		<div class="card" >
		  <div class="cardHeader"style="    background-image: linear-gradient(to right, #70aefa, #3bc5eb, #3da1e0);    border: none;
    border-radius: 0;">
		    <h1><?php echo date('d'); ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p><?php echo date('l') .' '.date('d').', '.date('Y'); ?></p>
		  </div>
		</div> 
    <br>   <br>


    <h3>Welcome, <?php echo $username; ?></h3>

</div>



	</div>

	
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading"style="background-image: linear-gradient(to right, #92e07f, #70df40, #92e07f);   border: none;
    border-radius: 0;">
				
				<a href="orders.php?o=manord" style="text-decoration:none;color:white;">
				Approved Application
					<span class="badge pull pull-right"><?php echo $countOrderA; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-6">
		<div class="panel panel-danger">
			<div class="panel-heading"style="background-image: linear-gradient(to right, #f6417d, #ed3655, #f6417d);    
    border: none;
    border-radius: 0;">
				<a href="orders.php?o=manord" style="text-decoration:none;color:white;">
					Rejected Application
					<span class="badge pull pull-right"><?php echo $countOrderR; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->



		<div class="col-md-6">
			<div class="panel panel-info">
			<div class="panel-heading" style="    background-image: linear-gradient(to right, #70aefa, #3bc5eb, #3da1e0);    border: none;
    border-radius: 0;">
				<a href="orders.php?o=manord" style="text-decoration:none;color:white;">
					Application History
					<span class="badge pull pull-right"><?php echo $countOrder; ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->

		<div class="col-md-6">
			<div class="panel panel-info">
			<div class="panel-heading" style="    background-image: linear-gradient(to right, #70aefa, #3bc5eb, #3da1e0);    border: none;
    border-radius: 0;">
				<a href="supply.php?o=manord" style="text-decoration:none;color:white;">
					Complaint History
					<span class="badge pull pull-right"><?php echo $countCom; ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->





<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Calendar</div>
			<div class="panel-body">
				<div id="calendar"></div>
			</div>	
		</div>
		
	</div>

	
</div> <!--/row-->

<script type="text/javascript">
	$(function () {
		// top bar active
		$('#navDashboard').addClass('active');

		// Date for the calendar events (dummy data)
		var date = new Date();
		var d = date.getDate(),
			m = date.getMonth(),
			y = date.getFullYear();

		$('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'title'
			},
			buttonText: {
				today: 'today',
				month: 'month'
			},
			selectable: true, // Allow user to select dates
			select: function (start, end) {
				var title = prompt('Enter a short note for this date:');
				if (title) {
					var eventData = {
						title: title,
						start: start,
						end: end
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true); // Render the event on the calendar
				}
				$('#calendar').fullCalendar('unselect'); // Clear the selection
			}
		});
	});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


	

<div class="row">
<?php require_once 'includes/footer.php'; ?>