<?php

    require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thêm lớp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php
    
    $teacher = '';
    $className = '';
    $classRoom = '';
    $classTime = '';
    $back = 'homead.php';

    if (isset($_POST['className']) && isset($_POST['classRoom']) && isset($_POST['classTime']) && isset($_POST['teacher'])) {

        $teacher = $_POST['teacher'];
        $className = $_POST['className'];
        $classRoom = $_POST['classRoom'];
        $classTime = $_POST['classTime'];
        if (empty($teacher)) {
            $error = 'Please enter teacher name';
        }
        if (empty($className)) {
            $error = 'Please enter your class name';
        }
        if (empty($classRoom)) {
            $error = 'Please enter your class room';
        }
        if (empty($classTime)) {
            $error = 'Please enter your class time';
        }

        else {
            $result = addclass($className, $classRoom, $classTime, $teacher);
            if ($result['code'] == 0){
                 die('<br><br><center><font color="Green" size="5">
                    <a>Thêm lớp thành công, nhấn </a><a href = "addclass.php">vào đây </a><a>để trở lại</a> 
                    </font></center>' );
            }

            else{
                $error = 'An error occured. Please try again later';
            }
        }
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Add Class</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">

                <div class="form-group">
                    <label for="teacher">Tên giảng viên</label>
                    <input value="<?= $teacher ?>" name="teacher" id="teacher" type="text" class="form-control" placeholder="Tên giảng viên">
                </div>

                <div class="form-group">
                    <label for="className">Tên lớp</label>
                    <input value="<?= $className ?>" name="className" id="className" type="text" class="form-control" placeholder="Tên lớp">
                </div>

                <div class="form-group">
                    <label for="classRoom">Phòng học</label>
                    <input value="<?= $classRoom ?>" name="classRoom" id="classRoom" type="text" class="form-control" placeholder="VD: A006">
                </div>
                

                <div class="form-group">
                    <label for="classTime">Thời gian</label>
                    <input value="<?= $classTime ?>" name="classTime" id="classTime" type="text" class="form-control" placeholder="VD: Thứ 2 - Ca 3">
                </div>

                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">Xác nhận</button>
                </div>

                <div>
                   <span>Quay về<a href="homead.php"> trang chủ</a></span>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
