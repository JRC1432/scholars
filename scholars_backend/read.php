<?php

require("dbconn.php");


// Authentication

if(isset($_GET['usnames'])){


    $out = array('error' => false);
    
    $usernames = $_POST['usernames'];
    $password = $_POST['password'];
    $passwordsHash = sha1("digi".$password."digi");
    
    
        $stnt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $params = array($usernames,$passwordsHash);
        $stnt->execute($params);
        $row=$stnt->fetch();
    
    
    
        if ($row){
            $_SESSION['loggedInUser']=$row;
                    $out['message'] = "Login Successful";
        }else{
            $out['error'] = true;
            $out['message'] = "Login Failed";
        }
    
    
    echo json_encode($out);
    die();
    }
    
    
    if (isset($_GET['authLog'])){
        // session_destroy();
        if(isset($_SESSION['loggedInUser'])){
           echo json_encode($_SESSION["loggedInUser"]);
        }else{
            echo json_encode(false);
        }
    }
    
    
    
    // Authentication Logout
    
    if(isset($_GET['authlogout'])){
        session_destroy();
        // $_SESSION['variable']
        echo "Log out";
    }


    // Read Users on Dashboard

if(isset($_GET['readuser'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT s.staff_id, s.first_name, s.middle_name, s.last_name, s.suffix_name,
s.sex, s.dob, s.pob, s.work_region, s.school_code as srscode, s.street,
s.village, s.barangay, s.municipality, s.province, s.region as srregion,
s.district, s.zipcode, s.email, s.contact_no, s.zip_id, u.id, u.username, u.internal_id,
u.account_type, u.region as uregion, u.school_code as uscode, z.zzid,
z.zreg, z.zpro, z.zmun, z.zbar, z.zzip, z.zdis, z.zpov

        FROM staff_record as s
        LEFT OUTER JOIN users AS u ON s.user_id = u.id
		LEFT OUTER JOIN esch_shared.zipi as z ON s.zipcode = z.zzid
        WHERE u.status = 'active' 
        ORDER BY 
        id DESC;
    ");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Account Type

if(isset($_GET['acttypes'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT account_type FROM users GROUP BY account_type");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['account_type'],
    
                "value" => $row['account_type']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

        // Read Regions

if(isset($_GET['region'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM regions ORDER BY region_id");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['region_name'],
    
                "value" => $row['region_code']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // UserName Checker

if(isset($_GET['checkUser'])){

    $data = array();
    $checkUsName = $_POST['usernames'];
    
    
    
    
        $stnt = $pdo->prepare("SELECT username FROM users  WHERE status = 'active' AND username = ? ");
        $stnt->execute([$checkUsName]);
        $count = $stnt->fetchColumn();
    
        if($count > 0){
            $result =  false;
        } else{
            
            $result = true;
        }
    
        echo json_encode($result);
    

    }



    // Count Merit

if(isset($_GET['merit'])){


    $data = array();
    $frstyr = $_POST["frstYearSelect"];
    $scndyr = $_POST["yearselect"];
    
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT COUNT(*) AS meritcount, program
        FROM scholarship_info 
        WHERE yr_awarded BETWEEN ? AND ?
        AND program = 'MERIT'
        GROUP BY program");
        $stnt->execute([$frstyr,$scndyr]);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["meritcount" => 0]);
    
    $stnt = null;
    $pdo = null;
    
    }


     // Count RA 10612


if(isset($_GET['ra10612'])){


    $data = array();
    $frstyr = $_POST["frstYearSelect"];
    $scndyr = $_POST["yearselect"];
    
    
    try
    {
    
     $stnt = $pdo->prepare("SELECT COUNT(*) AS ra10612count, program
     FROM scholarship_info
     WHERE yr_awarded BETWEEN ? AND ?
     AND program = 'RA 10612'
     GROUP BY program");
    $stnt->execute([$frstyr,$scndyr]);

    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }


        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra10612count" => 0]);
    
    
    
    $stnt = null;
    $pdo = null;
    
    }


     // RA 7687


if(isset($_GET['ra7687'])){


    $data = array();
    $frstyr = $_POST["frstYearSelect"];
    $scndyr = $_POST["yearselect"];
    
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT COUNT(*) AS ra7687count, program
        FROM scholarship_info
        WHERE yr_awarded BETWEEN ? AND ?
        AND program = 'RA 7687'
        GROUP BY program");
        $stnt->execute([$frstyr,$scndyr]);

    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra7687count" => 0]);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read Scholars 

if(isset($_GET['readscholar'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT spas_id, full_name, sex, dob, pob FROM scholars_record ORDER BY spas_id DESC");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Scholars personal details

if(isset($_GET['readScholarID'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT sr.spas_id, sr.user_id, sr.first_name, sr.middle_name, sr.last_name, sr.suffix_name,
sr.full_name, sr.sex, sr.dob, sr.pob, sr.tribe, sr.street as srstreet,
sr.street as srstreet, sr.village as srvillage, sr.barangay as srbarangay,
sr.municipality as srmunicipality, sr.province as srprovince,
sr.region as srregion, sr.district as srdistrict, sr.zipcode as srzipcode,
sr.email, sr.contact_no, sr.school_region, sr.school_code, ca.street as castreet,
ca.village as cavillage, ca.barangay as cabarangay, ca.municipality as camunicipality,
ca.province as caprovince, ca.region as caregion, ca.district as cadistrict,
ca.zipcode as cazipcode

FROM scholars_record as sr

LEFT OUTER JOIN curr_add as ca ON sr.spas_id = ca.spas_id
WHERE sr.spas_id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Scholars Info

if(isset($_GET['readScholarInfoID'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT s.scholar_id, s.yr_awarded, s.program, s.sub_program, s.category, c.duration, s.remarks,
        r.reply_slip, c.contract_status, s.sy_insured, s.batch_insured, c.deferment_status
        FROM scholarship_info AS s
        LEFT OUTER JOIN contract_status_details AS c ON s.scholar_id = c.scholar_id
        LEFT OUTER JOIN reply_slip_details AS r ON s.scholar_id = r.scholar_id

        WHERE s.primary_spas_id = ? ORDER BY s.scholar_id DESC");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Contract Info

if(isset($_GET['readSCID'])){
    $data = array();
    $scholarid = $_POST["scholarid"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT c.scholar_id, c.contract_status, c.avail_award, c.other_schp,
c.contract_loc, c.duration, c.etg_month, c.etg, c.deferment_status, c.reason, c.verified_flag as v_flag,
s.name as schools, p.name as course, t.sy, t.term_type, t.term,
c.created_by, c.updated_by, c.verified_by, d.with_deferment_form,
d.reason as defer_reason, d.sy_deferred, d.term_type as defer_type, d.term_deferred, d.verified_flag

FROM contract_status_details AS c


LEFT OUTER JOIN course_record AS r ON c.course_id = r.id
LEFT OUTER JOIN colleges AS s ON r.school_code = s.id::text
LEFT OUTER JOIN courses AS p ON r.course_code = p.id::text
LEFT OUTER JOIN term_record AS t ON c.term_id = t.term_id
LEFT OUTER JOIN deferment_details AS d ON c.spas_id = d.spas_id


WHERE c.scholar_id = ?");
        $params = array($scholarid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read Reply Slip

if(isset($_GET['readReplyId'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM reply_slip_details WHERE scholar_id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read UnderGrad Info

if(isset($_GET['readUndergradID'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT t.spas_id, c.name as course, c.discipline, s.name as schools, t.sy, t.term, t.course_id, t.term_type, t.latest_flag

FROM term_record as t

LEFT OUTER JOIN course_record as cr ON t.course_id = cr.id
LEFT OUTER JOIN courses AS c ON cr.course_code = c.id::text
LEFT OUTER JOIN colleges AS s ON cr.school_code = s.id::text 


WHERE t.spas_id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Status Record

if(isset($_GET['statRecID'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT 
        s.spas_id, 
        s.program, 
        s.sub_program, 
        s.category, 
        MAX(c.contract_status) AS contract_status, 
        MAX(p.progress_status) AS progress_status, 
        MAX(h.standing) AS standing
    FROM 
        scholarship_info AS s
    LEFT OUTER JOIN 
        contract_status_details AS c ON s.spas_id = c.spas_id
    LEFT OUTER JOIN 
        progress_status_history AS p ON s.spas_id = p.spas_id
    LEFT OUTER JOIN 
        standing_history AS h ON s.spas_id = h.spas_id
    WHERE 
        s.primary_spas_id = ?
    GROUP BY 
        s.spas_id, s.program, s.sub_program, s.category
    ORDER BY 
        s.spas_id ASC;
    
        ");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read View History Record

if(isset($_GET['historyRecID'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT t.term_id,
    t.sy, 
    se.name,
    CONCAT(s.name, ', ', c.name) AS schoolcourse, 
    p1.progress_status AS pstart,
    p1.active_flag AS actflag1,
    p1.verified_flag AS verify1,
    p2.progress_status AS pend,
    p2.active_flag AS actflag2,
    p2.verified_flag AS verify2,
    s1.standing AS sstanding,
    s1.active_flag AS actflag3,
    s1.verified_flag AS verify3,
    s2.standing AS send,
    s2.active_flag AS actflag4,
    s2.verified_flag AS verify4

FROM 
    term_record t
LEFT JOIN 
    course_record cr ON t.course_id = cr.id
LEFT JOIN 
    courses c ON cr.course_code = c.id::text
LEFT JOIN 
    colleges s ON cr.school_code = s.id::text
LEFT JOIN 
    progress_status_history p1 ON t.progress_status_start = p1.id
LEFT JOIN 
    progress_status_history p2 ON t.progress_status_end = p2.id
LEFT JOIN 
    standing_history s1 ON t.standing_start = s1.id
LEFT JOIN 
    standing_history s2 ON t.standing_end = s2.id
LEFT JOIN 
	semestral as se ON t.term = se.id
WHERE 
    t.spas_id = ?

ORDER BY 
    cr.id ASC, 
    t.term_id ASC;

    
        ");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

    // Read View Course

if(isset($_GET['viewCourseID'])){
    $data = array();
    $termid = $_POST["termid"];
  
    try
    {
    
        $stnt = $pdo->prepare("SELECT t.spas_id, t.term_id, t.sy, t.term, s.name as school, c.name as course, r.created_by,
r.updated_by, r.verified_by, r.verified_flag, r.created_at, r.updated_at


FROM term_record as t

LEFT OUTER JOIN course_record as r ON t.course_id = r.id
LEFT OUTER JOIN colleges as s ON s.id::text = r.school_code
LEFT OUTER JOIN courses as c ON c.id::text = r.course_code


WHERE t.term_id = ?
    
        ");
        $params = array($termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read View Start Status

if(isset($_GET['viewStartStatID'])){
    $data = array();
    $id = $_POST["id"];

    $termid = $_POST["termid"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT id, term_id, sy, term, start_end, progress_status,
created_by, updated_by, verified_by, latest_flag, verified_flag,
to_char(created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at


FROM progress_status_history 



WHERE spas_id = ?
AND start_end = 1
AND term_id = ?

    
        ");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read View Start  Progress Status

if(isset($_GET['viewProgressStat1'])){
    $data = array();
    $id = $_POST["spasid"];
    $termid = $_POST["id"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT progress_status FROM progress_status_history 

                WHERE spas_id = ?
                AND start_end = 1
                AND active_flag = true
                AND term_id = ?

        ");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



     // Read View Start  Progress Status End

if(isset($_GET['viewProgressStat2'])){
    $data = array();
    $id = $_POST["spasid"];
    $termid = $_POST["id"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT progress_status FROM progress_status_history 

                WHERE start_end = 2
                AND spas_id = ?
                AND active_flag = true
                AND term_id = ?

        ");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }




    // Read View Start Term Standing

if(isset($_GET['viewStartStat1'])){
    $data = array();
    $id = $_POST["spasid"];
    $termid = $_POST["id"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT standing FROM standing_history

                WHERE spas_id = ?
                AND start_end = 1
                AND active_flag = true
                AND term_id = ?

        ");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read View End Term Standing

if(isset($_GET['viewStartStat2'])){
    $data = array();
    $id = $_POST["spasid"];
    $termid = $_POST["id"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT standing FROM standing_history

                WHERE spas_id = ?
                AND start_end = 2
                AND active_flag = true
                AND term_id = ?

        ");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read View End Status

if(isset($_GET['viewEndID'])){
    $data = array();
    $id = $_POST["id"];

    $termid = $_POST["termid"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT term_id, sy, term, start_end, progress_status,
created_by, updated_by, verified_by, latest_flag, verified_flag,
to_char(created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at

FROM progress_status_history as p


WHERE spas_id = ?
AND start_end = 2
AND term_id = ?
        ");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read View Start of Term Standing

if(isset($_GET['viewSTRTStandID'])){
    $data = array();
    $id = $_POST["id"];
    $termid = $_POST["termid"];
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT id, term_id, sy, term, start_end,
standing, created_by, updated_by, verified_flag, verified_by, latest_flag,
to_char(created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at

FROM standing_history 


WHERE spas_id = ?
AND term_id = ?
AND start_end = 1
");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read View Start of Term Standing

if(isset($_GET['viewENDStandID'])){
    $data = array();
    $id = $_POST["id"];
    $termid = $_POST["termid"];
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT term_id, sy, term, start_end,
standing, created_by, updated_by, verified_flag,
verified_by, latest_flag,
to_char(created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at

FROM standing_history

WHERE spas_id = ?
AND start_end = 2
AND term_id = ?

    
        ");
        $params = array($id,$termid);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

    // Read Scholars Highschool

if(isset($_GET['readHS'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM hs_record WHERE spas_id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Family Informations

if(isset($_GET['readFamilyInfo'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM family_info WHERE spas_id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Graduate Obligation Tracking Information

if(isset($_GET['readGRObTrackInfo'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM graduate_obligation_tracking WHERE spas_id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

    // Read Year for Statistics

if(isset($_GET['years'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT yr_awarded
        FROM scholarship_info
        WHERE yr_awarded IS NOT NULL AND yr_awarded !=0
        GROUP BY yr_awarded
        ORDER BY yr_awarded");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['yr_awarded'],
    
                "value" => $row['yr_awarded']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

    // Line Data Query



if(isset($_GET['LineDataScholar'])){
    $data = array();
    $frstyr = $_POST["frstYearSelect"];
    $scndyr = $_POST["yearselect"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT 
        yr_awarded, 
     COUNT(*) as scholar 
 FROM scholarship_info 
 WHERE yr_awarded BETWEEN ? AND ?
 GROUP BY 
     yr_awarded
 ORDER BY 
     yr_awarded");
        $stnt->execute([$frstyr,$scndyr]);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = [
                "year"=> $row['yr_awarded'],
                "scholar"=> intval($row['scholar']),
        ];
    
    }
    $year = array();
    $scholar = array();
    foreach ($data as $key => $value) {
        array_push($year,$value['year']);
         array_push($scholar,intval($value['scholar']));
    }
    
    $final = array(
            "year" => $year,
            "scholar" => $scholar
    );
    
    echo json_encode($final);
    
    $stnt = null;
    $pdo = null;
    
    }

    // Merit Count Good Standing

    if(isset($_GET['meritCountStanding'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS merit_g_standing
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'MERIT' 
              AND h.standing = 'GOOD STANDING'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["merit_g_standing" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // Merit Count Good LOA

    if(isset($_GET['meritCountLoa'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS merit_loa
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'MERIT' 
              AND h.standing = 'LOA'
              AND h.latest_flag = 'TRUE'
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["merit_loa" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }

        // Merit Count No Report

    if(isset($_GET['meritCountNReport'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS merit_nreport
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'MERIT' 
              AND h.standing = 'NO REPORT'
			  AND h.latest_flag = 'TRUE'
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["merit_nreport" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }

        // Merit Count Extension

    if(isset($_GET['meritCountOExtension'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS merit_extension
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'MERIT' 
              AND h.standing = 'ON EXTENSION'
			  AND h.latest_flag = 'TRUE'
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["merit_extension" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // Merit Suspended

    if(isset($_GET['meritCountSuspended'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS merit_suspended
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'MERIT' 
              AND h.standing = 'SUSPENDED'
			  AND h.latest_flag = 'TRUE'
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["merit_suspended" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 10612 Good Standing

    if(isset($_GET['ra1CountGStanding'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra1_g_standing
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 10612' 
              AND h.standing = 'GOOD STANDING'
			  AND h.latest_flag = 'TRUE'
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra1_g_standing" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }

        // RA 10612 LOA

    if(isset($_GET['ra1CountLOA'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra1_loa
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 10612' 
              AND h.standing = 'LOA'
			  AND h.latest_flag = 'TRUE'
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        

        // Use this code if the return is no value

        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra1_loa" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 10612 No Report

    if(isset($_GET['ra1CountNreport'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra1_nreport
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 10612' 
              AND h.standing = 'NO REPORT'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra1_nreport" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }

        // RA 10612 On Extension

    if(isset($_GET['ra1CountExtension'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra1_extension
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 10612' 
              AND h.standing = 'ON EXTENSION'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra1_extension" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 10612 Suspended

    if(isset($_GET['ra1CountSuspended'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra1_suspended
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 10612' 
              AND h.standing = 'SUSPENDED'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra1_suspended" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 7687 Good Standing

    if(isset($_GET['ra7CountGStanding'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra7_g_standing
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 7687' 
              AND h.standing = 'GOOD STANDING'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra7_g_standing" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 7687 LOA

    if(isset($_GET['ra7CountLoa'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra7_loa
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 7687' 
              AND h.standing = 'LOA'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra7_loa" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 7687 No Report

    if(isset($_GET['ra7CountNreport'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra7_nreport
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 7687' 
              AND h.standing = 'NO REPORT'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra7_nreport" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 7687 On Extension

    if(isset($_GET['ra7CountExtension'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra7_extension
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 7687' 
              AND h.standing = 'ON EXTENSION'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra7_extension" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // RA 7687 Suspended

    if(isset($_GET['ra7CountSuspended'])){


        $data = array();
        $frstyr = $_POST["frstYearSelect"];
        $scndyr = $_POST["yearselect"];
        
        
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.program, h.standing, COUNT(*) AS ra7_suspended
            FROM standing_history AS h
            LEFT OUTER JOIN scholarship_info AS s ON s.spas_id = h.spas_id
            WHERE s.program = 'RA 7687' 
              AND h.standing = 'SUSPENDED'
              AND h.latest_flag = 'TRUE' 
              AND s.yr_awarded BETWEEN ? AND ?
            GROUP BY s.program, h.standing");
            $stnt->execute([$frstyr,$scndyr]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        if(count($data) > 0)
        echo json_encode($data);
        else
        echo json_encode(["ra7_suspended" => 0]);
        
        $stnt = null;
        $pdo = null;
        
        }


        // Read Scholars Eligible for Financial Assistance

// if(isset($_GET['readEligible'])){
//     $data = array();

//     $school = $_POST["school"];
//     $region = $_POST["region"];
    
//     try
//     {
    
//         $stnt = $pdo->prepare("WITH ValidCourseRecords AS (
//     SELECT *
//     FROM course_record
//     WHERE school_code ~ '^[0-9]+$'
// )
// SELECT sr.full_name, si.spas_id, si.yr_awarded, sh.standing, sh.sy, sh.term, sh.term_type,
//        sh.term_id, c.name AS course, s.name AS school, s.region AS region
// FROM scholars_record as sr
// INNER JOIN scholarship_info AS si ON sr.spas_id = si.primary_spas_id
// INNER JOIN standing_history AS sh ON si.spas_id = sh.spas_id
// LEFT JOIN ValidCourseRecords AS cr ON sr.spas_id = cr.spas_id
// LEFT JOIN courses AS c ON cr.course_code = CAST(c.id AS VARCHAR)
// LEFT JOIN colleges AS s ON CAST(cr.school_code AS INTEGER) = s.id
// WHERE sh.latest_flag = 'TRUE'
//   AND sh.start_end = 1
//   AND (
//         (sh.standing = 'GOOD STANDING')
//         OR
//         (sh.standing = 'SUSPENDED')
//       )
//   AND s.name = ?
//   AND s.region = ?
// ORDER BY sr.full_name;
//         ");
//         $params = array($school,$region);
//         $stnt->execute($params);
    

    
//     }catch (Exception $ex){
//         die("Failed to run query". $ex);
    
//     }
    
//     http_response_code(200);
    
//     while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
//         $data[] = $row;
//     }
    
//     echo json_encode($data);
    
//     $stnt = null;
//     $pdo = null;
    
//     }

if (isset($_GET['readEligible'])) {
    $data = array();

    $school = $_POST["school"];
    $region = $_POST["region"];
    
    try {
        // Base query
        $query = "WITH ValidCourseRecords AS (
            SELECT *
            FROM course_record
            WHERE school_code ~ '^[0-9]+$'
        )
        SELECT sr.full_name, si.spas_id, si.yr_awarded, sh.standing, sh.sy, sh.term, sh.term_type,
               sh.term_id, c.name AS course, s.name AS school, s.region AS region
        FROM scholars_record as sr
        INNER JOIN scholarship_info AS si ON sr.spas_id = si.primary_spas_id
        INNER JOIN standing_history AS sh ON si.spas_id = sh.spas_id
        LEFT JOIN ValidCourseRecords AS cr ON sr.spas_id = cr.spas_id
        LEFT JOIN courses AS c ON cr.course_code = CAST(c.id AS VARCHAR)
        LEFT JOIN colleges AS s ON CAST(cr.school_code AS INTEGER) = s.id
        WHERE sh.latest_flag = 'TRUE'
          AND sh.start_end = 1
          AND (
                (sh.standing = 'GOOD STANDING')
                OR
                (sh.standing = 'SUSPENDED')
              )
        ";

        // Modify query based on conditions
        $params = array();

        $params = array();
        if ($school !== 'All') {
            $query .= " AND s.name = ?";
            $params[] = $school;
        }
        if ($region !== 'All') {
            $query .= " AND s.region = ?";
            $params[] = $region;
        }

        // Add ORDER BY clause
        $query .= " ORDER BY sr.full_name";

        // Prepare and execute query
        $stnt = $pdo->prepare($query);
        $stnt->execute($params);
        
    } catch (Exception $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
}


      
// Export CSV

if (isset($_GET['exportCSV'])) {
    $data = array();

    $school = $_POST["school"];
    $region = $_POST["region"];
    
    try {
        $query = "
            SELECT
                scholars_record.spas_id, 
                scholars_record.full_name,
                scholarship_info.program,
                scholarship_info.sub_program,
                colleges.name AS school,
                colleges.region,
                courses.name AS course,
                courses.discipline,
                progress_status_history.progress_status,
                standing_history.standing, 
                standing_history.sy,
                CASE
                    WHEN standing_history.term = 1 THEN '1st Term'
                    WHEN standing_history.term = 2 THEN '2nd Term'
                    WHEN standing_history.term = 3 THEN 'Summer'
                    ELSE 'Mid Year'
                END AS Term,
                CASE
                    WHEN standing_history.start_end = 1 THEN 'Start'
                    ELSE 'End'
                END AS Start_End,
                standing_history.updated_at
            FROM
                scholars_record
            JOIN
                scholarship_info ON scholars_record.spas_id = scholarship_info.primary_spas_id
            JOIN
                standing_history ON (
                    (standing_history.spas_id = scholarship_info.spas_id 
                     AND standing_history.standing = 'GOOD STANDING' 
                     AND standing_history.latest_flag = 'TRUE' 
                     AND standing_history.start_end = 1)
                    OR
                    (standing_history.spas_id = scholarship_info.spas_id 
                     AND standing_history.standing = 'SUSPENDED' 
                     AND standing_history.latest_flag = 'TRUE' 
                     AND standing_history.start_end = 1)
                )
            JOIN
                progress_status_history ON 
                    standing_history.term_id = progress_status_history.term_id 
                    AND standing_history.start_end = progress_status_history.start_end
            LEFT JOIN
                course_record ON 
                    course_record.spas_id = scholarship_info.spas_id 
                    AND course_record.latest_flag = 1
            LEFT JOIN
                courses ON 
                    course_record.course_code = CAST(courses.id AS VARCHAR)
            LEFT JOIN
                colleges ON 
                    course_record.school_code ~ '^[0-9]+$' 
                    AND CAST(course_record.school_code AS INTEGER) = colleges.id
        ";

        // Modify the WHERE clause based on the values of $school and $region
        if ($school !== 'All' && $region !== 'All') {
            $query .= " WHERE colleges.name = ? AND colleges.region = ?";
            $params = array($school, $region);
        } elseif ($school !== 'All') {
            $query .= " WHERE colleges.school = ?";
            $params = array($school);
        } elseif ($region !== 'All') {
            $query .= " WHERE colleges.region = ?";
            $params = array($region);
        } else {
            // If both are 'All', no additional WHERE clause is needed
            $params = array();
        }

        $query .= " ORDER BY scholars_record.full_name;";
        
        $stnt = $pdo->prepare($query);
        $stnt->execute($params);
        
    } catch (Exception $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
}



        // Read Scholars Records on Dashboard

if(isset($_GET['readScholarRec'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT s.spas_id, s.user_id, s.first_name, s.middle_name, s.last_name,
		s.suffix_name, s.full_name, s.sex, s.dob, s.pob, s.tribe,
		s.street, s.village, s.barangay, s.municipality, s.province,
		s.region, s.district, s.zipcode, s.diff_curr_add, s.email,
		s.contact_no, s.school_region, s.school_code, s.zip_id, u.id, u.username,
		u.internal_id, u.account_type, u.region as uregion, u.school_code as uschoolcode,
        u.status, a.street as astreet, a.village as avillage, a.barangay as abarangay,
        a.municipality as amunicipality, a.province as aprovince, a.region as aregion,
        a.district as adistrict, a.zipcode as azipcode
        FROM scholars_record as s
        LEFT OUTER JOIN users AS u ON s.user_id = u.id
        LEFT OUTER JOIN curr_add AS a ON s.spas_id = a.spas_id
        WHERE u.status = 'active' 
        ORDER BY 
        id DESC;
    ");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Stat2

if(isset($_GET['readstat2'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM lu_monitoring_status ORDER BY code");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['code'],
    
                "value" => $row['code']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Stat1

if(isset($_GET['readstat1'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM lu_progress_status ORDER BY name");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['name'],
    
                "value" => $row['name']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



     // Read EditGrades

if(isset($_GET['readEditGrades'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT 
    t.sy, 
    se.name as sem,
    s.name as school,
	 c.name as course,
	 t.term_required,
	 t.reg_verified_by,
	 t.grades_verified_by,
    p1.progress_status AS pstart,
    s1.standing AS sstanding,
	t.latest_flag,
    t.grades_verified_flag,
    cr.id
    

FROM 
    term_record as t
LEFT JOIN 
    course_record cr ON t.course_id = cr.id
LEFT JOIN 
    courses c ON cr.course_code = c.id::text
LEFT JOIN 
    colleges s ON cr.school_code = s.id::text
LEFT JOIN 
    progress_status_history p1 ON t.progress_status_start = p1.id
LEFT JOIN 
    progress_status_history p2 ON t.progress_status_end = p2.id
LEFT JOIN 
    standing_history s1 ON t.standing_start = s1.id
LEFT JOIN 
    standing_history s2 ON t.standing_end = s2.id
LEFT JOIN 
	semestral as se ON t.term = se.id
LEFT JOIN
    grades as g ON t.term_id = g.term_id
WHERE 
    t.term_id = ?
");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Staff Records

    if(isset($_GET['readUserMail'])){
        $data = array();
        $id = $_POST["idMail"];
        try
        {
        
            $stnt = $pdo->prepare("SELECT email FROM staff_record WHERE user_id  = ?");
            $params = array($id);
            $stnt->execute($params);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
            $data = $row;
        }
        
        echo json_encode($data);
        
        $stnt = null;
        $pdo = null;
        
        }




        // Read Address

if(isset($_GET['address'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM esch_shared.zipi ORDER BY zpro");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['zzip'] . " - " . $row['zbar'] . " - " . $row['zmun'] . " - " . $row['zpro'] . " - " . $row["zreg"],
    
                "value" => $row['zzid']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read Address Id

if(isset($_GET['addressid'])){

    $data = array();
    $addressids = $_POST["province"];
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT e.zzid, e.zreg, e.zpro, e.zmun, e.zbar, e.zzip, e.zdis, e.zpov, CASE WHEN e.zreg = 'NCR' THEN '16' ELSE e.zreg end as new_region FROM esch_shared.zipi e WHERE zzid = ?");
        $stnt->execute([$addressids]);
    
    
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // SPAS ID Checker

if(isset($_GET['checkSpas'])){

    $data = array();
    $checkSpas = $_POST['checkSpasid'];
    $spasid_no_spaces = str_replace(' ', '', $checkSpas);
    
    
    
    
        $stnt = $pdo->prepare("SELECT spas_id FROM scholars_record  WHERE spas_id = ?");
        $stnt->execute([$spasid_no_spaces]);
        $count = $stnt->fetchColumn();
    
        if($count > 0){
            $result =  false;
        } else{
            
            $result = true;
        }
    
        echo json_encode($result);
    

    }

    // SPAS ID Checker

if(isset($_GET['newcheckSpas'])){

    $data = array();
    $checkSpas = $_POST['checkSpasid'];
    $spasid_no_spaces = str_replace(' ', '', $checkSpas);
    
    
    
    
        $stnt = $pdo->prepare("SELECT spas_id FROM scholarship_info  WHERE spas_id = ?");
        $stnt->execute([$spasid_no_spaces]);
        $count = $stnt->fetchColumn();
    
        if($count > 0){
            $result =  false;
        } else{
            
            $result = true;
        }
    
        echo json_encode($result);
    

    }


    // Email Checker

if(isset($_GET['checkMail'])){

    $data = array();
    $checkmail = $_POST['mail'];
   
    
        $stnt = $pdo->prepare("SELECT email FROM scholars_record  WHERE email = ?");
        $stnt->execute([$checkmail]);
        $count = $stnt->fetchColumn();
    
        if($count > 0){
            $result =  false;
        } else{
            
            $result = true;
        }
    
        echo json_encode($result);
    

    }


    // Contact Checker

// if(isset($_GET['checkContact'])){

//     $data = array();
//     $checkcontacts = $_POST['contact'];
   
    
//         $stnt = $pdo->prepare("SELECT contact_no FROM scholars_record WHERE contact_no = ? ");
//         $stnt->execute([$checkcontacts]);
//         $count = $stnt->fetchColumn();
    
//         if($count > 0){
//             $result =  false;
//         } else{
            
//             $result = true;
//         }
    
//         echo json_encode($result);
    

//     }



// Read Replies

if(isset($_GET['reply'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM lu_reply_status ORDER BY id");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['name'],
    
                "value" => $row['name']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

    // Read Contract Status

    if(isset($_GET['contractStatus'])){
        $data = array();
        try
        {
        
            $stnt = $pdo->prepare("SELECT * FROM lu_contract_status ORDER BY id");
            $stnt->execute();
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['name'],
        
                    "value" => $row['name']
        
                );
        }
        
        echo json_encode($data);
        
        $stnt = null;
        $pdo = null;
        
        }

        // Read RTG Month

    if(isset($_GET['etgMonth'])){
        $data = array();
        try
        {
        
            $stnt = $pdo->prepare("SELECT * FROM lu_months ORDER BY id");
            $stnt->execute();
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['name'],
        
                    "value" => $row['id']
        
                );
        }
        
        echo json_encode($data);
        
        $stnt = null;
        $pdo = null;
        
        }


        // SPASID LISTS

    if(isset($_GET['spasid'])){
        $data = array();
        $pspasid = $_POST['id'];
        try
        {
        
            $stnt = $pdo->prepare("SELECT primary_spas_id 
                FROM scholarship_info 
                WHERE primary_spas_id = ?
                GROUP BY primary_spas_id
");
            $stnt->execute([$pspasid]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['primary_spas_id'],
        
                    "value" => $row['primary_spas_id']
        
                );
        }
        
        echo json_encode($data);
        
        $stnt = null;
        $pdo = null;
        
        }


        // Read School

if(isset($_GET['school'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT name, id FROM colleges ORDER BY id");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['name'],
    
                "value" => $row['id']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // Read Course

if(isset($_GET['courses'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT name, id FROM courses ORDER BY id");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['name'],
    
                "value" => $row['id']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

    // Read Term Record

    if(isset($_GET['termRec'])){
        $data = array();
        try
        {
        
            $stnt = $pdo->prepare("SELECT * FROM lu_months ORDER BY id");
            $stnt->execute();
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['name'],
        
                    "value" => $row['name']
        
                );
        }
        
        echo json_encode($data);
        
        $stnt = null;
        $pdo = null;
        
        }


        // Read Term Record

if (isset($_GET['readTermRec'])) {
    $data = array();
    $spasid = $_POST['id'];
    try {
        $stnt = $pdo->prepare("SELECT s.primary_spas_id, s.spas_id, t.term_id, t.sy, sm.name	

FROM scholarship_info as s

LEFT OUTER JOIN term_record as t ON s.primary_spas_id = t.spas_id
LEFT JOIN semestral as sm ON t.term = sm.id

WHERE primary_spas_id = ?
ORDER BY t.sy");
        $stnt->execute([$spasid]);
    } catch (Exception $ex) {
        die("Failed to run query" . $ex);
    }

    http_response_code(200);

    while ($row = $stnt->fetch()) {
        $data[] = array(
            "label" => $row['sy'] . " " . $row['name'],
            "value" => $row['term_id'] // Concatenate sy and name as value
        );
    }

    echo json_encode($data);

    $stnt = null;
    $pdo = null;
}


// Read Enrollment Term Record

if (isset($_GET['readEnrollmentTermRec'])) {
    $data = array();
    $spasid = $_POST['id'];
    try {
        $stnt = $pdo->prepare("SELECT s.primary_spas_id, s.spas_id, t.term_id, t.sy, sm.name	

FROM scholarship_info as s

LEFT OUTER JOIN term_record as t ON s.primary_spas_id = t.spas_id
LEFT JOIN semestral as sm ON t.term = sm.id

WHERE primary_spas_id = ?
ORDER BY t.sy");
        $stnt->execute([$spasid]);
    } catch (Exception $ex) {
        die("Failed to run query" . $ex);
    }

    http_response_code(200);

    while ($row = $stnt->fetch()) {
        $data[] = array(
            "label" => $row['sy'] . " " . $row['name'],
            "value" => $row['term_id'], $row['term_id'] // Concatenate sy and name as value
        );
    }

    echo json_encode($data);

    $stnt = null;
    $pdo = null;
}





        // Read Term Record

    if(isset($_GET['readAddSC'])){
        $data = array();
        $spasid = $_POST['id'];
        try
        {
        
            $stnt = $pdo->prepare("SELECT CONCAT(s.name, ', ', c.name) AS schoolcourse, t.sy, se.name, cr.id


FROM course_record as cr

LEFT OUTER JOIN term_record as t ON cr.term_id = t.term_id

LEFT OUTER JOIN courses AS c ON cr.course_code = c.id::text

LEFT OUTER JOIN colleges AS s ON cr.school_code = s.id::text


LEFT OUTER JOIN semestral as se ON t.term = se.id

WHERE
 cr.spas_id = ?");
            $stnt->execute([$spasid]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['schoolcourse'] . " ( Start ". $row['sy']. " ". $row['name']. " )",
        
                    "value" => $row['id']
        
                );
        }
        
        echo json_encode($data);
        
        $stnt = null;
        $pdo = null;
        
        }



        // Select School Year

if(isset($_GET['school_years'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT yr_awarded,
       yr_awarded + 1 AS next_year,
       CONCAT(yr_awarded, '-', yr_awarded + 1) AS school_year
FROM scholarship_info
WHERE yr_awarded IS NOT NULL AND yr_awarded != 0
GROUP BY yr_awarded
ORDER BY yr_awarded;
");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['school_year'],
    
                "value" => $row['school_year']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Select Specific School Year

if(isset($_GET['specificSchoolYrs'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT sy FROM term_record WHERE spas_id = ? GROUP BY sy ORDER BY sy");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['sy'],
    
                "value" => $row['sy']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


    // School Year Checker

if(isset($_GET['checkSy'])){

    $data = array();
    $syinput = $_POST['syinput'];
    $id = $_POST['id'];
    
    
    
    
        $stnt = $pdo->prepare("SELECT sy FROM financial_release  WHERE spas_id = ? AND sy = ? ");
        $stnt->execute([$id,$syinput]);
        $count = $stnt->fetchColumn();
    
        if($count > 0){
            $result =  false;
        } else{
            
            $result = true;
        }
    
        echo json_encode($result);
    

    }































    // Select Standing

if(isset($_GET['standing'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT name FROM lu_standing ORDER BY id");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch()){
        $data[] = array(
    
                "label" => $row['name'],
    
                "value" => $row['name']
    
            );
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }








    // Read Exam Info

if(isset($_GET['readExamInfo'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM exam_info WHERE spas_id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read For Appeal 

if(isset($_GET['readForAppeal'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT p.spas_id, s.full_name, s.sex, s.dob, s.pob

FROM progress_status_history as p

LEFT OUTER JOIN scholars_record as s ON p.spas_id = s.spas_id

WHERE p.progress_status = 'FOR APPEAL'");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }




    // Read Unvalidated Status List

if(isset($_GET['readUnvalidated'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT scholars_record.full_name, scholarship_info.spas_id, scholarship_info.yr_awarded, u.*
FROM (
    SELECT s2.spas_id, s2.term_id, s2.sy, s2.term, s2.term_type, s2.start_end, progress_status, standing 
    FROM (
        SELECT * FROM progress_status_history
        WHERE verified_flag = false
    ) p2
    RIGHT JOIN (
        SELECT * FROM standing_history
        WHERE verified_flag = false
    ) s2
    ON p2.term_id = s2.term_id AND p2.start_end = s2.start_end

    UNION

    SELECT p.spas_id, p.term_id, p.sy, p.term, p.term_type, p.start_end, progress_status, standing 
    FROM (
        SELECT * FROM progress_status_history
        WHERE verified_flag = false
    ) p
    LEFT JOIN (
        SELECT * FROM standing_history
        WHERE verified_flag = false
    ) s
    ON p.term_id = s.term_id AND p.start_end = s.start_end
) u
JOIN scholarship_info ON scholarship_info.spas_id = u.spas_id
JOIN scholars_record ON scholarship_info.primary_spas_id = scholars_record.spas_id
ORDER BY yr_awarded ASC, full_name ASC;
");
        $stnt->execute();
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }

// Nested Loop reading term ID's


    if(isset($_GET['readTermIds'])){



        $data = array();
        $id = $_POST["id"];
        try
        {
        
            $stnt = $pdo->prepare("SELECT s.primary_spas_id, s.spas_id, t.spas_id, t.term_id, g.term_id
FROM scholarship_info as s
LEFT OUTER JOIN term_record as t ON s.spas_id = t.spas_id
LEFT OUTER JOIN grades as g ON t.term_id = g.term_id
WHERE s.primary_spas_id = ?
GROUP BY t.term_id, s.spas_id, t.spas_id, s.primary_spas_id, g.term_id
HAVING g.term_id IS NOT NULL
ORDER BY t.term_id;


                        ");
            $params = array($id);
            $stnt -> execute($params);
        


        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        // http_response_code(200);
        while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){          
          $termId[] = $row;
        }
   
        $final = [];
        foreach ($termId as $key => $value) {


            $stntss = $pdo->prepare("SELECT DISTINCT t.spas_id, t.term_id, t.sy, t.term, t.term_required,
                t.course_id, t.grade_ave, t.reg_form_submitted,t.reg_verified_flag, t.grades_verified_flag,
                pstart.progress_status as progress_status_start, sstart.standing as standing_start, pend.progress_status as progress_status_end,
				send.standing as standing_end,
                c.name as courses, s.name as school

                FROM term_record as t

                LEFT OUTER JOIN grades as g ON t.term_id = g.term_id
                LEFT OUTER JOIN course_record as cr ON t.course_id = cr.id
				LEFT OUTER JOIN progress_status_history as pstart ON t.progress_status_start = pstart.id
				LEFT OUTER JOIN progress_status_history as pend ON t.progress_status_end = pend.id
				LEFT OUTER JOIN standing_history as sstart ON t.standing_start = sstart.id
				LEFT OUTER JOIN standing_history as send ON t.standing_end = send.id

                LEFT JOIN 
                    courses c ON cr.course_code = c.id::text
                LEFT JOIN 
                    colleges s ON cr.school_code = s.id::text

                WHERE t.term_id = ? ");
            $params = array($value['term_id']);
            $stntss->execute($params);
           
         
            while ($rowss = $stntss->fetch(PDO::FETCH_ASSOC)){
                $distinct[] = $rowss;
            }
            foreach ($distinct as $key => $valuess) {
                $final[$value['term_id']] = $valuess;
            }
           
            $stnts = $pdo->prepare("SELECT t.spas_id, t.term_id, t.sy, t.term, t.term_required,
                t.course_id, t.grade_ave, t.reg_form_submitted,t.reg_verified_flag, t.grades_verified_flag, g.term_id as g_termid,
                g.subj_code, g.unit, g.grade, g.completion, g.remarks, c.name as courses, s.name as school

                FROM term_record as t

                LEFT OUTER JOIN grades as g ON t.term_id = g.term_id
                LEFT OUTER JOIN course_record as cr ON t.course_id = cr.id

                LEFT JOIN 
                    courses c ON cr.course_code = c.id::text
                LEFT JOIN 
                    colleges s ON cr.school_code = s.id::text

                WHERE t.term_id = ?
                
                
                
                ");
            $params = array($value['term_id']);
            $stnts->execute($params);
           
         
            while ($rows = $stnts->fetchAll(PDO::FETCH_ASSOC)){
                $readGradres[] = $rows;
            }
       
             foreach ($readGradres as $keys => $values) {
               $final[$value['term_id']]['term_id'] = $values;
             
             }
          
            
        }

    

      echo json_encode($final);
        
        $stnt = null;
        $pdo = null;
        
        }








        // Read Grades

if(isset($_GET['readGrades'])){

    $data = array();

    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM grades WHERE term_id = ? ORDER BY subj_id DESC");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }




        if (isset($_GET['checkMonitor'])) {
            $data = array();
            $id = $_POST["id"];
        
       
                $stnt = $pdo->prepare("SELECT s.primary_spas_id, s.spas_id, t.spas_id, t.term_id, g.term_id
FROM scholarship_info as s
LEFT OUTER JOIN term_record as t ON s.spas_id = t.spas_id
LEFT OUTER JOIN grades as g ON t.term_id = g.term_id
WHERE s.primary_spas_id = ?
GROUP BY t.term_id, s.spas_id, t.spas_id, s.primary_spas_id, g.term_id
HAVING g.term_id IS NOT NULL
ORDER BY t.term_id;

");
                $stnt->execute([$id]);
                $count = $stnt->fetchColumn();


                if($count > 0){
                    $result =  false;
                } else{
                    
                    $result = true;
                }
            
                echo json_encode($result);
        
          
        }





        // Read School Course in Add New Enroll

if(isset($_GET['readEnrollSC'])){
    $data = array();
    $id = $_POST["termid_course"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT t.sy,  se.name, cr.spas_id, s.name as school,c.name as course, cr.id, t.latest_flag

FROM 
    course_record as cr
	
	
LEFT JOIN term_record as t ON cr.term_id = t.term_id
	
LEFT JOIN 
    courses c ON cr.course_code = c.id::text
LEFT JOIN 
    colleges s ON cr.school_code = s.id::text
    
LEFT JOIN 
	semestral as se ON t.term = se.id
	
	
WHERE cr.term_id = ? ");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read School Course in Add New Enroll Info with new Term

if(isset($_GET['readEnrollwthTerm'])){
    $data = array();
    $id = $_POST["termids"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT t.latest_flag

FROM 
    term_record as t
	

	
WHERE t.term_id = ? ");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }


     // Read Allowances 

     if(isset($_GET['readAllowance'])){
        $data = array();
        try
        {
        
            $stnt = $pdo->prepare("SELECT * FROM lu_allowances ORDER BY id");
            $stnt->execute();
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['name'],
        
                    "value" => $row['id'],
                    "item" => $row['name']
                    // "id" => $row['id']
        
                );
        }
        
        echo json_encode($data);
        
        $stnt = null;
        $pdo = null;
        
        }


         // Read Address Id

if(isset($_GET['itemids'])){

    $data = array();
    $itemid = $_POST["itemid"];
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM lu_allowances WHERE id = ?");
        $stnt->execute([$itemid]);
    
    
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



// Financial Statement Checker




    if (isset($_GET['checkFinancial'])) {
        $data = array();


        $id = $_POST["id"];
    
   
            $stnt = $pdo->prepare("SELECT spas_id FROM financial_release WHERE spas_id = ?");
            $stnt->execute([$id]);
            $count = $stnt->fetchColumn();


            if($count > 0){
                $result =  true;
            } else{
                
                $result = false;
            }
        
            echo json_encode($result);
    
      
    }





    if (isset($_GET['readFinanceIds'])) {

        $financeId = [];  // Initialize array
        $final = [];      // Initialize array
        $id = $_POST["id"];
    
        try {
            // First query to get sy, total_amt, and financial_release_id
            $stnt = $pdo->prepare("SELECT fr.id, fs.financial_release_id, fr.sy, fr.total_amt, fr.spas_id, s.full_name, 
fs.term_id, c.name as course, u.name as schools, si.program
FROM financial_release AS fr

LEFT OUTER JOIN financial_statement AS fs ON fr.id = fs.financial_release_id
LEFT OUTER JOIN scholars_record AS s ON fr.spas_id = s.spas_id
LEFT OUTER JOIN course_record AS cr ON fs.term_id = cr.term_id
LEFT OUTER JOIN courses AS c ON cr.course_code = c.id::text
LEFT OUTER JOIN colleges AS u ON cr.school_code = u.id::text
LEFT OUTER JOIN scholarship_info AS si ON fr.spas_id = si.spas_id

                
WHERE fr.spas_id = ?
GROUP BY fr.id, fs.financial_release_id, fr.total_amt, fr.sy, fr.spas_id, 
s.full_name, fs.term_id,  cr.sy_start, c.name, u.name, si.program

ORDER BY id DESC");
            $params = array($id);
            $stnt->execute($params);
    
            while ($row = $stnt->fetch(PDO::FETCH_ASSOC)) {          
                // Populate financeId with each row
                $financeId[] = $row;
    
                // Initialize final array structure with sy and total_amt
                $final[$row['financial_release_id']] = [
                    'sy' => $row['sy'],
                    'total_amt' => $row['total_amt'],
                    'spas_id' => $row['spas_id'],
                    'full_name' => $row['full_name'],
                    'course' => $row['course'],
                    'schools' => $row['schools'],
                    'term_id' => $row['term_id'],
                    'program' => $row['program'],
                    'details' => []  // Placeholder for details to be populated later
                ];
            }
        } catch (Exception $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
    
        foreach ($financeId as $value) {
            $distinct = [];  // Reset $distinct array for each iteration
            
            // Second query to fetch distinct financial_release_id information
            $stnt2 = $pdo->prepare("SELECT DISTINCT fr.id, fs.financial_release_id 
                FROM financial_release AS fr 
                LEFT OUTER JOIN financial_statement AS fs ON fr.id = fs.financial_release_id
                WHERE fr.id = ?");
            $params = array($value['financial_release_id']);
            $stnt2->execute($params);
    
            while ($rows2 = $stnt2->fetch(PDO::FETCH_ASSOC)) {
                $distinct[] = $rows2;
            }
    
            foreach ($distinct as $value2) {
                $final[$value['financial_release_id']] = array_merge(
                    $final[$value['financial_release_id']], 
                    $value2
                );
            }
    
            $readFinance = [];  // Reset $readFinance array for each iteration
    
            // Third query to get detailed information for each financial_release_id
            $stnt3 = $pdo->prepare("SELECT 
    t.term, 
    t.sy, 
    al.name AS category, 
    CASE 
        WHEN fs.year = 0 THEN NULL 
        ELSE fs.year 
    END AS year,
    m.name AS month,
    fs.date_process, 
    fs.amount, 
    fs.date_deposit, 
    fs.remarks
FROM financial_statement AS fs
LEFT OUTER JOIN financial_release AS fr ON fs.financial_release_id = fr.id
LEFT OUTER JOIN term_record AS t ON fs.term_id = t.term_id
LEFT OUTER JOIN lu_allowances AS al ON fs.category = al.id
LEFT OUTER JOIN lu_months AS m ON fs.month = m.id
WHERE fr.id = ? 
  AND fs.active_flag = true;
");
            $params = array($value['financial_release_id']);
            $stnt3->execute($params);
    
            // Store detailed information in readFinance array
            $readFinance = $stnt3->fetchAll(PDO::FETCH_ASSOC);
    
            // Add the detailed information to the 'details' key in $final
            $final[$value['financial_release_id']]['details'] = $readFinance;
        }
    
        echo json_encode($final);  // Output final JSON result once
    
        // Close all PDO statements at the end
        $stnt = null;
        $stnt2 = null;
        $stnt3 = null;
        $pdo = null;
    }



    // Read Financials

if(isset($_GET['readFinancial'])){

    $data = array();

    $id = $_POST["finance_id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM financial_statement WHERE financial_release_id = ? 
AND active_flag = true
ORDER BY term_id DESC");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }



    // Read Financials

if(isset($_GET['readFinancialRelease'])){

    $data = array();

    $id = $_POST["finance_id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM financial_release WHERE id = ?");
        $params = array($id);
        $stnt->execute($params);
    
    }catch (Exception $ex){
        die("Failed to run query". $ex);
    
    }
    
    http_response_code(200);
    
    while ($row = $stnt->fetch(PDO::FETCH_ASSOC)){
        $data = $row;
    }
    
    echo json_encode($data);
    
    $stnt = null;
    $pdo = null;
    
    }
    
    
    
        
    
    

    





    






















// Developed By: CASTAÑARES, JONATHAN R.
?>