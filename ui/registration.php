
<?php

include_once 'connectdb.php';
session_start();


if($_SESSION['useremail'] ==""OR $_SESSION['role'] =="User"){

    header('location:../index.php');
    
    }
  
  
    if($_SESSION['role'] =="Admin"){
  
      include_once "header.php";
    }else{
  
  include_once "headeruser.php";
  
    }

error_reporting(0);

  $id=$_GET['id'];

    if(isset($id)){

    $delete=$pdo->prepare("delete from tbl_user where userid =".$id);

    if($delete->execute()){
      $_SESSION['status']="Account deleted successfully";
      $_SESSION['status_code']="success";

    }else{
      $_SESSION['status']="Account deletion failed";
      $_SESSION['status_code']="warning";

 }
}



// <!-- Registration.Form -->
if(isset($_POST['btnsave'])) {

  $username = $_POST['txtname'];
  $usergender = $_POST['txtgender'];
  $userage = $_POST['txtage'];
  $useraddress = $_POST['txtaddress'];
  $usercontact = $_POST['txtcontact'];
  $useremail = $_POST['txtemail'];
  $userpassword = $_POST['txtpassword'];
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
                  // Insert User
                  if(insertUser($pdo, $username, $usergender, $userage, $useraddress, $usercontact, $useremail, $userpassword, $userrole)) {
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

function checkDuplicate($field, $value, $pdo) {
  $select = $pdo->prepare("SELECT $field FROM tbl_user WHERE $field = :value");
  $select->bindParam(':value', $value);
  $select->execute();
  return $select->rowCount() > 0;
}

function insertUser($pdo, $username, $usergender, $userage, $usercontact, $useraddress, $useremail, $userpassword, $userrole) {
  $insert = $pdo->prepare("INSERT INTO tbl_user (username, usergender, userage, useraddress, usercontact, useremail, userpassword, role) VALUES (:name, :gender, :age, :address, :contact, :email, :password, :role)");
  $insert->bindParam(':name', $username);
  $insert->bindParam(':gender', $usergender);
  $insert->bindParam(':age', $userage);
  $insert->bindParam(':contact', $usercontact);
  $insert->bindParam(':address', $useraddress);
  $insert->bindParam(':email', $useremail);
  $insert->bindParam(':password', $userpassword);
  $insert->bindParam(':role', $userrole);
  return $insert->execute();
}

?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Registration</h1>
            <ol class="breadcrumb float-sm-left">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Page</li> -->
            </ol>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
             
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

            

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Registration Form</h5>
              </div>
              <div class="card-body">






<div class="row">
<div class="col-md-4">
    
  <form action="" method="post">
    
      <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control"  placeholder="Enter Name" name="txtname" required>
      </div>

      <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="txtgender" required>
              <option value= "" disabled selected >Select Gender</option>
              <option>Male</option>
              <option>Female</option>
              </select>
      </div>

      <div class="form-group">
        <label for="exampleInputAge1">Age</label>
        <input type="number" min="1" class="form-control"  placeholder="Enter Age" name="txtage" required>
      </div>

      <div class="form-group">
        <label for="exampleInputAge1">Address</label>
        <input type="text" class="form-control"  placeholder="Enter Address" name="txtaddress" required>
      </div>

      <div class="form-group">
        <label for="exampleInputcontact1">Contact Number</label>
        <input type="tel" class="form-control"  placeholder="Enter Contact Number" name="txtcontact" required>
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Email Adddress</label>
        <input type="email" class="form-control"  placeholder="Enter Email" name="txtemail" required>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" placeholder="Password" name="txtpassword" required>
      </div>
      
      <div class="form-group">
            <label>Role</label>
            <select class="form-control"name="txtrole" required>
              <option value= "" disabled selected >Select Role</option>
              <option>Admin</option>
              <option>User</option>
            
            </select>
      </div>
    

    <div class="card-footer">
      <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
    </div>
  </form>

</div>







<div class="col-md-8">

<table class ="table table-striped table-hover ">
    <thead>
      <tr>
        <td>#</td>
        <td>Name</td>
        <td>Gender</td>
        <td>Age</td>
        <td>Address</td>       
        <td>Contact</td>
        <td>Email</td>
        <td>Password</td>
        <td>Role</td>
        <!-- <td>Edit</td> -->
        <td>Delete</td>
      </tr>


<?php

$select = $pdo->prepare("select * from tbl_user order by userid ASC");
$select ->execute();

while($row=$select->fetch(PDO::FETCH_OBJ))
{

echo'
<tr>
<td>'.$row->userid.'</td>
<td>'.$row->username.'</td> 
<td>'.$row->usergender.'</td> 
<td>'.$row->userage.'</td> 
<td>'.$row->useraddress.'</td> 
<td>'.$row->usercontact.'</td> 
<td>'.$row->useremail.'</td>
<td>'.$row->userpassword.'</td>
<td>'.$row->role.'</td>



<td>
<a href="registration.php?id='.$row->userid.'" class="btn btn-danger delete-btn" data-id="' .$row->userid.'"> <i class="fa fa-trash-alt"></i></a>
</td>

</tr>';


}

?>




      <tbody>

          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

      </tbody>
      </thead>
</table>
</div>


              </div>



              </div>
            </div>



            

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php

   include_once "footer.php";


   ?>

<?php

if (isset($_SESSION['status']) && $_SESSION['status'] != ''){

?>
  <script>
    Swal.fire({
      icon: '<?php echo $_SESSION['status_code']; ?>',
      title: '<?php echo $_SESSION['status']; ?>'
    });


$(document).ready(function() {
  $('.delete-btn').click(function(e) {
  e.preventDefault();

var userId = $(this).data('id');

Swal.fire({
  title: 'Are you sure?',
  text: 'This action cannot be undone',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d63032',
  confirmButtonText: 'Delete'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = 'registration.php?id=' + userId;
  }
});
});
});


  </script>


<?php

  unset($_SESSION['status']);
  }

?>



