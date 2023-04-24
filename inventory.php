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
    <a href="index.php" style="font-size: 20px; padding: 30px;">Home</a>
	<div class="container">
        <h2>Create Item</h2>
        <div class="row">
            <div class="col-sm-6" style="padding-top: 20px;">
                <div class="row form-group">
                    <div style="text-align: left;" class="col-sm-12"><label class="label-control">Name: </div>
                    <div class="col-sm-12"><input id="item-name" name="item-name" type="text" class="form-control"/> </div>
                </div>
                <div class="row form-group">
                    <div style="text-align: left;" class="col-sm-12"><label class="label-control">Variety: </div>
                    <div class="col-sm-12"><input id="item-variety" name="item-variety" type="text" class="form-control"/> </div>
                </div>
                <div class="row form-group">
                    <div style="text-align: left;" class="col-sm-12"><label class="label-control">Brand: </div>
                    <div class="col-sm-12"><input id="item-brand" name="item-brand" type="text" class="form-control"/> </div>
                </div>
                
            </div>
            <div class="col-sm-6" style="padding-top: 20px;">
                <div class="row form-group">
                    <div style="text-align: left;" class="col-sm-12"><label class="label-control">Price: </div>
                        <div class="col-sm-12"><input id="item-price" name="item-price" type="number" step="0.01" class="form-control"/> </div>
                    </div>
                    <div class="row form-group">
                        <div style="text-align: left;" class="col-sm-12"><label class="label-control">Quantity: </div>
                        <div class="col-sm-12"><input id="item-qty" name="item-qty" type="number" class="form-control"/> </div>
                    </div>
                    <div class="row form-group">
                        <div style="text-align: left;" class="col-sm-12"><label class="label-control">Item Code: </div>
                        <div class="col-sm-12"><input id="item-code" name="item-code" type="text" class="form-control"/> </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top: 20px;">
                <div class="row form-group">
                    <div class="col-sm-2 mx-auto"><input id="createItem" name="createItem" type="submit" class="form-control"/></div>
                </div>
                
            </div>
            <div class="col-sm-12">
                    <div class="row form-group">
                        <div class="col-sm-12 mx-auto"><p id="err2"></p></div>
                    </div>
                    
                </div>
            
        </div>	
	</div>
    <div class="container">
        <table style="width: 100%;" id="inventory-table">
            
        </table>
    </div>
    <div class="full-screen" hidden id="editForm">
        <div style="position: absolute; top: 50%; left:50%; transform: translate(-50%, -50%); width: 500px; " class="container">
        <h2>Update Item</h2>
            <div class="row">
                <div class="col-sm-12" style="padding-top: 20px;">
                    <div class="row form-group">
                        <div style="text-align: left;" class="col-sm-12"><label class="label-control">Name: </div>
                        <div class="col-sm-12"><input id="update-name" name="update-name" type="text" class="form-control"/> </div>
                    </div>
                    <div class="row form-group">
                        <div style="text-align: left;" class="col-sm-12"><label class="label-control">Brand: </div>
                        <div class="col-sm-12"><input id="update-brand" name="update-brand" type="text" class="form-control"/> </div>
                    </div>
                    <div class="row form-group">
                        <div style="text-align: left;" class="col-sm-12"><label class="label-control">Quantity: </div>
                        <div class="col-sm-12"><input id="update-quantity" name="update-quantity" type="number" class="form-control"/> </div>
                    </div>
                    <div class="row form-group" style="display:none;">
                        <div style="text-align: left;" class="col-sm-12"><label class="label-control">ID: </div>
                        <div class="col-sm-12"><input id="update-id" name="update-id" type="number" class="form-control"/> </div>
                    </div>
                    
                </div>
                <div class="col-sm-12" style="padding-top: 20px;">
                    <div class="row form-group">
                        <div class="col-sm-4 mx-auto"><input id="updateItem" name="updateItem" type="submit" class="form-control" value="Update"/></div>
                        <div class="col-sm-4 mx-auto"><input id="cancelItem" name="cancelItem" type="submit" class="form-control" value="Cancel"/></div>
                    </div>
                    
                </div>
                
                
            </div>	
        </div>
        </div>
	<script src="script.js"></script>
</body>
</html>