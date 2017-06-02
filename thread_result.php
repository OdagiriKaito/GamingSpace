<?php
$db=new PDO('mysql:host=localhost;dbname=underground','root');

$category=$_POST['category'];
$subcategory=$_POST['subcategory'];
$name=$_POST['FROM'];
$mail=$_POST['mail'];
$message=$_POST['MESSAGE'];
$subject=$_POST['subject'];
$create_date=date('Y-m-d H:i:s');


if(!isset($subject) || $subject==""){
  echo "titleが無い";
  return;
}
try
{
$db->beginTransaction();
$query=$db->prepare("insert thread(title,create_date,cat_id,subcat_id)values(?,?,?,?)");
$query->execute(array($subject, $create_date, $category, $subcategory));

$thread_id=$db->lastInsertId();
$query=$db->prepare("insert response(name,response_date,text,thread_id)values(?,?,?,?)");
$query->execute(array($name, $create_date, $message, $thread_id));

$db->commit();
}
catch(PDOExecption $e)
{
  $db->rollback();
}
?>
