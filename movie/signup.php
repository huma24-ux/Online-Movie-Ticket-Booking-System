<?php
include 'connect.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $password = $_POST['password'] ?? '';
    $terms = $_POST['terms'] ?? '';

    // Server-side validation
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if ($age < 1 || $age > 150) {
        $errors[] = "Age must b~e between 1 and 150.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($terms)) {
        $errors[] = "You must agree to the Terms & Conditions.";
    }

    // Check if email already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email is already registered.";
        }
        $stmt->close();
    }

    // If no errors, insert user
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, age) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $full_name, $email, $hashed_password, $age);

        if ($stmt->execute()) {
            // Redirect to login or dashboard
            header("Location: login.php?registered=1");
            exit;
        } else {
            $errors[] = "Database error: Could not register user.";
        }

        $stmt->close();
    }
}

?>

<!-- Show errors if any -->
<?php if (!empty($errors)): ?>
<div class="alert alert-danger" style="max-width: 400px; margin: 20px auto;">
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- Include your signup form HTML here or redirect back -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Stylesheets & Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                            </a>
                            <h3>Sign Up</h3>
                        </div>

                        <form action="signup.php" method="POST" novalidate>
                            <div class="form-floating mb-3">
                                <input type="text" name="full_name" class="form-control" id="floatingFullName" placeholder="John Doe" required>
                                <label for="floatingFullName">Full Name</label>
                                <div class="invalid-feedback">Please enter your full name.</div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
                                <label for="floatingEmail">Email address</label>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" name="age" class="form-control" id="floatingAge" placeholder="Age" min="1" max="150" required>
                                <label for="floatingAge">Age</label>
                                <div class="invalid-feedback">Please enter a valid age.</div>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required minlength="6">
                                <label for="floatingPassword">Password</label>
                                <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="termsCheck" name="terms" required>
                                <label class="form-check-label" for="termsCheck">I agree to the <a href="#">Terms & Conditions</a></label>
                                <div class="invalid-feedback">You must agree before submitting.</div>
                            </div>

                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>

                            <p class="text-center mb-0">Already have an Account? <a href="login.php">Sign In</a></p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and validation script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Bootstrap form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('form')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>
