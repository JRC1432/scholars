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
    
        $stnt = $pdo->prepare("SELECT 
       *
    FROM 
        users 
    WHERE 
        status = 'active' 
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
    
        $stnt = $pdo->prepare("SELECT * FROM scholars_record WHERE spas_id = ?");
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
        c.contract_status, s.sy_insured, s.batch_insured
        FROM scholarship_info AS s
        LEFT OUTER JOIN contract_status_details AS c ON s.spas_id = c.spas_id
        WHERE s.spas_id = ?");
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
    
        $stnt = $pdo->prepare("SELECT 
        c.contract_status, c.avail_award, c.other_schp, c.duration,
        c.etg, c.etg_month, c.created_by, c.updated_by, c.verified_by, 
        t.term_type, t.sy, c.term_id, t.term_id, 
        p.name as course, s.name as schools
    FROM 
        contract_status_details AS c
    LEFT OUTER JOIN 
        term_record AS t ON t.term_id = c.term_id
    LEFT OUTER JOIN 
        course_record AS r ON r.spas_id = c.spas_id
    LEFT OUTER JOIN 
        courses AS p ON p.id::text = r.course_code 
    LEFT OUTER JOIN 
        colleges AS s ON s.id::text = r.school_code WHERE c.spas_id = ?");
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
    
        $stnt = $pdo->prepare("SELECT r.spas_id, p.name as course, p.discipline, s.name as schools, r.sy_start, r.term_type, r.term_start, r.latest_flag
        FROM course_record AS r
        LEFT OUTER JOIN courses AS p ON p.id::text = r.course_code
        LEFT OUTER JOIN colleges AS s ON s.id::text = r.school_code
        WHERE r.spas_id = ?");
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
        s.spas_id = ?
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
    
        $stnt = $pdo->prepare("SELECT t.sy, se.name, CONCAT(s.name, ', ', c.name) AS schoolcourse, p1.progress_status as pstart, h1.standing as sstanding, p2.progress_status as pend,
        h2.standing as send
        FROM term_record as t
        
        LEFT OUTER JOIN course_record as r ON r.term_id = t.term_id
        LEFT OUTER JOIN courses as c ON c.id::text = r.course_code
        LEFT OUTER JOIN colleges as s ON s.id::text = r.school_code
        LEFT OUTER JOIN progress_status_history as p1 ON p1.id = t.progress_status_start
        LEFT OUTER JOIN progress_status_history as p2 ON p2.id = t.progress_status_end
        LEFT OUTER JOIN standing_history as h1 ON h1.id = t.standing_start
        LEFT OUTER JOIN standing_history as h2 ON h2.id	= t.standing_end
        LEFT OUTER JOIN semestral as se ON se.id = t.term

        WHERE t.spas_id = ?
    
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
    
        $stnt = $pdo->prepare("SELECT r.spas_id, p.spas_id, r.sy_start, s.name, p.start_end, p.progress_status, r.created_by,
        r.updated_by, r.verified_by, 
        to_char(p.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
        to_char(p.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at
        
        FROM course_record as r
        
        LEFT OUTER JOIN progress_status_history as p ON p.spas_id = r.spas_id
        LEFT OUTER JOIN semestral as s ON s.id = r.term_start
		
		WHERE r.spas_id = ? 
		AND p.start_end = 1
		AND p.progress_status = ?;

    
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
    
        $stnt = $pdo->prepare("SELECT r.spas_id, p.spas_id, r.sy_start, s.name, p.start_end, p.progress_status, r.created_by,
        r.updated_by, r.verified_by,
        to_char(p.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
        to_char(p.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at
        
        FROM course_record as r
        
        LEFT OUTER JOIN progress_status_history as p ON p.spas_id = r.spas_id
        LEFT OUTER JOIN semestral as s ON s.id = r.term_start
		
		WHERE r.spas_id = ? 
		AND p.start_end = 2
		AND p.progress_status = ?;

    
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
    
        $stnt = $pdo->prepare("SELECT r.spas_id, p.spas_id, r.sy_start, s.name, p.start_end, sh.standing, msl.list_name, p.progress_status, r.created_by,
        r.updated_by, r.verified_by, 
        to_char(p.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
        to_char(p.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at
        
        FROM course_record as r
        
        LEFT OUTER JOIN progress_status_history as p ON p.spas_id = r.spas_id
        LEFT OUTER JOIN semestral as s ON s.id = r.term_start
		LEFT OUTER JOIN standing_history as sh ON sh.term_id = r.term_id
		LEFT OUTER JOIN monitored_scholars as ms ON ms.spas_id = r.spas_id
		LEFT OUTER JOIN monitored_scholars_list_generation_history as msl ON msl.id = ms.list_id
		
		WHERE r.spas_id = ? 
		AND p.start_end = 1
        AND p.progress_status = ?;

    
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
    
        $stnt = $pdo->prepare("SELECT r.spas_id, p.spas_id, r.sy_start, s.name, p.start_end, sh.standing, msl.list_name, p.progress_status, r.created_by,
        r.updated_by, r.verified_by, 
        to_char(p.created_at, 'MONTH DD, YYYY on HH12:MI AM') as created_at,
        to_char(p.updated_at, 'MONTH DD, YYYY on HH12:MI AM') as updated_at
        
        FROM course_record as r
        
        LEFT OUTER JOIN progress_status_history as p ON p.spas_id = r.spas_id
        LEFT OUTER JOIN semestral as s ON s.id = r.term_start
		LEFT OUTER JOIN standing_history as sh ON sh.term_id = r.term_id
		LEFT OUTER JOIN monitored_scholars as ms ON ms.spas_id = r.spas_id
		LEFT OUTER JOIN monitored_scholars_list_generation_history as msl ON msl.id = ms.list_id
		
		WHERE r.spas_id = ? 
		AND p.start_end = 2
        AND p.progress_status = ?;

    
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
            colleges.name,
            colleges.region,
            courses.name,
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






    























?>