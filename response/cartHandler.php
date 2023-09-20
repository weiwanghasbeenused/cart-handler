<?php
require_once('res_head.php');
require_once(__DIR__ . '/../static/php/functions_form_inspection.php');
$vars = array('items', 'subtotal', 'mode', 'submitterId', 'created');
$vars_required = array('items', 'subtotal', 'token');
$table = getenv('REGISTER_TABLE_NAME');
$response = array(
    'status' => '',
    'errorType' => '',
    'body' => ''
);
checkMissingVars($vars_required, $submission, $response);
require_once(__DIR__ . '/../config/config.php');

// $items = $submission["productIds"];
// $subtotal = $submission['subtotal'];
$token = $submission['token'];
$created = date("Y-m-d H:i:s", time());

$result = getStudentByToken($token, $db);
if(!$result['student']->num_rows)
{
	$response['status'] = 'error';
	$response['errorType'] = 'student doesnt exist';
	$response['body'] = 'key 不存在, 請確認你送出的 key 無誤';
	echo json_encode($response);
	exit();
}
$mode = $result['mode'];
$student = $result['student']->fetch_assoc();
$values_with_key = $submission;
$values_with_key['submitterId'] = $student['id'];
$values_with_key['created'] = $created;
$values_with_key['mode'] = $mode;
if(is_array($values_with_key['items'])) $values_with_key['items'] = json_encode($values_with_key['items']);
unset($values_with_key['token']);
$stmtParams = prepareStmtParams($vars, $values_with_key);
$values = $stmtParams['values'];
$stmt_marks = $stmtParams['marks'];
$sql = "INSERT INTO submissions (`" . implode('`, `', $vars) . "`) VALUES (" . implode(', ', $stmt_marks['q']) . ")";
$stmt = $db->prepare($sql);
$stmt->bind_param(implode('', $stmt_marks['d']), ...$values);
$executed = $stmt->execute();

if(!$executed) {
    $response['status'] = 'error';
    $response['errorType'] = 'database';
    $response['body'] = '資料庫發生錯誤 . . . 請稍後再試一次';
    echo json_encode($response);
    exit();
}
$response['status'] = 'success';
$response['errorType'] = '';
$response['body'] = '成功提交!';
echo json_encode($response);
exit();
?>
