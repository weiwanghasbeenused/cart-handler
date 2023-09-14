<?php
function getMissingVars($vars, $post){
    $output = array();
    foreach($vars as $var) 
        if(!isset($post[$var]) || !$post[$var]) $output[] = $var;
    
    return $output;
}
function checkMissingVars($vars, $post, $response){
    $missing_vars = getMissingVars($vars, $post);
    if(!empty($missing_vars)) {
        $response['status'] = 'error';
        $response['errorType'] = 'missing vars';
        $response['body'] = implode(', ', $missing_vars);
        echo json_encode($response);
        exit();
    }
    return true;
}
function prepareStmtParams($vars, $post){
    $output = array(
        'marks' => array(
            'q' => array(),
            'd' => array()
        ),
        'values' => array()
    );
    foreach($vars as $var) {
        $output['marks']['q'][] = '?';
        $output['marks']['d'][] = 's';
        $output['values'][] = $post[$var];
    }
    return $output;
}

function checkEmailFormat($email, $response){
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['errorType'] = 'email format';
        $response['body'] = '電子信箱格式不符';
        echo json_encode($response);
        exit();
    }
    return true;
}

function getStudent($email, $db) {
    $sql = 'SELECT * FROM `students` WHERE `email` = ?';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function getStudentByToken($token, $db) {
    $output = array();
    $sql = 'SELECT * FROM `students` WHERE `live_key` = ?';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows) {
        $output['mode'] = 'live';
        $output['student'] = $result;
        return $output;
    }
    $sql = 'SELECT * FROM `students` WHERE `sandbox_key` = ?';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $output['mode'] = 'sandbox';
    $output['student'] = $result;
    return $output;
}