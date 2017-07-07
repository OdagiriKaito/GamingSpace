<html>
<head>
  <script src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">
  </script>
  <style type="text/css">
ul{
  list-style: none;
}


    .subcategory{
      display:none;
    }

    #category-list .category{
      width: 200px;
      padding: 10px;
      display:inline-block;
      border-radius: 5px;
      cursor: pointer;
      border-width: 1px 1px 1px 1px;
      border-style: solid;
      border-color: #000;
    }

    #category-list .subcategory li{
      width: 150px;
      padding: 5px;
      border:1px solid #000;
      border-radius: 5px;
      cursor: pointer;
    }

    #category-list .subcategory a{
      text-decoration: none;
      color: #000;
    }
  #title{
    text-align: center;
  }

  </style>
  <meta charset="UTF-8">
  <script>
  jQuery(function($){
    console.log("Hello World");
    console.log($(document));
    $(document).on('change',':input[name="category"]',categoryChangeEvent)
               .on('click','.category',clickCategory);

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

    function clickCategory(){
      $(this).closest('li').find('.subcategory').slideToggle();
    }

    $(':input[name="category"]').change();
  });
  </script>
</head>
<body>
  <h1 id="title">Gaming Space</h1>
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
     <ul id="category-list">
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
  <li>
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
  </li>
  <?php
  }
  ?>
    </ul>
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
<div id="footer">
&copy; 2017　小田桐　魁人
</div>
 </ul>
</body>
</html>
