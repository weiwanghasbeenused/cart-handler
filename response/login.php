<?php
require_once('res_head.php');
require_once(__DIR__ . '/../static/php/functions_form_inspection.php');
require_once(__DIR__ . '/../static/php/generate_jwt.php');
$vars = array('email', 'password');
$vars_required = array('email', 'password');
$response = array(
    'status' => '',
    'errorType' => '',
    'body' => ''
);
checkMissingVars($vars_required, $_POST, $response);
checkEmailFormat($_POST['email'], $response);
$result = getStudent($_POST['email'], $db);
if(!$result->num_rows) {
    $response['status'] = 'error';
    $response['errorType'] = 'student';
    $response['body'] = '該帳號不存在';
    echo json_encode($response);
    exit();
}
$student = $result->fetch_assoc();
if($student['password'] !== $_POST['password']) {
    $response['status'] = 'error';
    $response['errorType'] = 'student';
    $response['body'] = '密碼錯誤';
    echo json_encode($response);
    exit();
}
$token = generate_jwt($_POST['email']);
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '/';
$redirect .= '?token=' . $token;

$response['status'] = 'success';
$response['body'] = $redirect;
echo json_encode($response);
exit();
?>
