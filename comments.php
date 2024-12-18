<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '12345678', 'book');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $sql = "DELETE FROM book WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Comment deleted successfully!'); window.location.href='comments.php';</script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Invalid ID.";
    }
}

// Handle edit
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM book WHERE id = $id");
    $row = $result->fetch_assoc();
    if ($row) {
        $name = $row['name'];
        $email = $row['email'];
        $comments = $row['comments'];
    } else {
        echo "Record not found!";
    }
}

// Handle form submission to update comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $updated_name = $_POST['name'];
    $updated_email = $_POST['email'];
    $updated_comments = $_POST['comments'];

    // Sanitize inputs to avoid SQL injection
    $updated_name = $conn->real_escape_string($updated_name);
    $updated_email = $conn->real_escape_string($updated_email);
    $updated_comments = $conn->real_escape_string($updated_comments);

    // Update the record in the database
    $sql = "UPDATE book SET name='$updated_name', email='$updated_email', comments='$updated_comments' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Comment updated successfully!'); window.location.href='comments.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Comments</title>

    <!-- CDN links for Bootstrap and AOS (Animate on Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Q0V5hEv2Hgs58tbIoXy/5dNvxjl3FqfEzOlR//J9g2zT0T8zjwMIBfoLwA6wvAWd" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            
            text-align: center;
            color: #444;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-family: Baskerville;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-family: Baskerville;
        }

        table th {
            background-color: #11203f;
            color: white;
        }

        table td {
            background-color: #fafafa;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: white;
            background-color: #28a745;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .form-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        nav {
            background-color: #11203f;
            color: white;
            padding-top: 12px;
            padding-bottom: 12px;
            font-family: Baskerville;
        }

        li {
            font-size: 17px;
        }
        <style>
    h1 {
        font-family: 'Roboto', sans-serif;
        color: #11203f;
    }
    .card {
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .btn-sm {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }


        /* Responsive Styling */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px;
            }
            
            h1 {
              
                font-size: 2rem;
            }
            
            table th, table td {
                padding: 10px;
            }

            /* Adjust the breadcrumb for mobile */
            nav {
                padding-top: 8px;
                padding-bottom: 8px;
            }

            .breadcrumb {
                flex-direction: column;
                gap: 5px;
            }

            .breadcrumb-item {
                font-size: 0.9rem;
                margin-bottom: 5px;
            }

            .breadcrumb-item a {
                font-size: 0.9rem;
            }

            .breadcrumb-item i {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 1024px) {
            nav {
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .breadcrumb {
                gap: 8px;
            }

            .breadcrumb-item a {
                font-size: 1rem;
            }
        }

        @media (min-width: 1025px) {
            nav {
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .breadcrumb {
                gap: 10px;
            }

            .breadcrumb-item a {
                font-size: 1.1rem;
            }

            .breadcrumb-item i {
                font-size: 1.2rem;
            }
        }
        .circle {
    width: 10px;
    height: 10px;
    background-color: #11203f; /* Gold color */
    border-radius: 50%;
    animation: pulse 1.5s infinite;
    margin: auto; /* Centers the circle in the table cell */
}

/* Keyframe for pulsing animation */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.5);
        opacity: 0.5;
    }
}
    </style>
</head>
<body>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="display: flex; gap: 10px; list-style: none; padding: 0; margin: 0;">
    <li class="breadcrumb-item" style="display: inline;">
      <a href="Index.php" style="text-decoration: none; color: white;">
        <i class="bi bi-house-door" style="margin-right: 5px;"></i>Home /
      </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page" style="display: inline; color: white;">
      <i class="bi bi-chat-dots" style="margin-right: 5px;"></i>Comments
    </li>
  </ol>
</nav>

<!-- <h1>View Comments</h1> -->

<!-- Edit Comment Form -->
<?php if (isset($_GET['edit'])): ?>
    <div class="form-container">
        <h2>Edit Comment</h2>
        <form action="comments.php?edit=<?php echo $id; ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" required><?php echo $comments; ?></textarea><br>

            <input type="submit" value="Update Comment">
        </form>
    </div>
<?php endif; ?>

<!-- <table>
    <tr>
    <th></th>
        <th>Name</th>
        <th>Email</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    /*<?php
    //$result = $conn->query("SELECT * FROM book ORDER BY created_at DESC");
    //while ($row = $result->fetch_assoc()) {
      //  echo "<tr>
      //  <td><div class='circle'></div></td>
        //     <td>{$row['name']}</td>
        //     <td>{$row['email']}</td>
        //     <td>{$row['comments']}</td>
        //     <td>{$row['created_at']}</td>
        //     <td>
        //         <a href='comments.php?edit={$row['id']}' class='btn'>Edit</a>
        //         <a href='comments.php?delete={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
        //     </td>
        // </tr>";
    //}
    //?>
</table> -->

<div class="container my-5" style="background-color: #11203f;">
    <h1 class="text-center mb-5" style="color: white;">View Comments</h1>
    <div class="row g-4">
        <?php
        $result = $conn->query("SELECT * FROM book ORDER BY created_at DESC");
        while ($row = $result->fetch_assoc()) {
            echo "
            <div class='col-12'>
                <div class='card h-100 shadow-sm' data-aos='fade-up'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title text-primary'>{$row['name']}</h5>
                        <h6 class='card-subtitle mb-3 text-muted'>{$row['email']}</h6>
                        <p class='card-text flex-grow-1'>{$row['comments']}</p>
                        <p class='text-muted small'>Date: {$row['created_at']}</p>
                        <div class='mt-3'>
                            <a href='comments.php?edit={$row['id']}' class='btn btn-primary btn-sm me-2'>
                                <i class='bi bi-pencil'></i> Edit
                            </a>
                            <a href='comments.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                                <i class='bi bi-trash'></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS animations
    AOS.init();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS (Animate On Scroll) JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init(); // Initialize animations
</script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- AOS (Animate On Scroll) CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">


</body>
</html>
