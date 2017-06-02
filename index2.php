<!DOCTYPE html>
<html>
<head><title>PHP TEST</title></head>
<body>

  <?php

$db=new PDO('mysql:host=localhost;dbname=underground','root');
if(is_null($db))
{
  echo'接続失敗';
}
else {
  echo'接続成功';
}

//$db=null;

/*
$link=mysql_connect('localhost','root');
if(!$link){
  die('接続失敗です。'.mysql_error());
}

printf("<p>接続に成功しました。</p>");

$close_flag=mysql_close($link);

if($close_flag){
  printf('<p>切断に成功しました。<p>');

}
*/

if(isset($_POST['kanso']))
{
  $name=$_POST['name'];
  $kanso=$_POST['kanso'];
  $res_date=date('Y-m-d H:i:s');

  $query=$db->prepare("insert response(name,response_date,text)values(?,?,?)");
  $query->execute(array($name, $res_date, $kanso));
}

$sql='select * from response';
$stmt =$db->query($sql);

$result=$stmt->fetchAll();
   ?>
<form action="/index2.php" method="post">
<p>
名前：<input type="text" name="name" size="40">
</p>
<p>
書き込み：<br>
<textarea name="kanso" rows="4" cols="40"></textarea>
</p>
<p>
<input type="submit" value="書き込み"><input type="reset" value="削除">
</p>
</form>
<ul>
  <?php
foreach($result as $row)
{
  ?>
  <li>
    <?php echo $row['name']; ?>(<?php echo $row['response_date']; ?>)<br>
    <?php echo $row['text']; ?>
  </li>
<?php
}
?>
</ul>
</body>
</html>
