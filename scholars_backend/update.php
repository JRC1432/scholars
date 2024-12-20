<?php

require("dbconn.php");

// Update User

if (isset($_GET['updateuser'])) {

    $upintid = $_POST["upintid"];
    $upusernames = $_POST["upusernames"];
    $uppassword = $_POST["uppassword"];
    $upacttype = $_POST["upacttype"];
    $passwordsHash = sha1("digi" . $uppassword . "digi");
    $upregions = $_POST["upregions"];
    $upcode = $_POST["upcode"];
    $upid = $_POST["id"];


    $stnt = $pdo->prepare("UPDATE users SET username = ?, internal_id = ?, password = ?, account_type = ?, region = ?, school_code = ?
    WHERE id = ?");
    $stnt->execute([$upusernames, $upintid, $passwordsHash, $upacttype, $upregions, $upcode, $upid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}


// Update User Information




if (isset($_GET['updateuserInfo'])) {

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
    $stnt->execute([
        $upstaffid,
        $upfname,
        $upmname,
        $uplname,
        $upsname,
        $upgender,
        $upbirth,
        $uppob,
        $upwregion,
        $upscCode,
        $upstreet,
        $upvillage,
        $upbarangay,
        $upmunicipality,
        $upprovince,
        $upregion,
        $updistrict,
        $upzipcode,
        $upmail,
        $upcontact,
        $upzipid,
        $upid
    ]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}

// Update Scholar Account

if (isset($_GET['updateScholar'])) {

    $upintid = $_POST["upintid"];
    $upusernames = $_POST["upusernames"];
    $uppassword = $_POST["uppassword"];
    $upacttype = $_POST["upacttype"];
    $passwordsHash = sha1("digi" . $uppassword . "digi");
    $upregions = $_POST["upregions"];
    $upscode = $_POST["upscode"];
    $upid = $_POST["id"];


    $stnt = $pdo->prepare("UPDATE users SET username = ?, internal_id = ?, password = ?, account_type = ?, region = ?, school_code = ?
            WHERE id = ?");
    $stnt->execute([$upusernames, $upintid, $passwordsHash, $upacttype, $upregions, $upscode, $upid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}

// Update Personal info of Scholar 



if (isset($_GET['updateScholarInfo'])) {

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
    $stnt->execute([
        $spasid_no_spaces,
        $upfname,
        $upmname,
        $uplname,
        $upsname,
        $fullname,
        $upgender,
        $upbirth,
        $uppob,
        $uptribe,
        $upstreet,
        $upvillage,
        $upbarangay,
        $upmunicipality,
        $upprovince,
        $upregion,
        $updistrict,
        $upzip,
        $upcuradd,
        $upmail,
        $upcontact,
        $upscregions,
        $upscCode,
        $upprovinceZip,
        $upid
    ]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}

// Update Scholar Current_Address


if (isset($_GET['updateScholarAddr'])) {

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
    $stnt->execute([$upstreet2, $upvillage2, $upbarangay2, $upmunicipality2, $upprovince2, $upregion2, $updistrict2, $upzip2, $spasid_no_spaces]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}






// Update Reply Slip

if (isset($_GET['updateReplySlip'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];

    $upscholarid = $_POST["upscholarid"];

    $upreply = $_POST["upreply"];
    $updaterep = $_POST["updaterep"];
    $upreply_reason = $_POST["upreply_reason"];



    $stnt = $pdo->prepare("UPDATE reply_slip_details SET reply_slip = ?, date_reply = ?, reason = ?, updated_at = ?, updated_by = ?, verified_by = ?
    WHERE scholar_id = ?");
    $stnt->execute([$upreply, $updaterep, $upreply_reason, $date, $updatedby, $updatedby, $upscholarid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}

// Update Contract
// Update Availing


if (isset($_GET['updateContract'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];

    $cntrctStatus = $_POST["cntrctStatus"];
    $availAward = $_POST["availAward"];
    $upotherScholarship = $_POST["upotherScholarship"];
    $clocations = $_POST["clocations"];
    $upduration = $_POST["upduration"];
    $upetgMonth = $_POST["upetgMonth"];
    $upetg = $_POST["upetg"];
    $scholarDefer = ($_POST["scholarDefer"] === 'YES') ? 1 : 0;
    $sc = $_POST["upscrTerm"];
    $termid = $_POST["uptermRec"];





    $stnt = $pdo->prepare("UPDATE contract_status_details SET contract_status = ?, avail_award = ?, other_schp = ?, contract_loc = ?, duration = ?, etg_month = ?,
        etg = ?, deferment_status = ?, course_id = ?, term_id = ?, updated_by = ?, updated_at = ? WHERE scholar_id = ?");
    $stnt->execute([
        $cntrctStatus,
        $availAward,
        $upotherScholarship,
        $clocations,
        $upduration,
        $upetgMonth,
        $upetg,
        $scholarDefer,
        $sc,
        $termid,
        $updatedby,
        $date,
        $scholarid
    ]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}

// Update Deferment Details


if (isset($_GET['updateDef'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];

    $defscholarDefer = ($_POST["defscholarDefer"] === 'YES') ? 1 : 0;
    $updefreason = $_POST["updefreason"];
    $upSyDef = $_POST["upSyDef"];
    $uptermtype = $_POST["uptermtype"];
    $uptermDef = $_POST["uptermDef"];
    $statsLatest = ($_POST["statsLatest"] === 'YES') ? 1 : 0;
    $recActive = ($_POST["recActive"] === 'YES') ? true : false;

    // First, check if the scholar_id exists
    $checkStmt = $pdo->prepare("SELECT scholar_id FROM deferment_details WHERE scholar_id = ?");
    $checkStmt->execute([$scholarid]);
    $spasExists = $checkStmt->fetchColumn();

    if ($spasExists) {
        // Update the record if scholar_id exists
        $stnt = $pdo->prepare("UPDATE deferment_details SET with_deferment_form = ?, reason = ?, sy_deferred = ?, term_type = ?, term_deferred = ?, verified_flag = ?,
                updated_by = ?, updated_at = ? WHERE scholar_id = ?");
        $stnt->execute([$defscholarDefer, $updefreason, $upSyDef, $uptermtype, $uptermDef, $statsLatest, $updatedby, $date, $scholarid]);
    } else {
        // Insert a new record if scholar_id doesn't exist
        $stnt = $pdo->prepare("INSERT INTO deferment_details (scholar_id, with_deferment_form, reason, sy_deferred, term_type, term_deferred, verified_flag, updated_by, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stnt->execute([$scholarid, $defscholarDefer, $updefreason, $upSyDef, $uptermtype, $uptermDef, $statsLatest, $updatedby, $date]);
    }

    if ($stnt) {
        $result = true;
    } else {
        $result = false;
    }

    echo json_encode($result);
}


// Update Deferment Details Contract



if (isset($_GET['updateDefContract'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];
    $cntrctStatus = $_POST["cntrctStatus"];


    $stnt = $pdo->prepare("UPDATE contract_status_details SET contract_status = ?, updated_by = ?, updated_at = ? WHERE scholar_id = ?");
    $stnt->execute([$cntrctStatus, $updatedby, $date, $scholarid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}




// Update Did NOT AVail



if (isset($_GET['updateDidNotAvail'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];
    $cntrctStatus = $_POST["cntrctStatus"];

    $didNotscholarDefer = ($_POST["didNotscholarDefer"] === 'YES') ? 1 : 0;
    $didNotreason = $_POST["didNotreason"];


    $stnt = $pdo->prepare("UPDATE contract_status_details SET contract_status = ?, deferment_status = ?, reason = ?, updated_by = ?, updated_at = ? WHERE scholar_id = ?");
    $stnt->execute([$cntrctStatus, $didNotscholarDefer, $didNotreason, $updatedby, $date, $scholarid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Disallow Availing


if (isset($_GET['disallowAvailing'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];
    $verified = 0;


    $stnt = $pdo->prepare("UPDATE contract_status_details SET verified_flag = ?, updated_by = ?, updated_at = ? WHERE scholar_id = ?");
    $stnt->execute([$verified, $updatedby, $date, $scholarid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}




// Allow Availing


if (isset($_GET['allowAvailing'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];
    $verified = 1;


    $stnt = $pdo->prepare("UPDATE contract_status_details SET verified_flag = ?, updated_by = ?, updated_at = ? WHERE scholar_id = ?");
    $stnt->execute([$verified, $updatedby, $date, $scholarid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}




// Update Progress Status start


if (isset($_GET['upProgressStart'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $updatedby = $_POST["user"];
        $spasid = $_POST["spasid"];
        $status = ($_POST["status"] === 'YES') ? 1 : 0;
        $psProgressStats = $_POST["psProgressStats"];
        $termid = $_POST["termid"];
        $act_taken = "UPDATE";
        $act_message = "Progress Status (START) has been updated in " . $spasid . " with Term ID: " . $termid;


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE progress_status_history SET progress_status = ?, latest_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 1 AND term_id = ?");
        $stnt->execute([$psProgressStats, $status, $date, $updatedby, $spasid, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);

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


// Update Progress Status end


if (isset($_GET['upProgressEnd'])) {

    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $updatedby = $_POST["user"];
        $spasid = $_POST["spasid"];
        $status = ($_POST["status"] === 'YES') ? 1 : 0;
        $peProgressStats = $_POST["peProgressStats"];
        $termid = $_POST["term_ID_Pend"];
        $act_taken = "UPDATE";
        $act_message = "Progress Status (END) of " . $spasid . " has been updated successfully";


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE progress_status_history SET progress_status = ?, latest_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 2 AND term_id = ?");
        $stnt->execute([$peProgressStats, $status, $date, $updatedby, $spasid, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);





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


// Update Start of Term Standing


if (isset($_GET['upStartTermStanding'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $updatedby = $_POST["user"];
        $spasid = $_POST["spasid"];
        $status = ($_POST["status"] === 'YES') ? 1 : 0;
        $startTermProgressStat = $_POST["startTermProgressStat"];
        $termid = $_POST["start_Term_Id"];
        $act_taken = "UPDATE";
        $act_message = "Start of Term Standing has been updated in " . $spasid . " with Term ID: " . $termid;


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE standing_history SET standing = ?, latest_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 1 AND term_id = ?");
        $stnt->execute([$startTermProgressStat, $status, $date, $updatedby, $spasid, $termid]);

        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);

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






// Update End of Term Standing


if (isset($_GET['upEndTermStanding'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $updatedby = $_POST["user"];
        $spasid = $_POST["spasid"];
        $status = ($_POST["status"] === 'YES') ? 1 : 0;
        $endTermProgressStat = $_POST["endTermProgressStat"];
        $termid = $_POST["term_ID_endTerm"];
        $act_taken = "UPDATE";
        $act_message = "End of Term Standing of " . $spasid . " has been updated successfully";



        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE standing_history SET standing = ?, latest_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 2 AND term_id = ?");
        $stnt->execute([$endTermProgressStat, $status, $date, $updatedby, $spasid, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);

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

// Verify Progress Status start


if (isset($_GET['verifyProgressStart'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 1;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE progress_status_history SET verified_flag = ?, updated_at = ?, updated_by = ?, verified_by = ?
                    WHERE spas_id = ? AND start_end = 1 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Disallow Progress Status start


if (isset($_GET['disProgressStart'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 0;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE progress_status_history SET verified_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 1 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}


// Verify Start of Term Standing


if (isset($_GET['verifyStartTermStanding'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 1;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE standing_history SET verified_flag = ?, updated_at = ?, updated_by = ?, verified_by = ? 
                    WHERE spas_id = ? AND start_end = 1 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}




// Disallow Start of Term Standing


if (isset($_GET['disStartTermStanding'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 0;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE standing_history SET verified_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 1 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}


// Verify Progress Status start


if (isset($_GET['verifyProgressEnd'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 1;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE progress_status_history SET verified_flag = ?, updated_at = ?, updated_by = ?, verified_by = ? 
                    WHERE spas_id = ? AND start_end = 2 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}




// Disallow Progress Status end


if (isset($_GET['disProgressEnd'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 0;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE progress_status_history SET verified_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 2 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Verify Start of Term Standing


if (isset($_GET['verifyEndTermStanding'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 1;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE standing_history SET verified_flag = ?, updated_at = ?, updated_by = ?, verified_by = ? 
                    WHERE spas_id = ? AND start_end = 2 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Disallow End of Term Standing


if (isset($_GET['disEndTermStanding'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $spasid = $_POST["spasid"];
    $verify_flag = 0;
    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE standing_history SET verified_flag = ?, updated_at = ?, updated_by = ? 
                    WHERE spas_id = ? AND start_end = 2 AND term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Update Grades


if (isset($_GET['updateGrades'])) {
    try {


// if($_SESSION['loggedInUser']['account_type'] == );

        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $computedGwa = $_POST["computedGwa"];
        $spasid = $_POST["spasid"];
        $act_taken = "UPDATE";
        $act_message = "Grades Information was updated in " . $spasid . " with Term ID: " . $termid;

        // Fetch full name from scholars_record table
        $stntf = $pdo->prepare("SELECT full_name FROM scholars_record WHERE spas_id = ?");
        $stntf->execute([$spasid]);
        $fname = $stntf->fetchColumn();

        // Start transaction
        $pdo->beginTransaction();

        // Loop through the posted 'todos' data and update the grades
        foreach ($_POST['todos'] as $todo) {
            $subj_id = $todo['subj_id'] ?? null;
            $scode = $todo['scode'] ?? null;
            $academic = $todo['academic'] ?? null;
            $units = $todo['units'] ?? null;
            $grade = $todo['grade'] ?? null;
            $completion = $todo['completion'] ?? null;
            $remarks = $todo['remarks'] ?? null;

            // Prepare and execute update for grades
            $stnt = $pdo->prepare("
                UPDATE grades 
                SET subj_code = ?, academic_type = ?, unit = ?, grade = ?, completion = ?, remarks = ?, updated_at = ?, updated_by = ?
                WHERE subj_id = ? AND term_id = ?
            ");
            $stnt->execute([$scode, $academic, $units, $grade, $completion, $remarks, $date, $updatedby, $subj_id, $termid]);
        }

        // Update term_record table
        $stnt1 = $pdo->prepare("UPDATE term_record SET grade_ave = ? WHERE term_id = ?");
        $stnt1->execute([$computedGwa, $termid]);

        // Insert activity log
        $stnt2 = $pdo->prepare("
            INSERT INTO activity_logs (spas_id, full_name, action_taken, action_message, action_taken_by, date_time)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $params = [$spasid, $fname, $act_taken, $act_message, $updatedby, $date];
        $stnt2->execute($params);

        // Commit transaction
        $pdo->commit();

        // Return success response
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






// Disallow Grades


if (isset($_GET['disGrades'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $verif = 0;
        $act_taken = "UPDATE";
        $act_message = "Disallowed Grades on " . $spasid . "with Term ID: " . $termid . "";



        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET grades_verified_flag = ?, updated_at = ?, updated_by = ? , grades_verified_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$verif, $date, $updatedby, $updatedby, $termid]);



        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);


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



// Disallow Registration Form


if (isset($_GET['disRefForm'])) {

    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $verif = 0;
        $act_taken = "UPDATE";
        $act_message = "Disallowed Registration Form to " . $spasid . "with Term ID: " . $termid . "";




        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET reg_verified_flag = ?, updated_at = ?, updated_by = ? , reg_verified_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$verif, $date, $updatedby, $updatedby, $termid]);



        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);




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



// Verify Grades


if (isset($_GET['verifGrades'])) {
    try {

        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $verif = 1;
        $act_taken = "UPDATE";
        $act_message = "Verified Grades on " . $spasid . "with Term ID: " . $termid . "";


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET grades_verified_flag = ?, updated_at = ?, updated_by = ? , grades_verified_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$verif, $date, $updatedby, $updatedby, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);


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



// Verify Grades


if (isset($_GET['verifReg'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $verif = 1;
        $act_taken = "UPDATE";
        $act_message = "Registration Form Verified to " . $spasid . "with Term ID: " . $termid . "";


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }




        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET reg_verified_flag = ?, updated_at = ?, updated_by = ? , reg_verified_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$verif, $date, $updatedby, $updatedby, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);





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






// Latest Grades


if (isset($_GET['latestGrades'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");


        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $latest = 1;
        $act_taken = "UPDATE";
        $act_message = "Latest Flag has been set to " . $spasid . "with Term ID: " . $termid . "";




        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET latest_flag = ?, updated_at = ?, updated_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$latest, $date, $updatedby, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);



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




// Latest-Old Grades


if (isset($_GET['falseLatestGrades'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");


        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $latest = 0;
        $act_taken = "UPDATE";
        $act_message = "Latest Flag has been modified to " . $spasid . "with Term ID: " . $termid . "";


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET latest_flag = ?, updated_at = ?, updated_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$latest, $date, $updatedby, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);



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


// Term Recquired YES


if (isset($_GET['termReqYes'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $term = 1;
        $act_taken = "UPDATE";
        $act_message = "Term Required has been set to " . $spasid . "";


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }




        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET term_required = ?, updated_at = ?, updated_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$term, $date, $updatedby, $termid]);

        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);


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



// Term Recquired NO


if (isset($_GET['termReqNo'])) {
    try {
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d h:i:s a");

        $spasid = $_POST["spasid"];
        $updatedby = $_POST["user"];
        $termid = $_POST["termid"];
        $term = 0;
        $act_taken = "UPDATE";
        $act_message = "Term NOT Required has been set to " . $spasid . "";


        $stntf = $pdo->prepare("SELECT full_name
                    FROM scholars_record 
                    WHERE spas_id = ?");

        $stntf->execute([$spasid]);

        while ($row = $stntf->fetch(PDO::FETCH_ASSOC)) {

            $fname = $row['full_name'];
        }


        $pdo->beginTransaction();
        $stnt = $pdo->prepare("UPDATE term_record SET term_required = ?, updated_at = ?, updated_by = ?
                    WHERE term_id = ?");
        $stnt->execute([$term, $date, $updatedby, $termid]);


        $stnt1 = $pdo->prepare("INSERT INTO activity_logs(spas_id,full_name,action_taken,action_message,action_taken_by,date_time) VALUES (?,?,?,?,?,?)");
        $params = array($spasid, $fname, $act_taken, $act_message, $updatedby, $date);
        $stnt1->execute($params);


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



// Update New Term Rec




if (isset($_GET['upTermRecordGrades'])) {

    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");
    $user = $_POST["user"];

    $spasid = $_POST["spasid"];
    $termid = $_POST['termid'];
    $sy = $_POST["sy"];
    $term = $_POST["term"];
    $termtype = $_POST['termtype'];
    $termreq = $_POST["newcurriculum"] === 'YES' ? 1 : 0;
    $course_id = $_POST['schoolcourse'];
    $act_flag = 1;




    $stnt = $pdo->prepare("UPDATE term_record SET spas_id = ?, sy = ?, term = ?, term_type = ?, term_required = ?, course_id = ?, active_flag = ?, created_at = ?,
            created_by = ? 
            WHERE term_id = ?");

    $params = array($spasid, $sy, $term, $termtype, $termreq, $course_id, $act_flag, $date, $user, $termid);
    $stnt->execute($params);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Disallow Replyslip


if (isset($_GET['disReplySlip'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];
    $verified = 0;


    $stnt = $pdo->prepare("UPDATE reply_slip_details SET verified_flag = ?, updated_by = ?, updated_at = ? WHERE scholar_id = ?");
    $stnt->execute([$verified, $updatedby, $date, $scholarid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Allow Replyslip


if (isset($_GET['allowReplySlip'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $scholarid = $_POST["scholarid"];
    $verified = 1;


    $stnt = $pdo->prepare("UPDATE reply_slip_details SET verified_flag = ?, updated_by = ?, updated_at = ? WHERE scholar_id = ?");
    $stnt->execute([$verified, $updatedby, $date, $scholarid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}


// Allow Course


if (isset($_GET['allowCourse'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $sc_termid = $_POST["sc_termid"];
    $verified = 1;


    $stnt = $pdo->prepare("UPDATE course_record SET verified_flag = ?, updated_by = ?, verified_by = ?, updated_at = ? WHERE term_id = ?");
    $stnt->execute([$verified, $updatedby, $updatedby, $date, $sc_termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



// Disallow Course


if (isset($_GET['disallowCourse'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $sc_termid = $_POST["sc_termid"];
    $verified = 0;


    $stnt = $pdo->prepare("UPDATE course_record SET verified_flag = ?, updated_by = ?, verified_by = ?, updated_at = ? WHERE term_id = ?");
    $stnt->execute([$verified, $updatedby, $updatedby, $date, $sc_termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}



if (isset($_GET['upTermRecProgress'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $pStart = $_POST[""];
    $sStart = $_POST[""];

    $termid = $_POST["termid"];



    $stnt = $pdo->prepare("UPDATE term_record SET progress_status_start = ?, standing_start = ?
                    WHERE term_id = ?");
    $stnt->execute([$verify_flag, $date, $updatedby, $updatedby, $spasid, $termid]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}


// Updating Financials

if (isset($_GET['updateFinancials'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");

    $updatedby = $_POST["user"];
    $finance_release = $_POST["finance_id"];
    $totalamt = $_POST["totalamt"];


    // Initialize an empty array to hold todos
    $todos = [];
    $results = [];

    // Loop through the posted 'todos' data and collect them into the array
    foreach ($_POST['todos'] as $index => $todo) {

        $financial_statement_ids = $todo['financial_statement_ids'] ?? null;
        $term_ids = $todo['term_ids'] ?? null;
        $category = (int) ($todo['category'] ?? 0);
        // $year = (int) ($todo['year'] ?? null);
        // $month = (int) ($todo['month'] ?? null);
        $date_process = $todo['date_process'] ?? null;
        $amount = (int) ($todo['amount'] ?? 0);
        // $date_deposit = $todo['date_deposit'] ?? null;
        $remarks = $todo['remarks'] ?? null;



        $date_deposit = $todo['date_deposit'];
        if (empty($date_deposit) || $date_deposit === 'mm/dd/yyyy') {
            $date_deposit = null; // Ensure NULL is passed
        }

        $year = isset($todo['year']) && $todo['year'] !== '' ? (int) $todo['year'] : null;
        $month = isset($todo['month']) && $todo['month'] !== '' ? (int) $todo['month'] : null;





        // Add each todo to the $todos array
        $todos[] = [
            'financial_statement_ids' => $financial_statement_ids,
            'term_ids' => $term_ids,
            'category' => $category,
            'year' => $year,
            'month' => $month,
            'date_process' => $date_process,
            'amount' => $amount,
            'date_deposit' => $date_deposit,
            'remarks' => $remarks
        ];


        if ($financial_statement_ids == 'undefined') {

            $stnt = $pdo->prepare("INSERT INTO financial_statement(financial_release_id,term_id,category,year,month,date_process,amount,date_deposit,remarks,created_by,created_at) 
                                VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $params = array($finance_release, $term_ids, $category, $year, $month, $date_process, $amount, $date_deposit, $remarks, $updatedby, $date);
            $success =  $stnt->execute($params);
        } else {



            // Prepare the SQL statement for each item in the todos array
            $stnt = $pdo->prepare("UPDATE financial_statement SET term_id = ?, category = ?, year = ?, month = ?, date_process = ?, amount = ?, date_deposit = ?, remarks = ?,
                         update_by = ?, update_at = ? WHERE financial_statement_id = ?");

            // Execute the statement with the current todo's values
            $success = $stnt->execute([$term_ids, $category, $year, $month, $date_process, $amount, $date_deposit, $remarks, $updatedby, $date, $financial_statement_ids]);
        }
        $results[] = $success;
    }
    $result = !in_array(false, $results);

    echo json_encode($result);
}



// Update Financal Release



if (isset($_GET['upFinancialRelease'])) {
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d h:i:s a");
    $update_by = $_POST["user"];

    $finance_id = $_POST["finance_id"];
    $totalamt = $_POST["totalamt"];


    $stnt = $pdo->prepare("UPDATE financial_release SET total_amt = ?, updated_at = ?, updated_by = ?
                        WHERE id = ?");
    $stnt->execute([$totalamt, $date, $update_by, $finance_id]);

    if ($stnt) {
        $result =  true;
    } else {

        $result = false;
    }

    echo json_encode($result);
}




// Progress Status Batch Update


if (isset($_GET['updateBatchProgressStats'])) {
    date_default_timezone_set('Asia/Manila');
    $dates = date("Y-m-d h:i:s a");
    $date = date("Ymdhi");

    $startEnd = $_POST["startEnd"];
    $stats = $_POST["stats"];
    $actflag = $_POST["actflag"];
    $validation = $_POST["validation"];
    $uname = $_POST["user"];
    $authid = $_POST["userid"];

    // Bulk Upload
    $bathcFile = $_FILES['fileUpload']['name'];
    $path = 'batch/';
    $allowed_extensions = array('csv');
    $extension = pathinfo($bathcFile, PATHINFO_EXTENSION);

    if (in_array(strtolower($extension), $allowed_extensions)) {
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }

        $temp_file = $_FILES['fileUpload']['tmp_name'];
        $newpath = $path . $authid . $uname . $date . "." . $extension;

        if (!move_uploaded_file($temp_file, $newpath)) {
            $newpath = "No_Files";
        }
    } else {
        $newpath = "No_Files";
    }

    $fileUploadedSuccessfully = ($newpath !== "No_Files");
    $result = true; // Assume success unless proven otherwise

    if ($fileUploadedSuccessfully) {
        $b = false;
        $file = fopen($newpath, "r");

        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
            if (!$b) { // Skip the header row
                $b = true;
                continue;
            }

            $stnt = $pdo->prepare("INSERT INTO temp_record17508(spas_id, sy, term, term_type, course, school, progress_status, standing) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $executionResult = $stnt->execute([
                $emapData[0],
                $emapData[1],
                $emapData[2],
                $emapData[3],
                $emapData[4],
                $emapData[5],
                $emapData[6],
                $emapData[7]
            ]);

            if (!$executionResult) {
                $result = false; // Set result to false if any execution fails
            }
        }
        fclose($file);
    } else {
        $result = false; // File upload failed
    }

    echo json_encode($result); // Output the final result once
}





// Developed By: CASTAÑARES, JONATHAN R.
