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
    
        $stnt = $pdo->prepare("SELECT s.spas_id, s.yr_awarded, s.program, s.sub_program, s.category, c.duration, s.remarks,
        r.reply_slip, c.contract_status, s.sy_insured, s.batch_insured, c.deferment_status
        FROM scholarship_info AS s
        LEFT OUTER JOIN contract_status_details AS c ON s.spas_id = c.spas_id
        LEFT OUTER JOIN reply_slip_details AS r ON s.spas_id = r.spas_id

        WHERE s.primary_spas_id = ?");
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
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT c.contract_status, c.avail_award, c.other_schp,
c.contract_loc, c.duration, c.etg_month, c.etg, c.deferment_status,
s.name as schools, p.name as course, t.sy, t.term_type, t.term, c.reason,
c.created_by, c.updated_by, c.verified_by, d.with_deferment_form,
d.reason as defer_reason, d.sy_deferred, d.term_type as defer_type, d.term_deferred
FROM contract_status_details AS c

LEFT OUTER JOIN course_record AS r ON c.spas_id = r.spas_id
LEFT OUTER JOIN colleges AS s ON r.school_code = s.id::text
LEFT OUTER JOIN courses AS p ON r.course_code = p.id::text
LEFT OUTER JOIN term_record AS t ON c.term_id = t.term_id
LEFT OUTER JOIN deferment_details AS d ON c.spas_id = d.spas_id
		
		
WHERE c.spas_id = ?");
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



    // Read Reply Slip

if(isset($_GET['readReplyId'])){
    $data = array();
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT * FROM reply_slip_details WHERE spas_id = ?");
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
    
        $stnt = $pdo->prepare("SELECT sc.spas_id, p.name as course, p.discipline, s.name as schools, r.sy_start, r.term_type, r.term_start, r.latest_flag
        FROM scholarship_info AS sc
		LEFT OUTER JOIN course_record AS r ON sc.spas_id = r.spas_id
		LEFT OUTER JOIN courses AS p ON r.course_code = p.id::text
		LEFT OUTER JOIN colleges AS s ON r.school_code = s.id::text
		WHERE sc.primary_spas_id = ?
		
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
    
        $stnt = $pdo->prepare("SELECT 
    t.sy, 
    se.name,
    CONCAT(s.name, ', ', c.name) AS schoolcourse, 
    p1.progress_status AS pstart,
    p2.progress_status AS pend,
    s1.standing AS sstanding,
    s2.standing AS send

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
    $id = $_POST["id"];
    try
    {
    
        $stnt = $pdo->prepare("SELECT r.sy_start, r.term_start, s.name as school, c.name as course, r.created_by,
        r.updated_by, r.verified_by, r.created_at, r.updated_at
        
        FROM course_record as r
        
        LEFT OUTER JOIN colleges as s ON s.id::text = r.school_code
        LEFT OUTER JOIN courses as c ON c.id::text = r.course_code
        
        WHERE r.spas_id = ?
    
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


    // Read View Start Status

if(isset($_GET['viewStartStatID'])){
    $data = array();
    $id = $_POST["id"];

    $progress = $_POST["progress"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT p.sy, s.name, p.start_end, p.progress_status,
p.created_by, p.updated_by, p.verified_by,
to_char(p.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(p.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at


FROM progress_status_history as p

LEFT JOIN semestral as s ON p.term = s.id

WHERE p.spas_id = ?
AND p.start_end = 1
AND p.progress_status = ?

    
        ");
        $params = array($id,$progress);
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
    
    $progress = $_POST["progress"];

    try
    {
    
        $stnt = $pdo->prepare("SELECT p.sy, s.name, p.start_end, p.progress_status,
p.created_by, p.updated_by, p.verified_by,
to_char(p.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(p.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at


FROM progress_status_history as p

LEFT JOIN semestral as s ON p.term = s.id

WHERE p.spas_id = ?
AND p.start_end = 2
AND p.progress_status = ?
        ");
        $params = array($id,$progress);
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
    $progress = $_POST["progress"];
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT sh.sy, s.name, sh.start_end,
sh.standing, ms.list_name, sh.created_by, sh.updated_by, 
sh.verified_by, 
to_char(sh.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(sh.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at

FROM standing_history as sh

LEFT JOIN semestral as s ON sh.term = s.id
LEFT JOIN monitored_scholars as m ON sh.spas_id = m.spas_id
LEFT JOIN monitored_scholars_list_generation_history as ms ON m.list_id = ms.id


WHERE sh.spas_id = ?
AND sh.standing = ?
AND sh.start_end = 1
");
        $params = array($id,$progress);
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
    $progress = $_POST["progress"];
    
    try
    {
    
        $stnt = $pdo->prepare("SELECT sh.sy, s.name, sh.start_end,
sh.standing, ms.list_name, sh.created_by, sh.updated_by, 
sh.verified_by, 
to_char(sh.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
to_char(sh.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at

FROM standing_history as sh

LEFT JOIN semestral as s ON sh.term = s.id
LEFT JOIN monitored_scholars as m ON sh.spas_id = m.spas_id
LEFT JOIN monitored_scholars_list_generation_history as ms ON m.list_id = ms.id


WHERE sh.spas_id = ?
AND sh.standing = ?
AND sh.start_end = 2

    
        ");
        $params = array($id,$progress);
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

if(isset($_GET['readEligible'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT sr.full_name, si.spas_id, si.yr_awarded, sh.standing, sh.sy, sh.term, sh.term_type,
        sh.term_id
        FROM scholars_record as sr
        
        INNER JOIN scholarship_info AS si ON sr.spas_id = si.primary_spas_id
        INNER JOIN standing_history AS sh ON si.spas_id = sh.spas_id
        
        WHERE sh.latest_flag = 'TRUE'
        AND sh.start_end = 1
         AND (
                (sh.standing = 'GOOD STANDING')
                OR
                (sh.standing = 'SUSPENDED')
            )
        ORDER BY sr.full_name
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

      // Export CSV


    if(isset($_GET['exportCSV'])){
        $data = array();
        try
        {
        
            $stnt = $pdo->prepare("SELECT
            scholars_record.spas_id, 
            scholars_record.full_name,
            scholarship_info.program,
            scholarship_info.sub_program,
            colleges.name as school,
            colleges.region,
            courses.name as course,
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
            End AS Start_End,
            standing_history.updated_at
        FROM
            scholars_record
        JOIN
            scholarship_info ON scholars_record.spas_id = scholarship_info.primary_spas_id
        JOIN
            standing_history ON (
                (standing_history.spas_id = scholarship_info.spas_id AND standing_history.standing = 'GOOD STANDING' AND standing_history.latest_flag = 'TRUE' AND standing_history.start_end = 1)
                OR
                (standing_history.spas_id = scholarship_info.spas_id AND standing_history.standing = 'SUSPENDED' AND standing_history.latest_flag = 'TRUE' AND standing_history.start_end = 1)
            )
        JOIN
            progress_status_history ON
                standing_history.term_id = progress_status_history.term_id AND
                standing_history.start_end = progress_status_history.start_end
        LEFT JOIN
            course_record ON course_record.spas_id = scholarship_info.spas_id AND course_record.latest_flag = 1
        LEFT JOIN
            courses ON course_record.course_code = CAST(courses.id AS VARCHAR)
        LEFT JOIN
            colleges ON CAST(course_record.school_code AS INTEGER) = colleges.id
            
            ORDER BY scholars_record.full_name
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
	t.latest_flag
    

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
	AND t.latest_flag = 1
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
        
                    "value" => $row['name']
        
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
        
            $stnt = $pdo->prepare("SELECT spas_id FROM scholarship_info WHERE primary_spas_id = ?");
            $stnt->execute([$pspasid]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['spas_id'],
        
                    "value" => $row['spas_id']
        
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
    
        $stnt = $pdo->prepare("SELECT name FROM colleges ORDER BY id");
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


    // Read Course

if(isset($_GET['courses'])){
    $data = array();
    try
    {
    
        $stnt = $pdo->prepare("SELECT name FROM courses ORDER BY id");
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

    if(isset($_GET['readTermRec'])){
        $data = array();
        $spasid = $_POST['id'];
        try
        {
        
            $stnt = $pdo->prepare("SELECT t.term_id, t.sy, s.name 
            FROM term_record as t 
            LEFT JOIN semestral as s ON t.term = s.id
            WHERE 
            t.spas_id = ?");
            $stnt->execute([$spasid]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['sy'] . " ". $row['name'],
        
                    "value" => $row['term_id']
        
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
        
            $stnt = $pdo->prepare("SELECT t.sy, se.name, cr.spas_id, CONCAT(s.name, ', ', c.name) AS schoolcourse

FROM 
    term_record t
	
LEFT JOIN 
    course_record cr ON t.course_id = cr.id
LEFT JOIN 
    courses c ON cr.course_code = c.id::text
LEFT JOIN 
    colleges s ON cr.school_code = s.id::text
LEFT JOIN 
	semestral as se ON t.term = se.id
	
	
WHERE t.spas_id = ?");
            $stnt->execute([$spasid]);
        
        }catch (Exception $ex){
            die("Failed to run query". $ex);
        
        }
        
        http_response_code(200);
        
        while ($row = $stnt->fetch()){
            $data[] = array(
        
                    "label" => $row['schoolcourse'] . " ". $row['name']. " ". $row['sy'],
        
                    "value" => $row['schoolcourse']
        
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
       next_year,
       CONCAT(yr_awarded, '-', next_year) AS school_year
FROM (
    SELECT yr_awarded,
           LEAD(yr_awarded) OVER (ORDER BY yr_awarded) AS next_year
    FROM scholarship_info
    WHERE yr_awarded IS NOT NULL AND yr_awarded != 0
    GROUP BY yr_awarded
) AS subquery
WHERE next_year IS NOT NULL
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
    






    























?>