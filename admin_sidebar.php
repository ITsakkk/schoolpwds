<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="sidebar bg-dark-subtle">
        <div class="top-bar rounded-bottom bg-primary">
            <a href="admin_dashboard.php" class="biu-logo fs-2 font-weight-bold">
                BELTEI
            </a>
        </div>
        <ul class="nav flex-column pt-3">
            <li class="nav-item">
                <a class="nav-link fs-6 fw-bold text-primary active" href="admin_dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6 fw-bold text-primary" href="display_lecturer.php">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Lecturer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6 fw-bold text-primary" href="display_student.php">
                    <i class="fas fa-user-graduate me-2"></i>Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-primary fs-6 fw-bold" href="display_shecdule.php"><i
                        class="fas fa-calendar-alt me-2"></i> Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6 fw-bold text-primary" href="display_program.php">
                    <i class="fas fa-graduation-cap me-2"></i>Program</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6 fw-bold text-primary" href="display_subject.php">
                    <i class="fas fa-book-open me-2"></i>Subjects</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-primary fs-6 fw-bold" href="display_faculty.php">
                    <i class="fas fa-university me-2"></i>Faculties</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-primary fs-6 fw-bold" href="display_major.php">
                    <i class="fas fa-graduation-cap me-2"></i>Majors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-primary fs-6 fw-bold" href="display_resource.php">
                    <i class="fas fa-database me-2"></i>Resource</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-primary fs-6 fw-bold" href="display_resourcetype.php">
                    <i class="fas fa-cube me-2"></i>Resource Type</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-primary fs-6 fw-bold" href="#">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout</a>
            </li>
        </ul>
    </div>
</body>

</html>