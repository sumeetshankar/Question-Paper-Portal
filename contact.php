<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact - Question Paper Portal</title>

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
            max-width: 800px;
            margin: 0 auto;
            color: #333;
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
            text-align: center;
            color: #343a40;
        }
        .contact-info {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .contact-info p {
            margin-bottom: 15px;
        }
        .contact-info strong {
            color: #007bff;
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
                        <a class="nav-link" href="list.php">View Papers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="content">
        <h2 style="color: #FFFFFF;">👤 Contact Information</h2>

        <div class="contact-info">
            <p><strong>Name:</strong> Sumeet Shankar</p>
            <p><strong>Email:</strong> <a href="mailto:sumeetms146@gmail.com">sumeetms146@gmail.com</a></p>
            <p><strong>Phone:</strong> +91 96866 65898</p>
            <p><strong>Address:</strong> Bangalore Institute of Technology, Bengaluru, India</p>
            <p><strong>GitHub:</strong> <a href="https://github.com/sumeetshankar" target="_blank" rel="noopener noreferrer">github.com/sumeetshankar</a></p>
            <p><strong>LinkedIn:</strong> <a href="https://linkedin.com/in/sumeet-shankar-65237a259" target="_blank" rel="noopener noreferrer">linkedin.com/in/sumeetshankar</a></p>
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
