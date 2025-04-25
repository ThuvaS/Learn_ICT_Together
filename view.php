<?php
include 'config.php';
$result = mysqli_query(mysql: $mysqli, query:"SELECT * FROM register ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <h2 style="margin-left:700px;">View page</h2>
    <center><table width="80%" border="0">
        <tr bgcolor="#DDDDDD">
            <td><strong>User Name</strong></td>
            <td><strong>Email</strong></td>
            <td><strong>Password</strong></td>
            <td><strong>Action</strong></td>
        </tr>
        <?php
        while ($res = mysqli_fetch_assoc(result:$result)) {
            echo "<tr>";
            echo "<td>" . $res['username'] . "</td>";
            echo "<td>" . $res['email'] . "</td>";
            echo "<td>" . $res['password'] . "</td>";
            echo "<td><a href=\"edit.php?id=" . $res['id'] . "\">Edit</a> | 
            <a href=\"delete.php?id=" . $res['id'] . "\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table></center>

</body>
</html>
