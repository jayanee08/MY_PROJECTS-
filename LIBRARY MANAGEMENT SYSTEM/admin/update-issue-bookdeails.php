<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['return']))
{
$rid=intval($_GET['rid']);
$fine=$_POST['fine'];
$rstatus=1;
$sql="update tblissuedbookdetails set fine=:fine,RetrunStatus=:rstatus where id=:rid";
$query = $dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->bindParam(':fine',$fine,PDO::PARAM_STR);
$query->bindParam(':rstatus',$rstatus,PDO::PARAM_STR);
$query->execute();

$_SESSION['msg']="Book Returned successfully";
header('location:manage-issued-books.php');

}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include('includes/head.php');?>
<script>
// function for get student name
function getstudent() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_student.php",
data:'studentid='+$("#studentid").val(),
type: "POST",
success:function(data){
$("#get_student_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

//function for book details
function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script> 
<style type="text/css">
  .others{
    color:red;
}

</style>


</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header1.php');?>
<!-- MENU SECTION END-->
    
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Issued Book Details</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
<div class="panel panel-info">
<div class="panel-heading">
Issued Book Details
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$rid=intval($_GET['rid']);
$sql = "SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnedDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine,tblissuedbookdetails.RetrunStatus from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblissuedbookdetails.id=:rid";
$query = $dbh -> prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                   



<div class="form-group">
<label>Student Name :</label>
<?php echo htmlentities($result->FullName);?>
</div>

<div class="form-group">
<label>Book Name :</label>
<?php echo htmlentities($result->BookName);?>
</div>


<div class="form-group">
<label>ISBN :</label>
<?php echo htmlentities($result->ISBNNumber);?>
</div>

<div class="form-group">
<label>Book Issued Date :</label>
<?php echo htmlentities($result->IssuesDate);?>
</div>


<div class="form-group">
<label>Book Returned Date :</label>
<?php if($result->ReturnDate=="")
                                            {
                                                echo htmlentities("Not Return Yet");
                                            } else {


                                            echo htmlentities($result->ReturnDate);
}
                                            ?>
</div>

<div class="form-group">
<label>Fine (in Rs) :</label>
<?php 
if($result->fine=="")
{?>
<input class="form-control" type="text" name="fine" id="fine"  required />

<?php }else {
echo htmlentities($result->fine);
}
?>
</div>
 <?php if($result->RetrunStatus==0){?>

<button type="submit" name="return" id="submit" class="btn btn-info">Return Book </button>

 </div>

<?php }}} ?>
                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer1.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">	</script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
	
	<!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

</body>
</html>
<?php } ?>
