<?php

session_start();

$conn = mysqli_connect('localhost','root','','dummy_data_pos'); 
if(!$conn){
    die('Connection Error: '. mysqli_connect_error());
}

if (isset($_POST['userN']) && isset($_POST['userP'])){
    $userN = strip_tags($_POST['userN']);
    $userP= strip_tags($_POST['userP']);
    if (verifyUser($userN, md5($userP), $conn) >0){
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $userN;
        header('location:../client/index.php');
    }else{
        $_SESSION['login_error'] = "Invalid Username or Password";
        header('location:../client/login.php');				
    }
}else if(isset($_POST['name']) && isset($_POST['variety']) && isset($_POST['brand']) && isset($_POST['price']) && isset($_POST['qty']) && isset($_POST['code']) && $_POST['loc']=='addToDb'){			
    $name = trim($_POST['name']);
    $variety = trim($_POST['variety']);
    $brand = trim($_POST['brand']);
    $price = (float) $_POST['price'];
    $qty = (int) $_POST['qty'];
    $code = trim($_POST['code']);
    $stmt = mysqli_prepare($conn, "INSERT INTO items (price, item_code, name, quantity, brand, variety) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'dssiss', $price, $code, $name, $qty, $brand, $variety);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        echo "Data inserted successfully.";
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}else if($_POST['loc']=='retrieveList'){			
    $det_ar=array();
    $qry="SELECT * FROM items";
    $res=mysqli_query($conn,$qry);
    while($row=mysqli_fetch_array($res, MYSQLI_ASSOC)){
        array_push($det_ar, $row);
    }
    echo json_encode($det_ar);
}else if(isset($_POST['itemCode']) && isset($_POST['itemQuantity']) && isset($_POST['date']) && $_POST['loc']=='reduceInventory'){           
    $code = trim($_POST['itemCode']);
    $quantity = (int) $_POST['itemQuantity'];
    $date = $_POST['date'];
    // Check if new quantity will be greater than or equal to zero before executing UPDATE query
    $select_stmt = mysqli_prepare($conn, "SELECT quantity FROM items WHERE item_code = ?");
    mysqli_stmt_bind_param($select_stmt, 's', $code);
    mysqli_stmt_execute($select_stmt);
    mysqli_stmt_bind_result($select_stmt, $db_quantity);
    mysqli_stmt_fetch($select_stmt);
    mysqli_stmt_close($select_stmt);
    $new_quantity = $db_quantity - $quantity;
    if ($new_quantity >= 0) {
        $stmt = mysqli_prepare($conn, "UPDATE items SET quantity = quantity - ? WHERE item_code = ?");
        mysqli_stmt_bind_param($stmt, 'ds', $quantity, $code);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $insert_stmt = mysqli_prepare($conn, "INSERT INTO transactions (item_code, quantity_reduced, date) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insert_stmt, 'sis', $code, $quantity, $date);
            $insert_result = mysqli_stmt_execute($insert_stmt);
            if ($insert_result) {
                echo "Data inserted successfully.";
            } else {
                echo "Error inserting transaction data: " . mysqli_error($conn);
            }
            mysqli_stmt_close($insert_stmt);
        } else {
            echo "Error inserting data: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Quantity cannot be less than zero.";
    }
}else if($_POST['loc']=='retrieveTransactions'){			
    $det_ar=array();
    $qry="SELECT * FROM items JOIN transactions ON items.item_code LIKE CONCAT('%', transactions.item_code, '%');";
    $res=mysqli_query($conn,$qry);
    while($row=mysqli_fetch_array($res, MYSQLI_ASSOC)){
        array_push($det_ar, $row);
    }
    echo json_encode($det_ar);
}else if(isset($_POST['id']) && $_POST['loc']=='retrieveItem'){			
    $id = (int) $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $det_ar = array();
    while ($row = $result->fetch_assoc()) {
        array_push($det_ar, $row);
    }
    echo json_encode($det_ar);
}
else if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['brand']) && isset($_POST['quantity']) && $_POST['loc']=='updateItem'){
    $id = (int) $_POST['id'];
    $name = trim($_POST['name']);    
    $brand = trim($_POST['brand']);       
    $quantity = (int) $_POST['quantity'];
    $stmt = mysqli_prepare($conn, "UPDATE items SET quantity=?, brand=?, name=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'dssi', $quantity, $brand, $name, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        echo "Okay";
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

function verifyUser($userN, $userP, $conn){
    $qry="select * from users WHERE username='$userN' AND password = '$userP';";
    $rr=mysqli_query($conn,$qry);
    return mysqli_num_rows($rr);
}

?>