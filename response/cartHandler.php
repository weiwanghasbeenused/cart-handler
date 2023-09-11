<?php
require_once('res_head.php');
require_once(__DIR__ . '/../static/php/functions_form_inspection.php');
$vars = array('productIds', 'subtotal', 'token', 'submitterId', 'created');
$vars_required = array('productIds', 'subtotal', 'token');
$table = getenv('REGISTER_TABLE_NAME');
$response = array(
    'status' => '',
    'errorType' => '',
    'body' => ''
);
checkMissingVars($vars_required, $_POST, $response);
require_once('../config/config.php');

// $items = $_POST["productIds"];
// $subtotal = $_POST['subtotal'];
// $token = $_POST['token'];
$created = date("Y-m-d H:i:s", time());

$student = getStudentByToken($token, $db);
if(!$student['student']->num_rows)
{
	$response['status'] = 'error';
	$response['errorType'] = 'student doesnt exist';
	$response['body'] = 'token 不存在, 請確認你送出的 token 無誤';
	echo json_encode($response);
	exit();
}
$student = $student->fetch_assoc();
$values_with_key = $_POST;
$values_with_key['submitterId'] = $student['id'];
$values_with_key['created'] = $created;
$stmtParams = prepareStmtParams($vars, $_POST);
$values = $stmtParams['values'];
$stmt_marks = $stmtParams['marks'];

$sql = "INSERT INTO submissions (`' . implode('`, `', $vars) . '`) VALUES (" . implode(', ', $stmt_marks['q']) . ")";
$stmt = $db->prepare($sql);
$stmt->bind_param(implode('', $stmt_marks['d']), ...$values);
$result = $stmt->execute();
if(!$result->num_rows) {
    $response['status'] = 'error';
    $response['errorType'] = 'database';
    $response['body'] = '資料庫發生錯誤 . . . 請稍後再試一次';
    echo json_encode($response);
    exit();
}
if($student['password'] !== $_POST['password']) {
    $response['status'] = 'success';
    // $response['errorType'] = '';
    // $response['body'] = '密碼錯誤';
    echo json_encode($response);
    exit();
}
?>
