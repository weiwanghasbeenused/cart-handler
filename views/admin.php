<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../static/php/functions.php');
$db = db_connect('admin');

$html_products = '';

$sql_getProducts = "SELECT * FROM `products`";
$result = $db->query($sql_getProducts);
$products = array();
if($result){
  while($obj = $result->fetch_assoc()){
    $products[$obj['id']] = $obj;
    $html_products .= '<div class="product-wrapper">';
    $html_products .= '<div class="product-id">' . $obj['id'] . '</div>';
    $html_products .= '<div class="product-title">' . $obj['title'] . '</div>';
    $html_products .= '<div class="product-price">' . $obj['price'] . '</div>';
    $html_products .= '<div class="product-thumbnail"><img src="/assets/images/'.$obj['thumbnail'].'"></div>';
    $html_products .= '<div class="product-buttons-wrapper"><button class="product-button product-button-edit" data-product-id = "'.$obj['id'].'" data-cation="edit">EDIT</button><button class="product-button product-button-delete" data-product-id = "'.$obj['id'].'" data-cation="delete">DELETE</button>';
    $html_products .= '</div>';
  }
}

$html_students = '';

$sql_getStudents = "SELECT * FROM `students`";
$result = $db->query($sql_getStudents);
$students = array();
if($result)
  while($obj = $result->fetch_assoc())
    $students[] = $obj;

$sql_getLiveSubmissions = "SELECT * FROM `submissions` WHERE `submitterId`=? AND `mode`='sandbox'";
foreach($students as $s){
  $html = '<div class="student-wrapper">';
  $submissions = array();
  $stmt = $db->prepare($sql_getLiveSubmissions);
  $stmt->bind_param('s', $s['id']);
  $executed = $stmt->execute();
  $html_submissions = '';
  if($executed) {
    $result = $stmt->get_result();
    if($result->num_rows)
      while($obj = $result->fetch_assoc())
        $html_submissions .= '<div class="submission-items">' . $obj['items'] . '</div>';
  }
  $html .= '<div class="student-name"><span class="student-lastName">' . $s['lastName'] . '</span><span class="student-firstName">' . $s['firstName'] . '</span></div>';
  $html .= '<div class="student-email">' . $s['email'] . '</div>';
  $html .= '<div class="student-assignments">' . $s['assignment'] . '</div>';
  $html .= '<div class="student-submissions">' . $html_submissions . '</div>';
  $html .= '</div>';
  $html_students .= $html;
}
  
?>
<main page="<?php echo $uri[1]; ?>">
  <section id="section-students"><?php echo $html_students; ?></section>
  <section id="section-products"><?php echo $html_products; ?></section>
</main>

<?php
/*
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
$sql = "SELECT * FROM submissions";
$result = $db->query($sql);
$responses = array();
while($obj = $result->fetch_assoc()){
  $responses[$obj['submitterId']] = $obj;
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
*/