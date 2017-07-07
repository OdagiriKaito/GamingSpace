<!DOCTYPE html>
<html>
<head>
  <title>PHP TEST</title>  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <script src="/js/jquery-3.2.0.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php include_once('header.php')?>
<section id="contents">
  $db=new PDO('mysql:host=localhost;dbname=underground','root');
  $thread_id=$_GET['id'];
  if(!isset($thread_id))
  {
    echo "thread_idがセットされていない";
    return;
  }

  if(isset($_POST['text']))
  {
    $name=$_POST['name'];
    $text=$_POST['text'];
    $res_date=date('Y-m-d H:i:s');

    if(is_uploaded_file($_FILES['upload']['tmp_name']))
    {
      $upload_file='upload/'.basename($_FILES['upload']['tmp_name']);

      $filepath='/Users/matchiya1/bbs/'.$upload_file;
      if(move_uploaded_file($_FILES['upload']['tmp_name'],$filepath))
      {
        echo 'UPLOADファイルの移動に成功';
      }else
      {
        echo 'UPLOADファイルの移動に失敗';
      }
    }
    else {
      echo 'UPLOADファイルなし';
    }
    $query=$db->prepare("insert response(name,response_date,text,thread_id,filename)values(?,?,?,?,?)");
    $query->execute(array($name, $res_date, $text,$thread_id,$upload_file));
  }


  $query=$db->prepare("select * from response where thread_id=? order by response_date asc");
  $query->execute(array($thread_id));
  $result=$query->fetchAll();
?>
<ul id="response-list">
  <?php
    $i = 0;
    foreach($result as $row)
    {
  ?>
  <li>
    <?php echo (++$i). ":" . $row['name']; ?>(<?php echo $row['response_date']; ?>)<br>
    <?php echo $row['text']; ?><br>
    <?php
      if(isset($row['filename']))
      {
        echo'<img src="'.$row['filename'].'">';
      }
    ?>
  </li>
<?php
}
?>
</ul>
<form action="/thread.php?id=<?php echo $thread_id ?>" method="post" enctype="multipart/form-data">
  <p>
  名前：<input type="text" name="name" size="40">
  </p>
  <p>
  書き込み：<br>
  <textarea name="text" rows="4" cols="40"></textarea>
  </p>
  添付ファイル:<input type="file" name="upload">
  <p>
  <input type="submit" value="書き込み"><input type="reset" value="削除">
  </p>
</form>
</section>
<section id="footer">
  &copy; 2017　小田桐　魁人
</section>
</body>
</html>
