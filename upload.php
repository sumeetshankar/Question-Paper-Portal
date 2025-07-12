<?php
include 'db.php';
session_start();

$admin_password = "sumeet@bit2026";
$error = "";
$success = "";

// Handle login form submission
if (isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['logged_in'] = true;
        header("Location: upload.php"); // Redirect after login to avoid resubmission
        exit;
    } else {
        $error = "Wrong password!";
    }
}

// Handle upload form submission (only if logged in)
if (isset($_POST['submit']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $branch = $_POST['branch'];
    $year = $_POST['year'];
    $subject = $_POST['subject'];

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_name);

    // Check file extension (only pdf)
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_type !== "pdf") {
        $error = "Only PDF files are allowed.";
    } else {
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Use prepared statement to insert data
            $stmt = $conn->prepare("INSERT INTO papers (branch, year, subject, file_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $branch, $year, $subject, $file_name);

            if ($stmt->execute()) {
                $success = "Paper uploaded successfully!";
            } else {
                $error = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Failed to upload the file.";
        }
    }
}

// If user is not logged in, show login form
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true):
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login - Upload Question Paper</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #007bff, #6f42c1);
            margin: 0;
        }
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .upload-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }
        footer {
            box-shadow: 0 -2px 4px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-0">
        <div class="container">
            <a class="navbar-brand" href="index.html">📚 Question Paper Portal</a>
        </div>
    </nav>
    <div class="content">
        <div class="upload-card">
            <h2 class="text-center mb-4">🔐 Admin Login</h2>
            <form method="post" class="form-group">
                <label>Admin Password:</label>
                <input type="password" name="password" required class="form-control mb-3" placeholder="Enter password">
                <input type="submit" name="login" value="Login" class="btn btn-primary btn-block">
            </form>
            <?php if ($error) echo "<p class='text-danger text-center'>$error</p>"; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-0">
        <div class="container">
            <p class="mb-1">&copy; 2025 Question Paper Portal. All rights reserved.</p>
            <p class="mb-0">Developed by Sumeet Shankar</p>
        </div>
    </footer>

</div>

</body>
</html>

<?php
exit;
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upload Question Paper</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #007bff, #6f42c1);
            margin: 0;
        }
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            padding: 20px 15px 40px 15px;
        }
        footer {
            box-shadow: 0 -2px 4px rgba(0,0,0,0.2);
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container">
        <a class="navbar-brand" href="index.html">📚 Question Paper Portal</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="upload.php">Upload Papers</a></li>
            <li class="nav-item"><a class="nav-link" href="list.php">View Papers</a></li>
            <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Info</a>
                    </li>
            <li class="nav-item">
                <a class="nav-link btn btn-danger text-white ml-3" href="index.html">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="content">
        <h2 class="mb-4 text-center" style="color: #FFFFFF;">⬆️ Upload Question Paper</h2>

        <?php if ($error) echo "<p class='text-danger text-center'>$error</p>"; ?>
        <?php if ($success) echo "<p class='text-success text-center'>$success</p>"; ?>

        <div class="form-container">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="form-group">
                <label>Branch:</label>
                <select name="branch" required class="form-control mb-3">
                    <option value="">-- Select Branch --</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information and Science">Information and Science</option></option>
                    <option value="Electronics">Electronics and Communication</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Civil">Civil</option>
                </select>

                <label>Year:</label>
                <select name="year" required class="form-control mb-3">
                    <option value="">-- Select Year --</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>

                <label>Subject:</label>
                <input type="text" name="subject" required class="form-control mb-3" placeholder="Enter Subject Name">

                <label>Select PDF:</label>
                <input type="file" name="file" accept="application/pdf" required class="form-control mb-4">

                <input type="submit" name="submit" value="Upload" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-1">&copy; 2025 Question Paper Portal. All rights reserved.</p>
            <p class="mb-0">Developed by Sumeet Shankar</p>
        </div>
    </footer>

</div> <!-- End page-wrapper -->

</body>
</html>
