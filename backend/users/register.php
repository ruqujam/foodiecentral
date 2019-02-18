<?php

include('../config/config.php');

$username = isset($_POST['username']) ? $_POST['username'] : "" ;
$name  = isset($_POST['firstName']) ? $_POST['firstName'] : "" ;
$lastname  = isset($_POST['lastName']) ? $_POST['lastName'] : "" ;
$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : "" ;
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : "" ;
$password = isset($_POST['password']) ? $_POST['password'] : "" ;
$gender = isset($_POST['gender']) ? $_POST['gender'] : "" ;



if ( strcasecmp( $gender, 'male' ) == 0 || strcasecmp( $gender, 'female' ) == 0){
    addCustomer($username,$name,$lastname,$phoneNumber,$birthday,$password,$gender,$conn);
}else{
    $convo = array('status' => 'invalidGender');
}


header('Content-Type: application/json');
echo json_encode($convo);
exit();





function addCustomer($username,$name,$lastName,$phoneNumber,$birthday,$password,$gender,$conn){



        if(!(isUserExist($username,$conn)) && !(isUserExistAccount($username,$conn))) {


            $date = new DateTime('now', new DateTimeZone('Asia/Colombo'));


            $sql = "INSERT INTO CustomerDetails VALUES (? ,?, ? , ? , ?,?,?)";
            $stmtone = sqlsrv_query($conn, $sql, array($username, $name, $lastName,$birthday, $gender, $birthday, $phoneNumber));
            if ($stmtone === false) {
                DisplayErrors();
            }

            if ($stmtone) {

                $sql = "INSERT INTO CustomerLogins VALUES (? ,?)";
                $stmtone = sqlsrv_query($conn, $sql, array($username, $password));
                if ($stmtone === false) {
                    DisplayErrors();
                }

                if ($stmtone) {

                    $convo = array('status' => 'success');

                }else{

                    $convo = array('status' => 'failed');
                }



            } else {

                $convo = array('status' => 'failed');

            }
        }else{

            $convo = array('status' => 'accountExist');

        }


        header('Content-Type: application/json');
        echo json_encode($convo);
        exit();

}


function isUserExist($customerId,$conn){

    $sql="SELECT * FROM CustomerDetails WHERE CustomerId='".$customerId."'";
    $result=sqlsrv_query($conn,$sql, array(), array( "Scrollable" => 'static' ));
    $count=sqlsrv_num_rows($result);
    if($count==1){

        sqlsrv_free_stmt( $result);
        return true;

    }
    else{


        sqlsrv_free_stmt( $result);
        return false;
    }

}


function isUserExistAccount($customerId,$conn){

    $sql="SELECT * FROM CustomerLogins WHERE CustomerId='".$customerId."'";
    $result=sqlsrv_query($conn,$sql, array(), array( "Scrollable" => 'static' ));
    $count=sqlsrv_num_rows($result);
    if($count==1){

        sqlsrv_free_stmt( $result);
        return true;

    }
    else{


        sqlsrv_free_stmt( $result);
        return false;
    }

}

?>
