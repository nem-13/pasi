<?php
    session_start();
    
    if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true) {
        header('location:../client/login.php');	
    } 
    
?>

<!DOCTYPE html>
<html>
<head>
	<title>POS</title>
	<link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="bootstrap.css">
    <script language="javascript" type="text/javascript" src="jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<style>
        #sales-chart{
            width: 80% !important;
            height: 80% !important;
        }
	</style>
</head>
<body>
    <div id="header">
		<div id="site-name" class="mx-auto">
			<p>Point of Sales</p>   
		</div>
        <div id="name" class="mx-auto">
                <p>Welcome, <?php echo strToUpper($_SESSION['username'])?>
                <a href="logout.php">
                    <img src="logout.png" alt="" style="width:5%;">
                </a>
                </p> 
            </div>
            
	</div>
	<div class="container" id="main">
		<div>		
                <div class="row">
                    <div class="col-sm-3" style="padding-top: 20px;">
                        <div class="row form-group">
                            <div  class="col-sm-12"><label class="label-control">Item Code: </div>
                            <div class="col-sm-12"><input id="item_code" name="item_code" type="text" class="form-control" required/> </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12"><label class="label-control">Quantity: </div>
                            <div class="col-sm-12"><input id="qty" name="qty" type="number" class="form-control" required/> </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-10 mx-auto"><input id="submit" name="submit" type="submit" class="form-control"/></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-10 mx-auto"><p id="err1" style="color:red;"></p></div>
                        </div>
                    </div>
                    <div class="col-sm-9" id="result" style="border-left: 1px solid #4CAF50;">
                        
                    </div>
                </div>
                <div class="row" style="border-top: 1px solid #4CAF50; padding-top:20px">
                    <div class="col-sm-6">
                        <button type="submit" id="goToInventory" name=submit class="btn btn-success">Check Inventory</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" id="printTrans" name=submit class="btn btn-success"></button>
                    </div>
                </div>

			</div>	
	</div>
    <div class="col-sm-12" style="padding-top: 20px; display: none;" id="report-header">
        <h2 style="text-align: center;">Sales Report</h2>
    </div>
    <table id="resultsTable" class="mx-auto" style="width: 80%; border: 1px solid #4CAF50; display: none;"></table>
   
    <h4 style="padding: 10px; margin-bottom: 0; width: 80%; display: none;" class="mx-auto" id="graph-desc">Transactions (Line Graph)</h4>
    <canvas id="sales-chart" class="mx-auto" style="display: none;"></canvas>
  
    <table id="recommendationsTable" class="mx-auto" style="width: 80%; border: 1px solid #4CAF50; margin-top: 30px; display: none;"></table>
	<script src="script.js"></script>
    <script>
        setTimeout(() => {
            createGraph();
            aiCall();
        }, 1000);
    </script>
</body>
</html>