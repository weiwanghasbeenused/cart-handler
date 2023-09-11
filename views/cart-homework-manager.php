<?php
require_once('utils/cart-homework-manager/config.php');
$dest = 'utils/cart-homework-manager/output/output.txt';
$output = fopen($dest,'r');

$answer = array();
$isNewStudent = true;
$currentStudent = '';
while ($line = fgets($output)) {
  if( $line == "\n" || strpos($line, '商品:') !== false ) continue;
  if( strpos( $line, "---" ) !== false ) {
    $isNewStudent = true;
    continue;
  }
  $line_content = str_replace(array("\r", "\n"), '', $line);
  if( $isNewStudent ) {
    $currentStudent = $line_content;
    $answer[$currentStudent] = array();
    $isNewStudent = false;
  }
  else
  {
    $answer[$currentStudent][] = $line_content;
  }
}
fclose($output);

function checkStudent($find, $list){
  foreach($list as $item)
  {
    if(strpos($item, $find) !== false)
      return $item;
  }
  return false;
}
$sql = "SELECT * FROM submissions WHERE 1 = 1";
$result = $db->query($sql);
$responses = array();
while($obj = $result->fetch_assoc()){
  $responses[$obj["name"]] = $obj;
}
$mismatches = array();
$submitted = array();
$idx = 1;
foreach($responses as $n => $r){
  $studentName = $n;
  if( !isset($answer[$studentName])){
    $possibleName = checkStudent($studentName, $student);
    if(!$possibleName){
      continue; 
    }
    $studentName = $possibleName . ' ('.$studentName.')';
    
    $a = $answer[$possibleName];
  }
  else
  {
    $a = $answer[$studentName];
  }
  echo $idx . ': ' . $studentName . '<br>';
  // $item_ids = json_decode($r['items']);
  $sql = "SELECT title FROM products WHERE id IN (" . $r['items'] . ")";
  $result = $db->query($sql);
  $item_names = array();
  while($obj = $result->fetch_assoc()){
    $item_names[] = $obj['title'];
  }
  
  
  if( !empty(array_diff( $a, $item_names )) ){
    $error_items = array_diff( $a, $item_names );
    echo '有誤! 缺少商品: ' . implode(', ', $error_items) . '<br><br>';
  }
  else if( !empty(array_diff( $item_names, $a )) )
  {
    $error_items = array_diff( $item_names, $a );
    echo '有誤! 多出商品: ' . implode(', ', $error_items) . '<br><br>';
  }
  else
  {
    echo '全對<br><br>';
  }
  if(in_array($studentName, $submitted)) echo '重複提交<br><br>';
  $submitted[] = $studentName;
  $idx++;
}
