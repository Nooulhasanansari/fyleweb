<?php
	session_start();
	$data = file_get_contents("https://vast-shore-74260.herokuapp.com/banks?city=BAREILLY");
	$banks = json_decode($data,true);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Banks Search Application</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<!-- Bootstrap core CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/css/mdb.min.css" rel="stylesheet">
</head>
<body>
	<header>
		<div class="container-fluid">
			<div class="row" style="background-color: black;color: white">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<h2 class="text-center"><b>Bank Application</b></h2>
				</div>
					
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12"></div>
			</div>
		</div>
	</header>
	<br><br><br>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<h3 class="text-success"><b>Bank Records as per the City</b></h3>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12"></div>
				<div class="col-md-1 col-sm-1 col-xs-12"></div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<form>
						<input type="text" id="city" name="city" placeholder="Search by City" class="form-control" oninput="getBanks()">
					</form>
				</div>
			</div>
			<br>
			<div class="row" >
				
				<div class="col-md-12 col-sm-12 col-xs-12">
					<table class="table" id="banks_table">
						<tr class="" style="background-color: #484DEE;color: white;">
							<th>Fav</th>
							<th>Sl. No</th>
							<th>IFSC Code</th>
							<th>Bank ID</th>
							<th>Branch</th>
							<th>Address</th>
							<th>City</th>
							<th>District</th>
							<th>State</th>
							<th>Bank Name</th>
							
						</tr>
						<?php
							for($i=0;$i<5;$i++){
						?>
						<tr>
							<td id="<?php echo $i+1?>" onclick="fvr(this.id)">Like?</td>
							<td><?php echo $i+1 ?></td>
							<td id="ifsc_code<?php echo $i+1?>"
								class="
									<?php
										$x = $i+1;
										$ses = 'ifsc_code'.$x;
										if(isset($_SESSION[$ses])){
											if($_SESSION[$ses]==$banks[$i]['ifsc'])
												echo 'text-success';
										}
									?>
								"
								>
								<?php									
									echo $banks[$i]["ifsc"] 
								?>									
							</td>
							<td><?php echo $banks[$i]["bank_id"] ?></td>
							<td><?php echo $banks[$i]["branch"] ?></td>
							<td><?php echo $banks[$i]["address"] ?></td>
							<td><?php echo $banks[$i]["city"] ?></td>
							<td><?php echo $banks[$i]["district"] ?></td>
							<td><?php echo $banks[$i]["state"] ?></td>
							<td ><a class="text-success" href="display.php?ifsc=<?php echo $banks[$i]['ifsc']?>&bank_name=<?php echo $banks[$i]['bank_name']?>"> <?php echo $banks[$i]["bank_name"] ?> </a></td>

						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</section>


	
	<br><br><br>
	<script>
		
		function fvr(id){
			x = id;
			code = "ifsc_code"+x;
			set = "#"+code;
			$(set).css("color","red");
			ifsc = $(set).html().trim();
			$.ajax({
				url: "session.php?"+code+"="+ifsc+"&var="+code,
				method: 'get',
				success : function(data){
					text = "<h6 class='text-success'>"+ifsc+"</h6>";
					$(set).html(text);
					text = "<h6 class='text-success'>Liked</h6>";
					x="#"+x;
					$(x).html(text);
				}
			});			
		}



	</script>
	<script>
		function getBanks(){			
			$.ajax({
				url: "https://vast-shore-74260.herokuapp.com/banks?city="+$("#city").val(),
				dataType: 'json',
				success : function(data){
					i=0,table_html="";
					table_html = "<table class='table'>";
					table_html+="<tr class='text-primary'>"+
							"<th>Sl. No</th>"+
							"<th>IFSC Code</th>"+
							"<th>Bank ID</th>"+
							"<th>Branch</th>"+
							"<th>Address</th>"+
							"<th>City</th>"+
							"<th>District</th>"+
							"<th>State</th>"+
							"<th>Bank Name</th>"+
						"</tr>";
					for(i=0;i<5;i++){
						table_html+="<tr>"+
						"<td>"+(i+1)+"</td>"+
						"<td>"+data[i]["ifsc"]+"</td>"+
						"<td>"+data[i]["bank_id"]+"</td>"+
						"<td>"+data[i]["branch"]+"</td>"+
						"<td>"+data[i]["address"]+"</td>"+
						"<td>"+data[i]["city"]+"</td>"+
						"<td>"+data[i]["district"]+"</td>"+
						"<td>"+data[i]["state"]+"</td>"+
						"<td>"+data[i]["bank_name"]+"</td>"+
						"</tr>";

					}
					table_html+="</table>";

					$("#banks_table").html(table_html);
				}
			});
		}
	</script>


	<!-- JQuery -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- Bootstrap tooltips -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/js/mdb.min.js"></script>
</body>
</html>
