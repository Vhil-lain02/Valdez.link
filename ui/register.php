<?php
include_once 'connectdb.php';
session_start();



if(isset($_POST['btnsave'])) {

    $username = $_POST['txtname'];
    $usergender = $_POST['txtgender'];
    $userage = $_POST['txtage'];
    $useraddress = $_POST['txtaddress'];
    $usercontact = $_POST['txtcontact'];
    $useremail = $_POST['txtemail'];
    $userpassword = $_POST['txtpassword'];
    $userconfirm_password = $_POST['txtconfirm_password']; // New line to get confirmation password
    $userrole = $_POST['txtrole'];
  

    // Age Restriction
    if($userage < 18) {
        $_SESSION['status'] = "Your age is not allowed";
        $_SESSION['status_code'] = "warning";
    } else {
        // Validation: Contact Number
        if(checkDuplicate('usercontact', $usercontact, $pdo)) {
            $_SESSION['status'] = "Contact Number already exists. Use another Contact Number";
            $_SESSION['status_code'] = "warning";
        } else {
            // Validation: Email
            if(checkDuplicate('useremail', $useremail, $pdo)) {
                $_SESSION['status'] = "Email already exists. Create Account with a new Email";
                $_SESSION['status_code'] = "warning";
            } else {
                // Validation: Password
                if(checkDuplicate('userpassword', $userpassword, $pdo)) {
                    $_SESSION['status'] = "Password already exists. Create Account with a new Password";
                    $_SESSION['status_code'] = "warning";
                } else {
                  // Validation: Confirm Password
                  if ($userpassword !== $userconfirm_password) {
                    $_SESSION['status'] = "Password and confirmation password do not match";
                    $_SESSION['status_code'] = "warning";
                } else {
                    // Insert User
                    if(insertUser($pdo, $username, $usergender, $userage, $usercontact, $useraddress, $useremail, $userpassword, $userconfirm_password, $userrole)) {
                        $_SESSION['status'] = "User inserted successfully into the database";
                        $_SESSION['status_code'] = "success";
                    } else {
                        $_SESSION['status'] = "Error inserting the user into the database";
                        $_SESSION['status_code'] = "error";
                    }
                }
            }
        }
    }
  }
}
  
  function checkDuplicate($field, $value, $pdo) {
    $select = $pdo->prepare("SELECT $field FROM tbl_exam WHERE $field = :value");
    $select->bindParam(':value', $value);
    $select->execute();
    $select->rowCount() > 0;
  }
  
  function insertUser($pdo, $username, $usergender, $userage, $useraddress, $usercontact, $useremail, $userpassword, $userrole) {
    $insert = $pdo->prepare("INSERT INTO tbl_exam (username, usergender, userage, useraddress, usercontact, useremail, userpassword, role) VALUES (:name, :gender, :age, :address, :contact, :email, :password, :role)");
    $insert->bindParam(':name', $username);
    $insert->bindParam(':gender', $usergender);
    $insert->bindParam(':age', $userage);
    $insert->bindParam(':address', $useraddress); 
    $insert->bindParam(':contact', $usercontact);
    $insert->bindParam(':email', $useremail);
    $insert->bindParam(':password', $userpassword);
    $insert->bindParam(':role', $userrole);
    $insert->execute();
  

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Page | Virgil V.</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../index.php" class="h1"><b>Registration</b> Page</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="txtname" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="form-group">
            <select class="form-control" name="txtgender" required>
              <option value= "" disabled selected >Select Gender</option>
              <option>Male</option>
              <option>Female</option>
            </select>
      </div>
    
      <div class="input-group mb-3">
          <input type="number" class="form-control" placeholder="Age"  name="txtage" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-users"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Address"  name="txtaddress" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-marker"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="tel" class="form-control" placeholder="Contact"  name="txtcontact" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-book"></span>
            </div>
          </div>
        </div>


        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email"  name="txtemail" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password"  name="txtpassword" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="txtconfirm_password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="form-group">
            <select class="form-control" name="txtrole" required>
              <option value= "" disabled selected >Select Role</option>
              <option>Admin</option>
              <option>User</option>
            
            </select>
      </div>
    

        <div class="row">
            <div class="col-8">
                <a href="../index.php" class="text-center">I already have account</a>
</div>
          <!-- /.col -->
           
          <div class="col-4">

            <button type="submit" class="btn btn-primary btn-block" name="btnsave">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>

<?php
if(isset($_SESSION['status']) && $_SESSION['status']!='')



{

?>

<script>
$(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 5000
    });


      Toast.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      })
    });


</script>



<?php

unset ($_SESSION['status']);
}

?>