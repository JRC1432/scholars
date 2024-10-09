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

    
        $delScholarid = $_POST["delScholarid"];
        
        
        $stnt = $pdo->prepare("DELETE FROM reply_slip_details WHERE scholar_id = ?");
        $stnt->execute([$delScholarid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }



         // Delete Contract 

    if(isset($_GET['delContract'])){

    
        $delSpasid = $_POST["delScholarid"];
        
        
        $stnt = $pdo->prepare("DELETE FROM contract_status_details WHERE scholar_id = ?");
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



         // Delete Progress Status Start

    if(isset($_GET['delProgressStart'])){

    
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        
        
        $stnt = $pdo->prepare("UPDATE progress_status_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 1");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }


        // Delete Start of Term Standing

    if(isset($_GET['delStartTerm'])){

    
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        
        
        $stnt = $pdo->prepare("UPDATE standing_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 1");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }



        // Delete Progress Status (END)

    if(isset($_GET['delProgressEnd'])){

    
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        
        
        $stnt = $pdo->prepare("UPDATE progress_status_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 2");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }


        // Delete End of Term Standing

    if(isset($_GET['delEndTerm'])){

    
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        
        
        $stnt = $pdo->prepare("UPDATE standing_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 2");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }




         // Delete Defer Contract 

    if(isset($_GET['delGrades'])){

    
        $delSpasid = $_POST["subjectid"];
        
        
        $stnt = $pdo->prepare("DELETE FROM grades WHERE subj_id = ?");
        $stnt->execute([$delSpasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }




?>