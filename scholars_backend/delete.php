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

        try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");
        $delby = $_POST["user"];
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        $act_taken = "DELETE";
        $act_message = "Start Status of " . $spasid. " has been removed successfully"; 



        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

                    $stntf->execute([$spasid]);
         
                    while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
                 
                        $fname = $row['full_name'];    
                
                    }


        
        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE progress_status_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 1");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid,$fname,$act_taken,$act_message,$delby,$date);
        $stnt1 -> execute($params);
        
          // Commit transaction
          $pdo->commit();
          echo json_encode(true);
      } catch (Exception $e) {
          // Rollback transaction on failure
          if ($pdo->inTransaction()) {
                  $pdo->rollBack();
              }
          // Log or return the error
          echo json_encode(['error' => $e->getMessage()]);
      }
        
        }


        // Delete Start of Term Standing

    if(isset($_GET['delStartTerm'])){

        try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");
        $delby = $_POST["user"];
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        $act_taken = "DELETE";
        $act_message = "Start Term of " . $spasid. " has been removed successfully";


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

                    $stntf->execute([$spasid]);
         
                    while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
                 
                        $fname = $row['full_name'];    
                
                    }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE standing_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 1");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);

        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid,$fname,$act_taken,$act_message,$delby,$date);
        $stnt1 -> execute($params);
        
         // Commit transaction
         $pdo->commit();
         echo json_encode(true);
     } catch (Exception $e) {
         // Rollback transaction on failure
         if ($pdo->inTransaction()) {
                 $pdo->rollBack();
             }
         // Log or return the error
         echo json_encode(['error' => $e->getMessage()]);
     }
        
        }



        // Delete Progress Status (END)

    if(isset($_GET['delProgressEnd'])){


        try {

        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");
        $delby = $_POST["user"];
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        $act_taken = "DELETE";
        $act_message = "Status End of " . $spasid. " has been removed successfully"; 


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

                    $stntf->execute([$spasid]);
         
                    while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
                 
                        $fname = $row['full_name'];    
                
                    }
        
        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE progress_status_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 2");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);

        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid,$fname,$act_taken,$act_message,$delby,$date);
        $stnt1 -> execute($params);
        
         // Commit transaction
         $pdo->commit();
         echo json_encode(true);
     } catch (Exception $e) {
         // Rollback transaction on failure
         if ($pdo->inTransaction()) {
                 $pdo->rollBack();
             }
         // Log or return the error
         echo json_encode(['error' => $e->getMessage()]);
     }
        
        }


        // Delete End of Term Standing

    if(isset($_GET['delEndTerm'])){

        try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");
        $delby = $_POST["user"];
        $deltermid = $_POST["deltermid"];
        $spasid = $_POST["spasid"];
        $sctive_flag = 0;
        $act_taken = "DELETE";
        $act_message = "End Term of " . $spasid. " has been removed successfully";


        $stntf = $pdo->prepare("SELECT full_name
        FROM scholars_record 
        WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
     
            $fname = $row['full_name'];    
    
        }
        
        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE standing_history SET active_flag = ? WHERE term_id = ? AND spas_id = ? AND start_end = 2");
        $stnt->execute([$sctive_flag,$deltermid,$spasid]);

        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid,$fname,$act_taken,$act_message,$delby,$date);
        $stnt1 -> execute($params);
        
         // Commit transaction
         $pdo->commit();
         echo json_encode(true);
     } catch (Exception $e) {
         // Rollback transaction on failure
         if ($pdo->inTransaction()) {
                 $pdo->rollBack();
             }
         // Log or return the error
         echo json_encode(['error' => $e->getMessage()]);
     }
        
        }




         // Delete Defer Contract 

    if(isset($_GET['delGrades'])){
        try {
            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d h:i:s a");

        $spasid = $_POST["spasid"];
        $termid = $_POST["termid"];
        $delSubjectid = $_POST["subjectid"];
        $act_taken = "DELETE";
        $act_message = "The Grade was deleted in " . $spasid. "with Term ID: " . $termid; 
        $updatedby = $_POST["user"];


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

                    $stntf->execute([$spasid]);
         
                    while ($row = $stntf->fetch(PDO::FETCH_ASSOC)){
                 
                        $fname = $row['full_name'];    
                
                    }

        
        $pdo->beginTransaction();
        $stnt = $pdo->prepare("DELETE FROM grades WHERE subj_id = ?");
        $stnt->execute([$delSubjectid]);

        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
                    $params = array($spasid,$fname,$act_taken,$act_message,$updatedby,$date);
                    $stnt1 -> execute($params);
        
        // Commit transaction
        $pdo->commit();
        echo json_encode(true);
    } catch (Exception $e) {
        // Rollback transaction on failure
        if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
        // Log or return the error
        echo json_encode(['error' => $e->getMessage()]);
    }
        
        }



        // Delete Financial Statement


if(isset($_GET['delFinancial'])){

   
    $userid = $_POST["id"];
    
    
    $stnt = $pdo->prepare("UPDATE financial_statement SET active_flag = false
    WHERE financial_statement_id = ?");
    $stnt->execute([$userid]);
    
     if($stnt){
            $result =  true;
        } else{
            
            $result = false;
        }
    
        echo json_encode($result);
    
    }










// Developed By: CASTAÑARES, JONATHAN R.
?>