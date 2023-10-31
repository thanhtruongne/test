<?php
    include_once './connect.php';
    $fullname= '';
    $dateofbirth = '';
    $point = '';
    $output ='';
    $assoc = '';
    if(isset($_POST['Add'])) {
        $fullname = mysqli_escape_string($conn,$_POST['name']);
        $dateofbirth = mysqli_escape_string($conn,$_POST['dateofbirth']);
        $point = mysqli_escape_string($conn,$_POST['point']);
       $sum = 'INSERT INTO hocsinh (fullname,dateofbirth) VALUES ("'.$fullname.'",'.$dateofbirth.')';
       $data = mysqli_query($conn,$sum);
       $point = 'INSERT INTO diem (`diem`) VALUES ('.$point.')';
       $pan = mysqli_query($conn,$point);
        
       
    }
    if(isset($_POST['Edit'])) {
        $fullname = mysqli_escape_string($conn,$_POST['name']);
        $sql = 'SELECT * FROM hocsinh where fullname = "'.$fullname.'"';
        $data = mysqli_query($conn,$sql);
        $array = mysqli_fetch_assoc($data);
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    if(isset($_POST['Reload'])) {
        
    }

    if($_GET['edit']) {
        $sql = 'SELECT h.fullname,h.dateofbirth,d.diem FROM hocsinh h inner join diem d on h.id = d.id where h.id = "'.$_GET['edit'].'"';
        $data = mysqli_query($conn,$sql);
        $assoc = mysqli_fetch_assoc($data); 
    }
   
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>


</head>
<body>

<div class="container">
    <form method="post" action="">
        <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Họ và tên</label>
            <input type="text" value=<?php if(!empty($assoc)) {echo $assoc['fullname'];} ?> name="name" class="form-control" id="exampleFormControlInput1" >
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Ngày sinh</label>
            <input type="text" value= <?php if(isset($assoc)) {echo $assoc['dateofbirth'];} ?> name="dateofbirth" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Điểm</label>
            <input type="text"value=<?php if(isset($assoc)) {echo $assoc['diem'];} ?>  name="point" class="form-control" id="exampleFormControlInput1" >
        </div>
        <input type='submit' value="Thêm" name='Add' class='btn btn-danger'/>
        <input type='submit' value="Sửa" name='Edit' class='btn btn-info'/>
        <input type='submit' value="Làm mói" name='Reload' class='btn btn-secondary'/>
    </form>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">dateofbirth</th>
      <th scope="col">diem</th>
      <th scope="col">hoc luc</th> 
       </tr>
  </thead>
  <tbody>
    <?php
        function dtb($diem) {
            $output = '';
                switch($diem) {
                   case $diem  > 6 :
                   $output = 'Khá';
                   break;
                   case $diem <3 :
                    $output = 'Yếu';
                    break;
                   case $diem <5 :
                    $output = 'Trung bình';
                    break;
                    case $diem > 8 :
                     $output = 'Gioi';
                     break;
                }
                return $output;
        }

        $data = 'SELECT h.id, h.fullname,h.dateofbirth ,d.diem FROM hocsinh h inner join diem d on h.id = d.id';
        $quer = mysqli_query($conn,$data);
    
        while($row = mysqli_fetch_assoc($quer)) {
             echo '
             <tr>
             <th scope="row">'.$row['id'].'</th>
             <td>'.$row['fullname'].'</td>
             <td>'.$row['dateofbirth'].'</td>
            <td>'.$row['diem'].'</td>
            <td>'.dtb($row['diem']).'</td>
            <td>
               <a href="?edit='.$row['id'].'" class="btn btn-danger">Sửa</a>
            </td>
            </tr>
             ';
        }
    ?>
  
  </tbody>
</table>


</div>
    
</body>
</html>