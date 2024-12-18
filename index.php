<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '12345678', 'book');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $comments = $conn->real_escape_string($_POST['comments']);

        $sql = "INSERT INTO book (name, email, comments, created_at) VALUES ('$name', '$email', '$comments', NOW())";
        if ($conn->query($sql)) {
            echo "<script>alert('Comment posted successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
            padding: 0;
            margin: 0;
            animation: fadeIn 1s ease-in-out;
        }

        .container {
            background-image:url("gra.avif");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            max-width: 960px;
            margin: 40px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease-in-out;
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 2rem;
            animation: fadeInUp 1.2s ease-in-out;
            font-family:Baskerville;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: slideIn 0.8s ease-in-out;
        }

        form input, form textarea, form button {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        form input:focus, form textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        form button {
            background-color:#4F7C42;
            color: #FFFFFF;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            font-family:Baskerville;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color:rgb(93, 143, 6);
        }

        .view-btn {
            display: block;
            width: 220px;
            padding: 12px 20px;
            margin: 30px auto;
            text-align: center;
            background-color:#4F7C42;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-family:Baskerville;
            transition: background-color 0.3s ease;
            animation: fadeInUp 1.5s ease-in-out;
        }
        .image-container {
            display: flex;
            justify-content: center;  /* Centers horizontally */
            align-items: center;      /* Centers vertically */
            height: auto;            /* Takes full viewport height */
            background-color: none;
        }

        /* The image style */
        .image-container img {
            max-width: 200px;          /* Makes image responsive */
            height: auto;             /* Maintains aspect ratio */
            border-radius: 50%;       /* Makes image circular */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Adds shadow */
            animation: fadeInUp 1.2s ease-in-out; /* Animation for fade-in */
            margin-bottom:20px;
        }

        /* Keyframes for fade-in animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        
        .view-btn:hover {
            background-color: rgb(93, 143, 6);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

    </style>
</head>
<body>
<div class="container" data-aos="fade-up">
<div class="image-container">
<img src="book.jpg" alt="Book Icon">
    </div>
    <h1>Welcome to My Guestbook</h1>
    <form action="index.php" method="post">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="comments" placeholder="Your Comments" rows="4" required></textarea>
        <button type="submit" name="submit">Submit</button>
    </form>

    <!-- View Comments Button -->
    <a href="comments.php" class="view-btn">View Comments</a>
</div>

<script>
    // Initialize AOS (Animate On Scroll)
    AOS.init();
</script>

</body>
</html>
