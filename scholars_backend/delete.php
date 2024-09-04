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



         // Delete Contract 

    if(isset($_GET['delContract'])){

    
        $delSpasid = $_POST["delSpasid"];
        
        
        $stnt = $pdo->prepare("DELETE FROM contract_status_details WHERE spas_id = ?");
        $stnt->execute([$delSpasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }


        // Delete Defer Contract 

    if(isset($_GET['delDefContract'])){

    
        $delSpasid = $_POST["delSpasid"];
        
        
        $stnt = $pdo->prepare("DELETE FROM deferment_details WHERE spas_id = ?");
        $stnt->execute([$delSpasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }



?>