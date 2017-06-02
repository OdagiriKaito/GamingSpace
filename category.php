<?php
$db=new PDO('mysql:host=localhost;dbname=underground','root');
 ?>
<select>
<?php
$sql='select * from subcategory where cat_id='.$_GET["id"];
$stmt =$db->query($sql);
$categorys=$stmt->fetchAll();
foreach($categorys as $row){
?>
<option value="<?php echo $row['id'] ?>">
<?php echo $row['subcategory_name']
?>
</option>
<?php
}
?>
</select>
