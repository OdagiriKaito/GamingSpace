<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>PHP TEST</title>
</head>
<body>

<?php

$db=new PDO('mysql:host=localhost;dbname=underground','root');

$sql='select * from category';
$stmt =$db->query($sql);

$result=$stmt->fetchAll();
?>

<form action="/thread_result.php" method="post">
<table border="0" cellspacing="1" width="" class="form-table">
<tbody>
  <tr>
    <td colspan="2">
     カテゴリを選択</br>
      <select name="category">
<?php
foreach($result as $row){
?>
<option value="<?php echo $row['id'] ?>"><?php echo $row['category_name'] ?></option>
<?php
}
 ?>
<!--  <option value="カテゴリー1">ニュース</option>
      <option value="カテゴリー2">雑談</option>
      <option value="カテゴリー3">実況</option>
      <option value="カテゴリー１">国際情勢</option>
-->
</select>
<select name="subcategory">
<?php
$sql='select * from subcategory';
$stmt =$db->query($sql);
$result=$stmt->fetchAll();
foreach($result as $row){
?>
<option value="<?php echo $row['id'] ?>">
  <?php echo $row['category_name'] ?>
</option>
<?php
}
?>
</select>

    </td>
  </tr>
  <tr>
    <td nowrap="" align="right" width="">
  タイトル：</td><td><input name="subject" size="40" value="">&nbsp; &nbsp;
    <input type="submit" name="submit" value="新規スレッド書込"></td></tr>
<tr><td nowrap="" align="right" width="">
  名 前：</td><td nowrap=""><input name="FROM" size="19" value="">&nbsp;
    E-mail：<input name="mail" size="19" value=""></td></tr>
<tr><td nowrap="" align="right" valign="top">
  内 容：</td><td><textarea rows="5" cols="60" wrap="OFF" name="MESSAGE" style="margin:3px;">
  </textarea><br>
	<label>
    <input type="checkbox" onclick="this.form.MESSAGE.style.cssText = this.checked ? &quot;width: 90%; height: 15em; font-family: sans-serif; font-size: 1em;&quot; : &quot;&quot;;">
    AAモード</label></td></tr>
<tr>
  <td colspan="2">
    <button type="submit">新規スレッド作成</button>
  </td>
</tr>
</tbody>
</table>
</form>
<div id="footer">
&copy; 2017　小田桐　魁人
</div>
</body>
</html>
