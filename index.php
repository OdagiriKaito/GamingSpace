<!doctype html>
<html>
<head>
<meta charset="utf-8" />
  <script src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">
</script>
  <script src="/js/uikit.min.js"></script>
  <script src="/js/uikit-icons.min.js"></script>
  <script src="/js/index.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/css/uikit.min.css">
  <link rel="stylesheet" type="text/css" href="/css/uikit-rtl.min.css">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
  <h1 id="title">Gaming Space</h1>
<?php

$db=new PDO('mysql:host=localhost;dbname=underground','root');

$sql='select * from category';
$stmt =$db->query($sql);

$result=$stmt->fetchAll();
?>
カテゴリを選択</br>
<section id="category-container">
<section id="category-list">
<?php
$sql = 'select * from subcategory order by cat_id, id';
$stmt = $db->query($sql);
$res = $stmt->fetchAll();
$subcategorys = array();
foreach($res as $row){
if(!isset($subcategorys[$row['cat_id']])){
$subcategorys[$row['cat_id']] = array();
}
array_push($subcategorys[$row['cat_id']],
   array(
         'id' => $row['id'],
         'name' => $row['subcategory_name']
       )
   );
}

$sql='select * from category';
$stmt =$db->query($sql);
$categorys=$stmt->fetchAll();
foreach($categorys as $row){
?>
<span class="category"><?php echo $row['category_name']?></span>
<ul class='subcategory'>
<?php
 foreach($subcategorys[$row['id']] as $key =>$subcategory){
?>
 <li>
   <a href="/thread_list.php?id=<?php echo $row['id'] ?>&subcat_id=<?php echo $subcategory['id'] ?>">
     <?php echo $subcategory['name'] ?>
   </a>
 </li>
 <?php
 }
 ?>
</ul>
<?php
}
?>
</section>
</section>

<section id="introduction">
  <span>introduction</span>
</section>

<section id="introduction-image">
  &nbsp;
</section>

</body>
</html>
