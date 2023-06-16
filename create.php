<?php
require_once 'config1.php';

$name = $gender = $address = $password = $confirm_password = "";
$name_err = $gender_err = $address_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Xin hãy điền tên.";
    } elseif (!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z'-.\s]+$/")))) {
        $name_err = 'Xin hãy điền tên hợp lệ.';
    } else {
        $name = $input_name;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input_gender = trim($_POST["gender"]);
            if (empty($input_gender)) {
            $gender_err = "Xin hãy chọn giới tính.";
        } else {
            $gender = $input_gender;
        }
    }
    if ($gender !== "Male" && $gender !== "Female") {
        $gender_err = "Xin hãy chọn giới tính hợp lệ.";
    }

    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = 'Xin hãy nhập địa chỉ.';
    } else {
        $address = $input_address;
    }

    $input_password = trim($_POST["password"]);
    if (empty($input_password)) {
        $password_err = "Xin hãy nhập mật khẩu.";
    } else {
        $password = $input_password;
    }

    $input_confirm_password = trim($_POST["confirm_password"]);
    if (empty($input_confirm_password)) {
        $confirm_password_err = "Xin hãy xác nhận mật khẩu.";
    } else {
        $confirm_password = $input_confirm_password;
        if ($password !== $confirm_password) {
            $confirm_password_err = "Mật khẩu xác nhận không khớp.";
        }
    }

    if (empty($name_err) && empty($gender_err) && empty($address_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO user (name, gender, address,password) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_gender, $param_address, $param_password);
            $param_name = $name;
            $param_gender = $gender;
            $param_address = $address;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {
                header("location: index2.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Đăng ký</h2>
                    </div>
                    <p>Đăng ký tài khoản để quản lý đơn hàng và điền thông tin nhanh chóng</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Họ và tên </label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                            <label>Giới tính</label>
                            <select name="gender" class="form-control">
                                <option value="">Chọn giới tính</option>
                                <option value="Male" <?php if ($gender === "Male") echo "selected"; ?>>Nam</option>
                                <option value="Female" <?php if ($gender === "Female") echo "selected"; ?>>Nữ</option>
                            </select>
                            <span class="help-block"><?php echo $gender_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Địa chỉ</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Nhập lại mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="create.php" class="btn btn-default">Cancel</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
