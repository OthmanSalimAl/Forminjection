<?php


$serverName = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "test";

$connection = mysqli_connect($serverName, $usernameDB, $passwordDB, $dbname);

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    if (strlen($name) > 5 && preg_match("/[^0-9]/", $name) && !empty($name)) {
        echo "<br> <h5>The Name Is Valid</h5>";
    } else {
        echo "<br> <h5 style ='color:red'>The Name is Invalid</h5>";
        header("refresh: 4;"); // time intervals after 3 seconds refresh for page
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        echo "<br> <h5>The Email Is Valid</h5>";
    } else {
        echo "<br> <h5 style ='color:red'>The Email Is Invalid</h5>";
        header("refresh: 4;");
    }

    if (strlen($password) > 8 && preg_match("/\w/", $password) && !empty($password)) { //or [a-zA-Z0-9]
        echo "<br> <h5>The Password is Valid</h5>";
    } else {
        echo "<br> <h5 style ='color:red'>The Password is Invalid</h5>";
        header("refresh: 4;");
    }


    if (isset($_POST['checkMe'])) {
        echo "<br> <h5>Checked Remember</h5>";
    } else {
        echo "<br> <h5 style ='color:red' >Not Checked Remember</h5>";
        header("refresh: 4;");
    }

    if (isset($_POST['gender'])) {
        echo "<br> <h5> Clicked Gender</h5>";
    } else {
        echo "<br> <h5 style ='color:red' >Must Select The Gender</h5>";
        header("refresh: 4;");
    }

    //$_FILES['image']['size'] <= 1024 * 1024 && !
    if (empty($_FILES['image']['name'])) {
        echo "<br> <h5 style ='color:red'>Not Found File</h5>";
    } else {
        if ($_FILES['image']['size'] <= 1024 * 1024) {
            echo "<br> <h5>Available Size For File</h5>";
            header("refresh: 4;");
        } else {
            echo "<br> <h5 style ='color:#1589ff'>The Size Of File Greater than 1MB</h5>";
            header("refresh: 4;");
        }
    }

    $sql = "insert into users set name = ?, password = ?, email = ?, gender = ?,fileName = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $_POST['name'], $_POST['password'], $_POST['email'], $_POST['gender'], $_FILES['image']['name']);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result) {
        echo "Completed The user his number (" . mysqli_insert_id($connection) . ")";
    } else {
        echo "Not Completed The user !!";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HW Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top: 30px;">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Name</label>
                <input value="" name="name" type="text" class="form-control" id="exampleInputName1" aria-describedby="nameHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input value="" name="email" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input name="password" value="" type="text" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input name='checkMe' type="checkbox" class="form-check-input" id="exampleCheck1" require>
                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
            </div>

            <div class="form-check">
                <input name="gender" value="1" class="form-check-input" type="radio" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input name="gender" value="2" class="form-check-input" type="radio" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                    Female
                </label>
            </div><br>
            <div class="mb-3">
                <label for="formFileDisabled" class="form-label">Image</label>
                <input name="image" class="form-control" type="file" id="formFileDisabled">
            </div>

            <button name="send" type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>