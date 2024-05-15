
<?php

include_once 'connectdb.php';
session_start();






include_once "header.php";

if(isset($_POST['btnsave'])){

$category = $_POST['txtcategory'];
$contact = $_POST['txtcontact'];

// if(isset($_POST['txtcategory']) && $_POST['txtcontact']){

// $select=$pdo->prepare("SELECT $category from tbl_supplier where $category = :cat");

// $select->execute();
// if($select->rowCount()>0){

//   $_SESSION['status']="Supplier Aready exists.";
//   $_SESSION['status_code']="warning";

// }else{


//   $select=$pdo->prepare("SELECT $contact from tbl_supplier where $contact = :contact");

//   $select->execute();
//   if($select->rowCount()>0){
  
//     $_SESSION['status']="Contact Aready exists.";
//     $_SESSION['status_code']="warning";
  
//   }else{



if(empty($category)){

    $_SESSION['status'] = "Category Field is Empty"; ;
    $_SESSION['status_code'] = "warning";

}else{


$insert=$pdo->prepare("insert into tbl_supplier (category,contact) values (:cat,:contact)");

$insert -> bindParam(':cat',$category);
$insert -> bindParam(':contact',$contact);

if($insert->execute()){
        $_SESSION['status'] = "Supply Added Successfully";
        $_SESSION['status_code'] = "success";

}else{
        $_SESSION['status'] = "Supply Added Failed";
        $_SESSION['status_code'] = "error";

}}}


if(isset($_POST['btnupdate'])){

    $id = $_POST['txtsupid'];
    $contact = $_POST['txtcontact'];
    $category = $_POST['txtcategory'];


    if(empty($category)){
    
        $_SESSION['status'] = "Supply Field is Empty";
        $_SESSION['status_code'] = "warning";
    
    }else{
    
    $update=$pdo->prepare("update tbl_supplier set category=:cat where supid =".$id);

    $update -> bindParam(':cat',$category);
    
    
            if(empty($contact)){
    
              $_SESSION['status'] = "contact Field is Empty";
              $_SESSION['status_code'] = "warning";
          
          }else{
          
          $update=$pdo->prepare("update tbl_supplier set contact=:contact where supid =".$id);
      
          $update -> bindParam(':contact',$contact);
      
          if($update->execute()){
                  $_SESSION['status'] = "Supply Update Successfully";
                  $_SESSION['status_code'] = "success";
          
          }else{
                  $_SESSION['status'] = "Supply Update Failed";
                  $_SESSION['status_code'] = "error";
            
            
    }}}}


If(isset($_POST['btndelete'])){

$delete=$pdo->prepare("delete from tbl_supplier where supid =".$_POST['btndelete']);

if($delete->execute()){

    $_SESSION['status'] = "Deleted";
    $_SESSION['status_code'] = "success";


}else{

    $_SESSION['status'] = "Delete Failed";
    $_SESSION['status_code'] = "Warning";


}




}else{





}

?>

 
 
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Supplier</h1>
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
      <div class="card card-warning card-outline">
              <div class="card-header">
                <h5 class="m-0">Supply Form</h5>
              </div>
              

              <form action="" method="post">
              <div class="card-body">

<div class="row">

<?php

if(isset($_POST['btnedit'])){

    $select = $pdo->prepare("select * from tbl_supplier where supid =".$_POST['btnedit']);
    $select ->execute();
    
    if($select) {
    $row=$select->fetch(PDO::FETCH_OBJ);

    echo'<div class="col-md-4">
    

    
    <div class="form-group">
        <label for="exampleInputEmail1">Category</label>
        
        <input type="hidden" class="form-control"  placeholder="Enter Category" value ="'.$row->supid .'" name="txtsupid">

        <input type="text" class="form-control"  placeholder="Enter Category" value ="'.$row->category.'" name="txtcategory">

        <input type="contact" class="form-control"  placeholder="Enter Contact" value ="'.$row->contact.'" name="txtcontact">

    </div>



    <div class="card-footer">
    <button type="submit" class="btn btn-info" name="btnupdate">Update</button>
    </div>

    </div>';

    }

}else {

echo'<div class="col-md-4">
    

    
<div class="form-group">
    <label for="exampleInputEmail1">Category</label>
    <input type="text" class="form-control"  placeholder="Enter Category" name="txtcategory">
</div>

<div class="form-group">
    <label for="exampleInputNumber1">Contact</label>
    <input type="contact" class="form-control"  placeholder="Enter Contact" name="txtcontact">
</div>


<div class="card-footer">
<button type="submit" class="btn btn-warning" name="btnsave">Save</button>
</div>

</div>';





}




?>




<div class="col-md-8">

<table id="table_supplier" class ="table table=striped table-hover ">
    <thead>
      <tr>
        <td>#</td>
        <td>Category</td>
        <td>Contact</td>
        <td>Edit</td>
        <td>Delete</td>
      </tr>
    </thead>
    <tbody>
<?php

$select = $pdo->prepare("select * from tbl_supplier order by supid  ASC");
$select ->execute();

while($row=$select->fetch(PDO::FETCH_OBJ))
{

echo'
<tr>
<td>'.$row->supid .'</td>
<td>'.$row->category.'</td> 
<td>'.$row->contact.'</td> 
<td>
<button type="submit" class="btn btn-primary" value ="'.$row->supid .'" name="btnedit">Edit</button>
</td>

<td>
<button type="submit" class="btn btn-danger" value ="'.$row->supid .'" name="btndelete">Delete</button>
</td>

</tr>';


}

?>


  </tbody>

  <tfoot>
  <tr>
        <td>#</td>
        <td>Category</td>
        <td>Contact</td>
        <td>Edit</td>
        <td>Delete</td>
 </tr>

  </tfoot>

</table>
</div>


              </div>

              </form>

            </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  </div>



  <?php

include_once "footer.php";


?>

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

var supId = $(this).data('id');

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
    window.location.href = 'supplier.php?id=' + supId;
  }
});
});
});
  </script>


<?php

  unset($_SESSION['status']);
  }

?>


<script>

$(document).ready( function () {
    $('#table_suppplier').DataTable();
} );

</script>