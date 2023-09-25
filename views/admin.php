<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../static/php/functions.php');
$db = db_connect('admin');

$html = array(
  'students' => '',
  'mailinglist' => array(),
  'products' => '',
  'submissions' => array()
);

$sql_getProducts = "SELECT * FROM `products`";
$result = $db->query($sql_getProducts);
$products = array();
if($result){
  while($obj = $result->fetch_assoc()){
    $products[$obj['id']] = $obj;
    $html['products'] .= '<div class="product-wrapper">';
    $html['products'] .= '<div class="product-id">' . $obj['id'] . '</div>';
    $html['products'] .= '<div class="product-title">' . $obj['title'] . '</div>';
    $html['products'] .= '<div class="product-price">' . $obj['price'] . '</div>';
    $html['products'] .= '<div class="product-thumbnail"><img src="/assets/images/'.$obj['thumbnail'].'"></div>';
    $html['products'] .= '<div class="product-buttons-wrapper"><button class="product-button product-button-edit" data-product-id = "'.$obj['id'].'" data-cation="edit">EDIT</button><button class="product-button product-button-delete" data-product-id = "'.$obj['id'].'" data-cation="delete">DELETE</button></div>';
    $html['products'] .= '</div>';
  }
}

$html_students = '';

$sql_getStudents = "SELECT * FROM `students`";
$result = $db->query($sql_getStudents);
$students = array();
if($result)
  while($obj = $result->fetch_assoc())
    $students[] = $obj;

$sql_getLiveSubmissions = "SELECT * FROM `submissions` WHERE `submitterId`=? AND `mode`='live'";
foreach($students as $s){
  if($s['email'] == 'weiwanghasbeenused@gmail.com' || $s['email'] == 'drxk41012@gmail.com') continue;
  $name = $s['lastName'] . $s['firstName'];
  $html['mailinglist'][] = $s['email'];
  $html['students'] .=  '<div class="row student-wrapper">';
  $submissions = array();
  $stmt = $db->prepare($sql_getLiveSubmissions);
  $stmt->bind_param('s', $s['id']);
  $executed = $stmt->execute();
  if($executed) {
    $result = $stmt->get_result();
    if($result->num_rows){
      $html['submissions'][$name] = array();
      while($obj = $result->fetch_assoc()){
        if($s['assignment']) {
          $isCorrect = array_values_equal(json_decode($s['assignment']), json_decode($obj['items']));
          $html['submissions'][$name][] = array(
            'items' => $obj['items'],
            'passed'  => $isCorrect
          );
        }
        // $html['submissions'] .= '<div class="submission-items">' . $obj['items'] . ' ' . $isCorrect  . '</div>';
      }
    }
      
        
  }

  $html['students'] .= '<div class="grid-cell student-name"><span class="student-lastName">' . $s['lastName'] . '</span><span class="student-firstName">' . $s['firstName'] . '</span></div>';
  $html['students'] .= '<div class="grid-cell student-email">' . $s['email'] . '</div>';
  $html['students'] .= '<div class="grid-cell student-assignments">' . $s['assignment'] . '</div>';
  // $html['students'] .= '<div class="student-submissions">' . $html['submissions'] . '</div>';
  $html['students'] .= '</div>';
  // $html_students .= $html;
}
$html['mailinglist'] = implode(', ', $html['mailinglist']);
$html['mailinglist'] = '<textarea id="mailinglist-container">' . $html['mailinglist'] . '</textarea><button id="get-mailinglist-btn">複製 mailinglist</button>';
$html['products'] = '<div class="grid-container">' . $html['products'] . '</div>';
$temp = '';
foreach($html['submissions'] as $student => $subs) {
  $isPassed = false;
  $temp_individual = '';
  foreach($subs as $sub) {
    $class = 'items';
    if($sub['passed']) {
      $class .= ' passed';
      $isPassed = true;
    }
    $temp_individual .= '<div class="'.$class.'">' . $sub['items'] . '</div>';
  }
  $class = $isPassed ? 'row submission-row passed' : 'row submission-row';
  $temp .= '<div class="'.$class.'"><div class="cell student-name">' . $student . '</div><div class="cell studdent-submissions-wrapper">' . $temp_individual . '</div></div>';
};
$html['submissions'] = $temp;

?>
<main page="<?php echo $uri[1]; ?>">
  <?php 
    foreach($html as $key => $content) {
      ?><section id="section-<?php echo $key; ?>"><?php echo $content; ?></section><?
    }
  ?>
</main>
<script>
  let mailinglistContainer = document.getElementById('mailinglist-container');
  let getMailinglistBtn = document.getElementById('get-mailinglist-btn');
  if(getMailinglistBtn) {
    if(navigator.clipboard) {
      getMailinglistBtn.addEventListener('click', function(){
        mailinglistContainer.select();
        mailinglistContainer.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(mailinglistContainer.value);
      });
    }
    else getMailinglistBtn.style.display = 'none';
  }
</script>
<style>
  /* .grid-row {
    display: flex;
  } */
  section + section {
    margin-top: 60px;
  }
  .student-name { 
    flex: 0 0 150px;
  }
  .student-email { 
    flex: 1;
  }
  .student-assignments { 
    flex: 0 0 200px;
  }
  #mailinglist-container
  {
    width: 100%;
  }
  .grid-container {
    display: flex;
    flex-wrap: wrap;
  }
  .product-wrapper {
    flex: 1;
    margin-bottom: 20px;
  }
  .items + .items {
    /* border-top: 1px solid; */
  }
  .items.passed {
    background-color: pink;
  }
  .studdent-submissions-wrapper
  {
    flex: 1;
  }
  .row.passed .student-name:after {
    content: "\2713";
    display: inline;
  }
</style>
<?php
