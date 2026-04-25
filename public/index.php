<?php
$conn = mysqli_connect("localhost", "root", "", "dbstudents");


if (isset($_POST['save'])) {
    $n = $_POST['name']; $s = $_POST['surname']; $m = $_POST['middlename'];
    $a = $_POST['address']; $c = $_POST['contact'];
    mysqli_query($conn, "INSERT INTO students (name, surname, middlename, address, contact_number) VALUES ('$n', '$s', '$m', '$a', '$c')");
    header("Location: index.php?status=success");
}


if (isset($_POST['update'])) {
    $id = $_POST['id']; $n = $_POST['name']; $s = $_POST['surname']; $m = $_POST['middlename'];
    mysqli_query($conn, "UPDATE students SET name='$n', surname='$s', middlename='$m' WHERE id=$id");
    header("Location: index.php");
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM students WHERE id=$id");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <img src="logo.svg" id="logo" onclick="hideContent()" alt="Logo">
        <button class="navbarbuttons" onclick="showSection('create')"> Create </button>
        <button class="navbarbuttons" onclick="showSection('read')"> Read </button>
        <button class="navbarbuttons" onclick="showSection('update')"> Update </button>
        <button class="navbarbuttons" onclick="showSection('delete')"> Delete </button>
    </nav>

    <section id="home" class="homecontent"> 
        <h1 class="splash">Student Management System</h1>
    </section>
    
    <section id="create" class="content" style="display:none;">
        <h1 class="contenttitle">Insert Student</h1>
        <form method="POST">
            <label class="label">Surname</label><input type="text" name="surname" class="field" required><br>
            <label class="label">Name</label><input type="text" name="name" class="field" required><br>
            <label class="label">Middle Name</label><input type="text" name="middlename" class="field"><br>
            <label class="label">Address</label><input type="text" name="address" class="field"><br>
            <label class="label">Contact</label><input type="text" name="contact" class="field"><br>
            <div id="btncontainer">
                <button type="button" class="btns" onclick="clearFields()">Clear Fields</button>
                <button type="submit" name="save" class="btns">Save</button>
            </div>
        </form>   
    </section>

    <section id="read" class="content" style="display:none;">
        <h1 class="contenttitle">Student List</h1>
        <table border="1" width="100%" style="border-collapse:collapse;">
            <tr><th>ID</th><th>Surname</th><th>Name</th><th>Middle</th></tr>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM students");
            while($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['surname']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['middlename']}</td>
                      </tr>";
            }
            ?>
        </table>
    </section>

    <section id="update" class="content" style="display:none;">
        <h1 class="contenttitle">Update Student</h1>
        <form method="POST">
            <label class="label">ID to Change</label><input type="number" name="id" class="field" required><br>
            <label class="label">New Surname</label><input type="text" name="surname" class="field"><br>
            <label class="label">New Name</label><input type="text" name="name" class="field"><br>
            <label class="label">New Middle</label><input type="text" name="middlename" class="field"><br>
            <button type="submit" name="update" class="btns">Update Record</button>
        </form>
    </section>

    <section id="delete" class="content" style="display:none;">
        <h1 class="contenttitle">Delete</h1>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM students");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<p>{$row['name']} {$row['surname']} <a href='index.php?delete={$row['id']}' style='color:red'>[DELETE]</a></p>";
        }
        ?>
    </section>

    <div id="success-toast" class="toast-hidden" style="display:none; position:fixed; top:20px; right:20px; background:green; color:white; padding:15px;">Registration Successful!</div>
    <script src="script.js"></script>
</body>
</html>
