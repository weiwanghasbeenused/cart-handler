<?php
require_once('res_head.php');
require_once(__DIR__ . '/../static/php/functions_form_inspection.php');
// $db = db_connect('main');
$table = getenv('REGISTER_TABLE_NAME');
$vars = array('firstName', 'lastName', 'email', 'password', 'live_key', 'sandbox_key');
$vars_required = array('firstName', 'lastName', 'email', 'password');
$response = array(
    'status' => '',
    'errorType' => '',
    'body' => ''
);
checkMissingVars($vars_required, $_POST, $response);
checkEmailFormat($_POST['email'], $response);
$result = getStudent($_POST['email'], $db);
if($result->num_rows) {
    $response['status'] = 'error';
    $response['errorType'] = 'deplicate email address';
    $response['body'] = '這個 email 已經被註冊過了';
    echo json_encode($response);
    exit();
}
$live_key = bin2hex(random_bytes(32));
$sandbox_key = bin2hex(random_bytes(32));
$values_with_key = $_POST;
$values_with_key['live_key'] = $live_key;
$values_with_key['sandbox_key'] = $sandbox_key;
$stmtParams = prepareStmtParams($vars, $values_with_key);
$values = $stmtParams['values'];
$stmt_marks = $stmtParams['marks'];

$sql = 'INSERT INTO `'.$table.'` (`' . implode('`, `', $vars) . '`) VALUES(' . implode(', ', $stmt_marks['q']) . ')'; 
$stmt = $db->prepare($sql);
$stmt->bind_param(implode('', $stmt_marks['d']), ...$values);
$inserted = $stmt->execute();
if( !$inserted ){
    $response['status'] = 'error';
    $response['errorType'] = 'database';
    $response['body'] = $stmt->get_result();
    echo json_encode($response);
    exit();
}
$response['status'] = 'success';
echo json_encode($response);
exit();