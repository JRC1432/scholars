<?php

require("dbconn.php");

// Update User

if(isset($_GET['updateuser'])){

    $upintid = $_POST["upintid"];
    $upusernames = $_POST["upusernames"];
    $uppassword = $_POST["uppassword"];
    $upacttype = $_POST["upacttype"];
    $passwordsHash = sha1("digi".$uppassword."digi");
    $upregions = $_POST["upregions"];
    $upcode = $_POST["upcode"];
    $upid = $_POST["id"];
    
    
    $stnt = $pdo->prepare("UPDATE users SET username = ?, internal_id = ?, password = ?, account_type = ?, region = ?, school_code = ?
    WHERE id = ?");
    $stnt -> execute([$upusernames,$upintid,$passwordsHash,$upacttype,$upregions,$upcode,$upid]);
    
     if($stnt){
            $result =  true;
        } else{
            
            $result = false;
        }
    
        echo json_encode($result);
    
    }

?>