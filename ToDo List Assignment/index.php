<?php 
	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todolist");

	// add item
	if (isset($_POST['submit'])) {
		$task = $_POST['title'];
		$description = $_POST['description'];
		$sql = "INSERT INTO todoitems (`Title`, `Description`) VALUES ('$task', '$description')";
		mysqli_query($db, $sql);
		header('location: index.php');
	}
	// delete item
	if (isset($_GET['del_task'])) {
		$itemNum = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM todoitems WHERE ItemNum=".$itemNum);
		header('location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>ToDo List</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h2>ToDo List</h2>
	<form method="post" action="index.php" class="input_form">
		<input type="text" name="title" placeholder="Title">
		<input type="text" name="description" placeholder="Description">
		<button type="submit" name="submit" id="add_button" class="add_button">Add Item</button>
		<?php if (isset($errors)) { ?>
		<p><?php echo $errors; ?></p>
		<?php } ?>
	</form>

	<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Tasks</th>
			<th>Description</th>
			<th style="width: 60px;">Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$todoitems = mysqli_query($db, "SELECT * FROM todoitems");

		$i = 1; while ($row = mysqli_fetch_array($todoitems)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="title"> <?php echo $row['Title']; ?> </td>
				<td class="description"> <?php echo $row['Description']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['ItemNum'] ?>">x</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>
</body>
</html>