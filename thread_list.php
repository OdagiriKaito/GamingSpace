<html>
<head>
  <script src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">
  </script>
  <script>
  jQuery(function($){
    console.log($(document));
    $(document).on('change',':input[name="category"]',categoryChangeEvent);
    function categoryChangeEvent(){
      $self = $(this);
      catId = $self.val();
      console.log($self.val());
      $.ajax('/category.php',{
        data:{
          id: catId
        }
      }).done(function(res){
        $(':input[name="subcategory"]').empty().append($(res).children());
        console.log(res);
      });
    };

    $(':input[name="category"]').change();
  });
  </script>
</head>
<body>
<?php
  $db=new PDO('mysql:host=localhost;dbname=underground','root');
?>
<ul>
<?php
  if($_GET["id"] && $_GET['subcat_id']){
  $sql='select * from thread where cat_id='.$_GET["id"]." and subcat_id=".$_GET['subcat_id'];
  }else{
  $sql='select * from thread';
  }
  $stmt =$db->query($sql);
  $result=$stmt->fetchAll();
  foreach($result as $row){
?>
<li><a href="thread.php?=<?php echo $row['id'] ?>">
  <?php echo $row['title']
  ?>
</a>
</li>
<?php
}
?>
</ul>

</body>
<body>
<li>
  <a href="thread.php?=<?php echo $row['id'] ?>">
  <?php echo $row['title']?>
</a>
</li>
<tr>
  <td nowrap="" align="right" width="">タイトル：</td><td><input name="subject" size="40" value="">&nbsp; &nbsp;
    <input type="submit" name="submit" value="新規スレッド書込"><br></td></tr>
<tr><td nowrap="" align="right" width="">
  名 前：</td><td nowrap=""><input name="FROM" size="19" value="">&nbsp;
    E-mail：<input name="mail" size="19" value=""></td></tr><br>
<tr><td nowrap="" align="right" valign="top">
  内 容：<br></td><td><textarea rows="5" cols="60" wrap="OFF" name="MESSAGE" style="margin:3px;">
  </textarea></td></tr>
<tr>
  <td colspan="2">
    <br><button type="submit">新規スレッド作成</button>
  </td>
</tr>

<form action="/thread_result.php" method="post">
<table border="0" cellspacing="1" width="" class="form-table">
<tbody>
  <tr>
    <td colspan="2">

<ul>
<?php
  if($_GET["id"]){
  $sql='select * from thread where cat_id='.$_GET["id"];
  }else{
  $sql='select * from thread';
  }
  $stmt =$db->query($sql);
  $result=$stmt->fetchAll();
  foreach($result as $row){
?>
<li><a href="thread.php?=<?php echo $row['id'] ?>">
  <?php echo $row['title']
  ?>
</a>
</li>
<?php
}
?>
</ul>
<hr>
<?php
echo  $_GET["id"]
?>
<hr>
    </td>
  </tr>
  <tr>
    <td nowrap="" align="right" width="">
      カテゴリを選択
    </td>
    <td>
      <select name="category">
      <?php
      foreach($categorys as $row){
      ?>
      <option value="<?php echo $row['id'] ?>">
      <?php echo $row['category_name']?>
      </option>
      <?php
      }
      ?>
      </select>
      <br>
      <?php
        $sql='select * from subcategory';
        $stmt =$db->query($sql);
        $subcategorys=$stmt->fetchAll();
      ?>
    </td>
  </tr>
  <tr>
    <td>
      サブカテゴリを選択
    </td>
    <td>
      <select name="subcategory">
      <?php
      foreach($subcategorys as $row){
      ?>
      <option value="<?php echo $row['id'] ?>">
      <?php echo $row['category_name']?>
      </option>
      <?php
      }
      ?>
      </select>
      <br>
  </td>
</tr>
<tr>
  <td nowrap="" align="right" width="">タイトル：</td><td><input name="subject" size="40" value="">&nbsp; &nbsp;
    <input type="submit" name="submit" value="新規スレッド書込"></td></tr>
<tr><td nowrap="" align="right" width="">
  名 前：</td><td nowrap=""><input name="FROM" size="19" value="">&nbsp;
    E-mail：<input name="mail" size="19" value=""></td></tr>
<tr><td nowrap="" align="right" valign="top">
  内 容：</td><td><textarea rows="5" cols="60" wrap="OFF" name="MESSAGE" style="margin:3px;">
  </textarea></td></tr>
<tr>
  <td colspan="2">
    <button type="submit">新規スレッド作成</button>
  </td>
</tr>
</tbody>
</table>
</form>


</body>
</html>
