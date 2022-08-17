<?php
$insert = false;
$delete = false;
$update = false;

// INSERT INTO `notes` (`Serial_number`, `Title`, `Discription`, `tstamp`) VALUES (NULL, 'Buy books', 'Please do buy books from the store', current_timestamp());

// Connect with the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if (!$conn){
die("Connection Failed:". mysqli_connect_error());
}
if (isset($_GET['delete'])){
$sno = $_GET['delete'];
$delete = true;
$sql = "DELETE FROM `notes` WHERE `Serial_Number` = $sno";
// echo $sql;
// die("deleted successfully");
$result = mysqli_query($conn, $sql);
if ($delete){
echo "Successfully deleted";
}
else{
echo "Unable to delete";
}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset($_POST['snoEdit'])){
// echo "yes";
// Update the record
$sno = $_POST['snoEdit'];
$title = $_POST['titleEdit'];
$discription = $_POST['discriptionEdit'];

$sql = "UPDATE `notes` SET `Title` = '$title',`discription` = '$discription' WHERE `notes`.`Serial_Number` = $sno";
$result = mysqli_query($conn,$sql);
if($result){
$update = true;
}



}
else{
$title = $_POST['title'];
$discription = $_POST['discription'];

$sql = "INSERT INTO notes(title, discription) VALUES('$title', '$discription')";
$result = mysqli_query($conn,$sql);


if ($result){
//echo "record has been added successfully";
$insert = true;
}
else{
echo "record is not added due to ". mysqli_error($conn);
}
}
}

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Project-1 PHP CRUD</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src ="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>





</head>
<body>
<!--edit Modal-->
<!-- edit modal -->
<!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button>  -->

<!-- edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="editModalLabel">Edit Note</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action = "/crud/index.php" method = "post">

<!-- hidden type is taken for the purpose to update query -->
<input type = "hidden" name = "snoEdit" id = "snoEdit">
<div class="mb-3 my-3">
<!-- <h2> Add a note</h2> -->
<label for="title" class="form-label">Note Title </label>
<input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">

</div>
<div class="mb-3">
<label for="discriptionEdit" class="form-label">Note Discription</label>
<textarea class="form-control" id="discriptionEdit" name="discriptionEdit" rows="3"></textarea>
</div>
<button type="submit" class="btn btn-primary">Update note</button>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button>
</div>
</div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
<a class="navbar-brand" href="#">PHP CRUD</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="#">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">About</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#">Contact</a>
</li>
<!-- <li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
Dropdown
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Action</a></li>
<li><a class="dropdown-item" href="#">Another action</a></li>
<li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="#">Something else here</a></li>
</ul>
</li>
<li class="nav-item">
<a class="nav-link disabled">Disabled</a>
</li> -->
</ul>
<form class="d-flex" role="search">
<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success" type="submit">Search</button>
</form>
</div>
</div>
</nav>
<?php
if ($insert){
echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been inserted successfully.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
<?php
if ($update){
echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been updated successfully.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
<?php
if ($delete){
echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been deleted successfully.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

  <div class="container">
    <form action = "/crud/index.php?update = true" method = "post" name = "myForm" onsubmit = "return validateForm()">
      <div class="mb-3 my-3">
      <h2> Add a note</h2>
      <label for="title" class="form-label">Note Title </label>
      <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"><!-- required attribute to use make from validation -->

      </div>
      <div class="mb-3">
      <label for="discription" class="form-label">Note Discription</label>
      <textarea class="form-control" id="discription" name="discription" rows="3"></textarea>
      </div>
    <button type="submit" value = "Submit" class="btn btn-primary">Add a note</button>
    </form>
</div>
<div class="container">

<table class="table" id = "myTable">
<thead>
<tr>
<th scope="col">Serial number</th>
<th scope="col">Title </th>
<th scope="col">Discription</th>
<th scope="col">Actions</th>
</tr>
</thead>
<tbody>

<?php
$sql = "SELECT * FROM `notes`";
$result = mysqli_query($conn, $sql);
$sno = 0;

// fetching associate arrays with method mysqli_fetch_assoc($result);

while($row = mysqli_fetch_assoc($result)){
$sno = $sno + 1;
$serial_number= $row['Serial_Number'];
// echo $serial_number;
// print_r($row);die("");
echo " <tr>
<th scope='row'>". $sno ."</th>
<td>". $row['Title']."</td>
<td>". $row['Discription']."</td>
<td> <button class = 'edit btn btn-sm btn-primary' id =". $serial_number."> Edit </button> <button class = 'delete btn btn-sm btn-primary' id =  ". $serial_number."> Delete </button> </td>
</tr>";

}
?>

</tbody>
</table>
</div>
<hr>
<!-- jquery Single function call to use datatable -->
<script>
$(document).ready( function () {
$('#myTable').DataTable();
} );
</script>
<script>
edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element)=>{
element.addEventListener("click", (e)=>{
console.log("edit",);
tr = e.target.parentNode.parentNode;
title = tr.getElementsByTagName("td")[0].innerText;
discription=tr.getElementsByTagName("td")[1].innerText;
console.log(title, discription);
titleEdit.value = title;
discriptionEdit.value = discription;
snoEdit.value = e.target.id;
console.log(e.target.id)

// how to toggle modal using javascript

$('#editModal').modal('toggle');

})
})

deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element)=>{
element.addEventListener("click", (e)=>{
// debugger
// console.log() is used to print the code in console;
console.log("edit",);
sno = e.target.id;
// while using 'delete' operation we have to use confirm function;
if (confirm("Press a Button!")){
console.log("Yes");
window.location = `/crud/index.php?delete=${sno}`;
}
else{
console.log("No");
}
})
})

</script>
<!-- Validating form using javascript -->
<script>
function validateForm() {
let x = document.forms["myForm"]["title"].value;
if (x == "") {
alert("Name must be filled out");
return false;
}
}
</script>
<!-- Cleared form using javascript -->
<script>
document.getElementById("myForm").reset();
</script>

</body>
</html>