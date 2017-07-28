<!doctype html>
<html>
<head>
<meta charset="utf-8" />
  <script src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">
  </script>
  <link rel="stylesheet" type="text/css" href="css/reset.css">
  <style type="text/css">
    h1{
      margin: 20px 0;
      font-size: 250%;
      font-family: fantasy;
    }

    ul{
      list-style: none;
    }
    .subcategory{
      display:none;
    }
    body{
        background-color:#FF8800;
        overflow-x: hidden;
    }
    #category-container{
      overflow-x: scroll;
      margin-bottom: 0px;
    }
    #category-list {
      border: 1px solid #000;
      width: 5000px;
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
      width: 138px;
      padding: 5px;
      border:1px solid #000;
      border-radius: 5px;
      cursor: pointer;
      background-color: #00ff7f
    }

    #category-list .subcategory{
          width: 150px;
          position: absolute;
        }

    #category-list .subcategory a{
      text-decoration: none;
      color: #000;
    }
    #title{
      text-align: center;
    }

    #introduction{
      margin: 20px 0;
      font-size: 150%;
      text-align: center;
    }

    #introduction-image{
      height: 420px;
      background: url("./introduction.png") center center no-repeat;
      background-size: contain;
      opacity: 0.5;
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

      var $self = $(this);
      var $subcategory = $self.next('.subcategory');

      if($subcategory.is(':visible')){
        $subcategory.slideToggle();
        return;
      }

      $('.subcategory').hide();

      var left = $self.offset().left + $self.outerWidth() - $subcategory.outerWidth();
      var top = $self.offset().top+$self.outerHeight();

    $subcategory
    .css({
      left:left,
      top:top
    })
    .slideToggle();

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
