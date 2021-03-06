<?php include('date.php');
$conn = mysqli_connect('localhost', 'root', '', 'ajax');
if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
}

if (isset($_POST['save'])) {

    $name = $_POST['name'];
    if (strlen($name) <= 3) {
        exit ('');
    }

    $comment = $_POST['comment'];
    if (strlen($comment) <= 3) {
        exit ('');
    }

    $sql = "INSERT INTO comments (name, comment) VALUES ('{$name}', '{$comment}')";

    if (mysqli_query($conn, $sql)) {
        $id = mysqli_insert_id($conn);
        $saved_comment = '<div class="comment_box">
      		<span class="delete" data-id="' . $id . '" >delete</span>
      		<span class="edit" data-id="' . $id . '">edit</span>
      		<div class="display_name">' . $name . '</div>
      	    <div class="display_dt">' . time_elapsed_string($row['dt']) . '</div>
      		<div class="comment_text">' . $comment . '</div>
      		
      	</div>';
        echo $saved_comment;

    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit();
}

// delete comment from database
if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM comments WHERE id=" . $id;
    mysqli_query($conn, $sql);
    exit();
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $sql = "UPDATE comments SET name='{$name}', comment='{$comment}' WHERE id=" . $id;
    if (mysqli_query($conn, $sql)) {
        $id = mysqli_insert_id($conn);
        $saved_comment = '<div class="comment_box">
  		  <span class="delete" data-id="' . $id . '" >delete</span>
  		  <span class="edit" data-id="' . $id . '">edit</span>
  		  <div class="display_name">' . $name . '</div>
  		  <div class="comment_text">' . $comment . '</div>
  	  </div>';
        echo $saved_comment;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit();
}

// retrieve comments from database
$sql = "SELECT * FROM comments";
$result = mysqli_query($conn, $sql);
$comments = '<div id="display_area">';
while ($row = mysqli_fetch_array($result)) {
    $comments .= '<div class="comment_box">
  		  <span class="delete" data-id="' . $row['id'] . '" >delete</span>
  		  <span class="edit" data-id="' . $row['id'] . '">edit</span>
  		  <div class="display_name">' . $row['name'] . '</div> 
  		  <div class="display_dt">' . time_elapsed_string($row['dt']) . '</div>
  		  <div class="comment_text">' . $row['comment'] . '</div>
  	  </div>';
}
$comments .= '</div>';
?>
