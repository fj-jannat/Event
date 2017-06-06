<?php 
	session_start();
	if(!isset($_SESSION["sess_user"])){
		header("location:../index.php");
	} else {

	require '../func/connect.php';
	
	$sql = "SELECT * from event_request NATURAL JOIN event order by Req_date desc";
	$res = $conn->query($sql);
	
?>	
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Requests</title>

    <!-- Bootstrap Core CSS -->
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/sb-admin.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/main.css" />
	<link rel="stylesheet" type="text/css" href="../DataTables/media/css/dataTables.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link href="../css/shop-homepage.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../jquery/jRating.jquery.css" />
	<link rel="stylesheet" href="../assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../assets/css/mystyle.css">
	
	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	
	 <style>
  * {font-family: Helvetica Neue, Arial, sans-serif; }

    h1, table { text-align: center; }

    table {border-collapse: collapse;  width: 85%; margin: 0 auto 5rem;}

    th, td { padding: 1.5rem; font-size: 1.3rem; text-align: center;}

    tr {background: hsl(50, 50%, 80%); }

    tr, td { transition: .4s ease-in; } 

    #firstrow {background: hsla(12, 50%, 20%, 0.5); font-weight: 1000;}

    tr:nth-child(even) { background: hsla(50, 100%, 30%, 0.7); }

    td:empty {background: hsla(50, 25%, 60%, 0.7); }
   </style>

   <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });

    function delete_id(id){
        if(confirm('Sure To Remove This Record ?')){
            window.location.href='event_reg_delete.php?delete_id='+id; 
          }
      }
  </script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="event-manager.php">Event Management</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-power-off">  Log Out</i></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	

    <!-- Page Content -->
    <div class="container">

        <div class="row">
			<div class="col-md-3">
                <div class="list-group">
					<p class="lead list-group-item" style="background-color:powderblue;"><b> Event  </b></p>
                    <a href="create_event.php" class="list-group-item"><i class="fa fa-plus-square"> Add New Event</i></a>
					<a href="reg_list.php" class="list-group-item"><i class="fa fa-thumbs-up"> Approve Registration</i></a>
					<a href="#" class="list-group-item"><i class="fa fa-print"> Print Invitation Locally</i></a>
                </div>

                <div class="list-group">
					<p class="lead list-group-item" style="background-color:powderblue;"><b> User  </b></p>
					<a href="#" class="list-group-item"><i class="fa fa-file-text"> Register New User</i></a>
					<a href="#" class="list-group-item"><i class="fa fa-pencil-square-o"> Modify User</i></a>
					<a href="#" class="list-group-item"><i class="fa fa-trash"> Delete User</i></a>
					<a href="#" class="list-group-item"><i class="fa fa-plus"> Add New Admin</i></a>
					<a href="#" class="list-group-item"><i class="fa fa-cog"> Account Setting</i></a>
                </div>
            </div>

            <div class="col-md-9">

                <div id="page-wrapper">
				<legend><h1>List of All Event Requests</h1></legend>
				
				<div id = "table-wrapper">
				  <table id = "example" class="row-border display compact hover" cellspacing="0">
					<thead>
					  <tr id = "firstrow">
						<th>Req Date</th>
						<th>Event Name</th>
						<th>Event Date</th>
						<th>From</th>
						<th>Rank</th>
						<th>Phone</th>
						<th>Req Status</th>
						<th>Action</th>						
					  </tr>
					</thead>
					<tbody>
					   <?php
						while ($row = $res->fetch_assoc()) 
						{	
						  echo "<tr>";
						  echo "<td>".$row['Req_date']."</td>";
						  echo "<td>".$row['Event_name']."</td>";
						  echo "<td>".$row['Event_date']."</td>";
						  echo "<td>".$row['Cust_name']."</td>";
						  echo "<td>".$row['Cust_rank']."</td>";
						  echo "<td>".$row['Cust_phone']."</td>";
						  echo "<td>".$row['Req_status']."</td>";
						  
						?>
						  <td>
							<a href="product_edit.php?id=<?php echo $row['Serial']; ?>" data-toggle="tooltip" title="Send Email"><i class = "fa fa-envelope-square"></i></a>
							<a href="event_reg_delete.php?delete_id=<?php echo $row['Serial']; ?>" onclick = "return confirm('Sure to delete?'); " data-toggle="tooltip" title="Delete"><i class = "fa fa-trash-o"></i></a>
						  </td>
						</tr> 
						<?php  
						  } 
						  mysqli_free_result($res);
						?>  
					</tbody>
				  </table>
				  
				</div>
			  
			  </div><!-- /#page-wrapper -->

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; 2017</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
	<script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/skel.min.js"></script>
	<script src="../assets/js/util.js"></script>
	<script src="../assets/js/main.js"></script>
	<script src="../jquery/jquery.js"></script>
	<script src="../jquery/jRating.jquery.js"></script>
	<script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="../js/call.js">  </script>
	
	

</body>

</html>
<?php
}
?>