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
    // $frstyr = $_POST["frstYearSelect"];
    // $scndyr = $_POST["yearselect"];
    
    
    try
    {
    
    //     $stnt = $pdo->prepare("SELECT COUNT(sex) AS malecount 
    // FROM g_scholar_profile 
    // WHERE sex LIKE '%M%' 
    // AND EXTRACT(YEAR FROM added_on) BETWEEN ? AND ?");
    //     $stnt->execute([$frstyr,$scndyr]);


        $stnt = $pdo->prepare("SELECT COUNT(program) AS meritcount 
    FROM scholarship_info 
    WHERE program LIKE '%MERIT%'");
        $stnt->execute();
    
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


     // Count RA 10612


if(isset($_GET['ra10612'])){


    $data = array();
    // $frstyr = $_POST["frstYearSelect"];
    // $scndyr = $_POST["yearselect"];
    
    
    try
    {
    
    //     $stnt = $pdo->prepare("SELECT COUNT(sex) AS malecount 
    // FROM g_scholar_profile 
    // WHERE sex LIKE '%M%' 
    // AND EXTRACT(YEAR FROM added_on) BETWEEN ? AND ?");
    //     $stnt->execute([$frstyr,$scndyr]);


        $stnt = $pdo->prepare("SELECT COUNT(program) AS ra10612count 
    FROM scholarship_info 
    WHERE program LIKE '%RA 10612%'");
        $stnt->execute();
    
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


     // RA 7687


if(isset($_GET['ra7687'])){


    $data = array();
    // $frstyr = $_POST["frstYearSelect"];
    // $scndyr = $_POST["yearselect"];
    
    
    try
    {
    
    //     $stnt = $pdo->prepare("SELECT COUNT(sex) AS malecount 
    // FROM g_scholar_profile 
    // WHERE sex LIKE '%M%' 
    // AND EXTRACT(YEAR FROM added_on) BETWEEN ? AND ?");
    //     $stnt->execute([$frstyr,$scndyr]);


        $stnt = $pdo->prepare("SELECT COUNT(program) AS ra7687count 
    FROM scholarship_info 
    WHERE program LIKE '%RA 7687%'");
        $stnt->execute();
    
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

// The data is not accurate due to not scholar status in ROWS in some of data in school_grad_status


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



    























?>