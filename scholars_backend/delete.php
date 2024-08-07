<?php

require("dbconn.php");


// Delete User


if(isset($_GET['delUserInfo'])){

    
    $userid = $_POST["id"];
    
    
    $stnt = $pdo->prepare("UPDATE users SET status = 'inactive'
    WHERE id = ?");
    $stnt->execute([$userid]);
    
     if($stnt){
            $result =  true;
        } else{
            
            $result = false;
        }
    
        echo json_encode($result);
    
    }


    // Delete Reply SLip

    if(isset($_GET['delReplySlip'])){

    
        $delSpasid = $_POST["delSpasid"];
        
        
        $stnt = $pdo->prepare("DELETE FROM reply_slip_details WHERE spas_id = ?");
        $stnt->execute([$delSpasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }



?>