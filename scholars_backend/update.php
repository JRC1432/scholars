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
    $stnt->execute([$upusernames,$upintid,$passwordsHash,$upacttype,$upregions,$upcode,$upid]);
    
     if($stnt){
            $result =  true;
        } else{
            
            $result = false;
        }
    
        echo json_encode($result);
    
    }


    // Update User Information




    if(isset($_GET['updateuserInfo'])){

        $upid = $_POST["id"];

        $upstaffid = $_POST["upstaffid"];
        $upfname = $_POST["upfname"];
        $upmname = $_POST["upmname"];
        $uplname = $_POST["uplname"];
        $upsname = $_POST["upsname"];
        $upgender = $_POST["upgender"];
        $upbirth = $_POST["upbirth"];
        $uppob = $_POST["uppob"];
        $upwregion = $_POST["upwregion"];
        $upscCode = $_POST["upscCode"];

        $upstreet = $_POST["upstreet"];
        $upvillage = $_POST["upvillage"];
        $upbarangay = $_POST["upbarangay"];
        $upmunicipality = $_POST["upmunicipality"];
        $upprovince = $_POST["upprovince"];
        $upregion = $_POST["upregion"];
        $updistrict = $_POST["updistrict"];
        $upzipcode = $_POST["upzipcode"];
        $upmail = $_POST["upmail"];
        $upcontact = $_POST["upcontact"];
        $upzipid = $_POST["upzipid"] ?? null;

        
        $stnt = $pdo->prepare("UPDATE staff_record SET staff_id = ?, first_name = ?, middle_name = ?, last_name = ?, suffix_name = ?, sex = ?,
        dob = ?, pob = ?, work_region = ?, school_code = ?, street = ?, village = ?, barangay = ?, municipality = ?, province = ?, region = ?,
        district = ?, zipcode = ?, email = ?, contact_no = ?, zip_id = ?
        WHERE user_id = ?");
        $stnt->execute([$upstaffid,$upfname,$upmname,$uplname,$upsname,$upgender,$upbirth,$uppob,$upwregion,$upscCode,$upstreet,$upvillage,$upbarangay,$upmunicipality,
        $upprovince,$upregion,$updistrict,$upzipcode,$upmail,$upcontact,$upzipid,$upid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }

        // Update Scholar Account

        if(isset($_GET['updateScholar'])){

            $upintid = $_POST["upintid"];
            $upusernames = $_POST["upusernames"];
            $uppassword = $_POST["uppassword"];
            $upacttype = $_POST["upacttype"];
            $passwordsHash = sha1("digi".$uppassword."digi");
            $upregions = $_POST["upregions"];
            $upscode = $_POST["upscode"];
            $upid = $_POST["id"];
            
            
            $stnt = $pdo->prepare("UPDATE users SET username = ?, internal_id = ?, password = ?, account_type = ?, region = ?, school_code = ?
            WHERE id = ?");
            $stnt->execute([$upusernames,$upintid,$passwordsHash,$upacttype,$upregions,$upscode,$upid]);
            
             if($stnt){
                    $result =  true;
                } else{
                    
                    $result = false;
                }
            
                echo json_encode($result);
            
            }

            // Update Personal info of Scholar 



            if(isset($_GET['updateScholarInfo'])){

                $upid = $_POST["id"];

                $upspasid = $_POST["upspasid"];
                $spasid_no_spaces = str_replace(' ', '', $upspasid);
            $upfname = $_POST["upfname"];
            $upmname = $_POST["upmname"];
            $uplname = $_POST["uplname"];
            $upsname = $_POST["upsname"];
            $fullname = $uplname . ', ' .  $upfname . ' ' . $upmname . ' ' . $upsname;
            $upgender = $_POST["upgender"];
            $upbirth = $_POST["upbirth"];
            $uppob = $_POST["uppob"];
            $uptribe = $_POST["uptribe"];
            $upscregions = $_POST["upscregions"];
            $upscCode = $_POST["upscCode"];
            $upmail = $_POST["upmail"];
            $upcontact = $_POST["upcontact"];
           
            $upstreet = $_POST["upstreet"];
            $upvillage = $_POST["upvillage"];
            $upbarangay = $_POST["upbarangay"];
            $upmunicipality = $_POST["upmunicipality"];
            $upprovince = $_POST["upprovince"];
            $upregion = $_POST["upregion"];
            $updistrict = $_POST["updistrict"];
            $upzip = $_POST["upzip"];
            $upcuradd = $_POST["upcuradd"];

            $upprovinceZip = $_POST["upprovinceZip"] ?? null;
                
                
                $stnt = $pdo->prepare("UPDATE scholars_record SET spas_id = ?, first_name = ?, middle_name = ?, last_name = ?, suffix_name = ?, full_name = ?, sex = ?,
                dob = ?, pob = ?, tribe = ?, street = ?, village = ?, barangay = ?, municipality = ?, province = ?, region = ?, district = ?, zipcode = ?,
                diff_curr_add = ?, email = ?, contact_no = ?, school_region = ?, school_code = ?, zip_id = ?
                WHERE user_id = ?");
                $stnt->execute([$spasid_no_spaces,$upfname,$upmname,$uplname,$upsname,$fullname,$upgender,$upbirth,$uppob,$uptribe,$upstreet,$upvillage,$upbarangay,$upmunicipality,
                $upprovince,$upregion,$updistrict,$upzip,$upcuradd,$upmail,$upcontact,$upscregions,$upscCode,$upprovinceZip,$upid]);
                
                 if($stnt){
                        $result =  true;
                    } else{
                        
                        $result = false;
                    }
                
                    echo json_encode($result);
                
                }

                // Update Scholar Current_Address


                if(isset($_GET['updateScholarAddr'])){

                    $upspasid = $_POST["upspasid"];
                    $spasid_no_spaces = str_replace(' ', '', $upspasid);
    
                  
                $upstreet2 = $_POST["upstreet2"] ?? '';
                $upvillage2 = $_POST["upvillage2"] ?? '';
                $upbarangay2 = $_POST["upbarangay2"] ?? '';
                $upmunicipality2 = $_POST["upmunicipality2"] ?? '';
                $upprovince2 = $_POST["upprovince2"] ?? '';
                $upregion2 = $_POST["upregion2"] ?? '';
                $updistrict2 = $_POST["updistrict2"] ?? '';
 
                $upzip2 = isset($_POST["upzip2"]) && is_numeric($_POST["upzip2"]) ? intval($_POST["upzip2"]) : 0;
               
                    
                    
                    $stnt = $pdo->prepare("UPDATE curr_add SET street = ?, village = ?, barangay = ?, municipality = ?, province = ?, region = ?,
                    district = ?, zipcode = ?
                    WHERE spas_id = ?");
                    $stnt->execute([$upstreet2,$upvillage2,$upbarangay2,$upmunicipality2,$upprovince2,$upregion2,$updistrict2,$upzip2,$spasid_no_spaces]);
                    
                     if($stnt){
                            $result =  true;
                        } else{
                            
                            $result = false;
                        }
                    
                        echo json_encode($result);
                    
                    }






                    // Update Reply Slip

if(isset($_GET['updateReplySlip'])){
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];

    $upspasid = $_POST["upspasid"];

    $upreply = $_POST["upreply"];
    $updaterep = $_POST["updaterep"];
    $upreply_reason = $_POST["upreply_reason"];
    $upspasid = $_POST["upspasid"];

    
    
    
    $stnt = $pdo->prepare("UPDATE reply_slip_details SET reply_slip = ?, date_reply = ?, reason = ?, updated_at = ?, updated_by = ?, verified_by = ?
    WHERE spas_id = ?");
    $stnt->execute([$upreply,$updaterep,$upreply_reason,$date,$updatedby,$updatedby,$upspasid]);
    
     if($stnt){
            $result =  true;
        } else{
            
            $result = false;
        }
    
        echo json_encode($result);
    
    }

    // Update Contract
    // Update Availing


    if(isset($_GET['updateContract'])){
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");
    
        $updatedby = $_POST["user"];
        $spasid = $_POST["spasid"];

        $cntrctStatus = $_POST["cntrctStatus"];
        $availAward = $_POST["availAward"];
        $upotherScholarship = $_POST["upotherScholarship"];
        $clocations = $_POST["clocations"];
        $upduration = $_POST["upduration"];
        $upetgMonth = $_POST["upetgMonth"];
        $upetg = $_POST["upetg"];
        $scholarDefer = ($_POST["scholarDefer"] === 'YES') ? 1 : 0;



        
        $stnt = $pdo->prepare("UPDATE contract_status_details SET contract_status = ?, avail_award = ?, other_schp = ?, contract_loc = ?, duration = ?, etg_month = ?,
        etg = ?, deferment_status = ?, updated_by = ?, updated_at = ? WHERE spas_id = ?");
        $stnt->execute([$cntrctStatus,$availAward,$upotherScholarship,$clocations,$upduration,$upetgMonth,$upetg,$scholarDefer,$updatedby,$date,$spasid]);
        
         if($stnt){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
        
        }

         // Update Deferment Details


        if(isset($_GET['updateDef'])){
            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d h:i:s a");
            
            $updatedby = $_POST["user"];
            $spasid = $_POST["spasid"];

            $defscholarDefer = ($_POST["defscholarDefer"] === 'YES') ? 1 : 0;
            $updefreason = $_POST["updefreason"];
            $upSyDef = $_POST["upSyDef"];
            $uptermtype = $_POST["uptermtype"];
            $uptermDef = $_POST["uptermDef"];
            $statsLatest = ($_POST["statsLatest"] === 'YES') ? 1 : 0;
            $recActive = ($_POST["recActive"] === 'YES') ? true : false;
    
            
            $stnt = $pdo->prepare("UPDATE deferment_details SET with_deferment_form = ?, reason = ?, sy_deferred = ?, term_type = ?, term_deferred = ?, verified_flag = ?,
            updated_by = ?, updated_at = ? WHERE spas_id = ?");
            $stnt->execute([$defscholarDefer,$updefreason,$upSyDef,$uptermtype,$uptermDef,$statsLatest,$updatedby,$date,$spasid]);
            
             if($stnt){
                    $result =  true;
                } else{
                    
                    $result = false;
                }
            
                echo json_encode($result);
            
            }

            // Update Deferment Details Contract



            if(isset($_GET['updateDefContract'])){
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d h:i:s a");
            
                $updatedby = $_POST["user"];
                $spasid = $_POST["spasid"];
                $cntrctStatus = $_POST["cntrctStatus"];
    
                
                $stnt = $pdo->prepare("UPDATE contract_status_details SET contract_status = ?, updated_by = ?, updated_at = ? WHERE spas_id = ?");
                $stnt->execute([$cntrctStatus,$updatedby,$date,$spasid]);
                
                 if($stnt){
                        $result =  true;
                    } else{
                        
                        $result = false;
                    }
                
                    echo json_encode($result);
                
                }




                // Update Did NOT AVail



            if(isset($_GET['updateDidNotAvail'])){
                date_default_timezone_set('Asia/Manila');
                $date = date("Y-m-d h:i:s a");
            
                $updatedby = $_POST["user"];
                $spasid = $_POST["spasid"];
                $cntrctStatus = $_POST["cntrctStatus"];
          
                $didNotscholarDefer = ($_POST["didNotscholarDefer"] === 'YES') ? 1 : 0;
                $didNotreason = $_POST["didNotreason"];


                $stnt = $pdo->prepare("UPDATE contract_status_details SET contract_status = ?, deferment_status = ?, reason = ?, updated_by = ?, updated_at = ? WHERE spas_id = ?");
                $stnt->execute([$cntrctStatus,$didNotscholarDefer,$didNotreason,$updatedby,$date,$spasid]);
                
                 if($stnt){
                        $result =  true;
                    } else{
                        
                        $result = false;
                    }
                
                    echo json_encode($result);
                
                }



                // Disallow Availing


                if(isset($_GET['disallowAvailing'])){
                    date_default_timezone_set('Asia/Manila');
                    $date = date("Y-m-d h:i:s a");
                
                    $updatedby = $_POST["user"];
                    $spasid = $_POST["spasid"];
                    $verified = 0;
    
    
                    $stnt = $pdo->prepare("UPDATE contract_status_details SET verified_flag = ?, updated_by = ?, updated_at = ? WHERE spas_id = ?");
                    $stnt->execute([$verified,$updatedby,$date,$spasid]);
                    
                     if($stnt){
                            $result =  true;
                        } else{
                            
                            $result = false;
                        }
                    
                        echo json_encode($result);
                    
                    }




















        

?>