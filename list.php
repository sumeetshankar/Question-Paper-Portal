<?php
include 'db.php';
session_start();

// Handle delete request (Admin only)
if (isset($_GET['delete']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $id = intval($_GET['delete']);

    // Get file name first
    $getFileStmt = $conn->prepare("SELECT file_name FROM papers WHERE id = ?");
    $getFileStmt->bind_param("i", $id);
    $getFileStmt->execute();
    $getFileResult = $getFileStmt->get_result();

    if ($getFileResult->num_rows > 0) {
        $fileRow = $getFileResult->fetch_assoc();
        $filePath = "uploads/" . $fileRow['file_name'];

        // Delete file from uploads folder
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete DB entry
        $deleteStmt = $conn->prepare("DELETE FROM papers WHERE id = ?");
        $deleteStmt->bind_param("i", $id);
        $deleteStmt->execute();
        $deleteStmt->close();

        // Redirect after delete to avoid reloading same request
        header("Location: list.php");
        exit;
    }
    $getFileStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Question Papers - Question Paper Portal</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #007bff, #6f42c1);
        }
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
            padding: 40px 20px;
            max-width: 1100px;
            margin: 0 auto;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        footer {
            box-shadow: 0 -2px 4px rgba(0,0,0,0.2);
        }
        h2 {
            font-weight: 700;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        /* Search form styles */
        form.form-inline {
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        form.form-inline .form-control, form.form-inline button {
            margin: 5px 10px;
            min-width: 150px;
        }

        /* Table styling */
        table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        thead {
            background: #343a40;
            color: white;
        }
        thead th {
            font-weight: 600;
            text-align: center;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        tbody td {
            vertical-align: middle;
            text-align: center;
        }

        /* Buttons */
        .btn-download {
            background-color: #28a745;
            color: #fff;
            border-radius: 30px;
            font-weight: 600;
            padding: 6px 14px;
            transition: background-color 0.3s ease;
        }
        .btn-download:hover {
            background-color: #218838;
            color: #fff;
            text-decoration: none;
        }
        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border-radius: 30px;
            font-weight: 600;
            padding: 6px 14px;
            transition: background-color 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #c82333;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>

<body>
<div class="page-wrapper">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.html">📚 Question Paper Portal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Upload Papers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="list.php">View Papers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Info</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="content">
        <h2 style="color: #FFFFFF;">📝 Available Question Papers</h2>

        <!-- Search Form -->
        <form method="get" class="form-inline">
            <select name="branch" class="form-control">
                <option value="">All Branches</option>
                <option value="Computer Science" <?php if (isset($_GET['branch']) && $_GET['branch'] === 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                <option value="Information and Science" <?php if (isset($_GET['branch']) && $_GET['branch'] === 'Information and Science') echo 'selected'; ?>>Information and Science</option>
                <option value="Electronics and Communication" <?php if (isset($_GET['branch']) && $_GET['branch'] === 'Electronics and Communication') echo 'selected'; ?>>Electronics and Communication</option>
                <option value="Mechanical" <?php if (isset($_GET['branch']) && $_GET['branch'] === 'Mechanical') echo 'selected'; ?>>Mechanical</option>
                <option value="Civil" <?php if (isset($_GET['branch']) && $_GET['branch'] === 'Civil') echo 'selected'; ?>>Civil</option>
            </select>

            <select name="year" class="form-control">
                <option value="">All Years</option>
                <option value="1st Year" <?php if (isset($_GET['year']) && $_GET['year'] === '1st Year') echo 'selected'; ?>>1st Year</option>
                <option value="2nd Year" <?php if (isset($_GET['year']) && $_GET['year'] === '2nd Year') echo 'selected'; ?>>2nd Year</option>
                <option value="3rd Year" <?php if (isset($_GET['year']) && $_GET['year'] === '3rd Year') echo 'selected'; ?>>3rd Year</option>
                <option value="4th Year" <?php if (isset($_GET['year']) && $_GET['year'] === '4th Year') echo 'selected'; ?>>4th Year</option>
            </select>

            <input type="text" name="subject" placeholder="Subject" class="form-control" value="<?php echo isset($_GET['subject']) ? htmlspecialchars($_GET['subject']) : ''; ?>">

            <button type="submit"  class="btn btn-primary">Search</button>
        </form>

        <!-- Papers Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Branch</th>
                        <th>Year</th>
                        <th>Subject</th>
                        <th>Upload Date</th>
                        <th>Download</th>
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Build WHERE clause with prepared statement parameters
                    $where = [];
                    $params = [];
                    $types = "";

                    if (!empty($_GET['branch'])) {
                        $where[] = "branch = ?";
                        $params[] = $_GET['branch'];
                        $types .= "s";
                    }
                    if (!empty($_GET['year'])) {
                        $where[] = "year = ?";
                        $params[] = $_GET['year'];
                        $types .= "s";
                    }
                    if (!empty($_GET['subject'])) {
                        $where[] = "subject LIKE ?";
                        $params[] = "%" . $_GET['subject'] . "%";
                        $types .= "s";
                    }

                    $sql = "SELECT * FROM papers";
                    if (count($where) > 0) {
                        $sql .= " WHERE " . implode(" AND ", $where);
                    }
                    $sql .= " ORDER BY upload_date DESC";

                    $stmt = $conn->prepare($sql);

                    if (count($params) > 0) {
                        $bind_names[] = $types;
                        for ($i = 0; $i < count($params); $i++) {
                            $bind_names[] = &$params[$i];
                        }
                        call_user_func_array([$stmt, 'bind_param'], $bind_names);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['branch']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['upload_date']) . "</td>";
                            echo "<td><a href='uploads/" . htmlspecialchars($row['file_name']) . "' download class='btn btn-download btn-sm'>Download</a></td>";

                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                                echo "<td>
                                    <a href='?delete=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this paper?')\" class='btn btn-delete btn-sm'>Delete</a>
                                </td>";
                            }

                            echo "</tr>";
                        }
                    } else {
                        $colspan = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? 6 : 5;
                        echo "<tr><td colspan='{$colspan}'>No papers found.</td></tr>";
                    }

                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-1">&copy; 2025 Question Paper Portal. All rights reserved.</p>
            <p class="mb-0">Developed by Sumeet Shankar</p>
        </div>
    </footer>

</div> <!-- End page-wrapper -->

<!-- Bootstrap JS dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
