<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php
    include("script.php");
    include("connection.php");

    // Initialize arrays to store table names and row counts
    $tables = ["tbllecturer", "tblstudentinfo", "tblschedule", "tblmajor", "tblsubject", "tblresource"];
    $data = [];

    // Fetch row count for each table
    foreach ($tables as $table) {
        // SQL query to count rows in the table
        $sql = "SELECT COUNT(*) AS row_count FROM $table";
        
        // Execute the query
        $result = $conn->query($sql);
        
        // Check if the query was successful
        if ($result) {
            // Fetch the result as an associative array
            $row = $result->fetch_assoc();
            
            // Get the row count
            $data[$table] = $row['row_count'];
        } else {
            // If the query fails, display an error message
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $customLabels = ["Lecturer","Student", "Schedule", "Major", "Subject", "Resource"];
    $conn->close();

    // Define chart background colors dynamically
    $chartColors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(73, 192, 192, 0.2)',
        'rgba(73, 192, 12, 0.2)',
    ];

    // Define icons for each table
    $icons = [
        'tblmajor' => 'fas fa-university', // University icon for major
        'tblsubject' => 'fas fa-book-open', // Book icon for subject
        'tblresource' => 'fas fa-database', // Database icon for resource
        'tbllecturer' => 'fas fa-chalkboard-teacher', // Cube icon for resource type
        'tblstudentinfo' => 'fas fa-users', // Cube icon for resource type
        'tblschedule' => 'fas fa-calendar-alt', // Cube icon for resource type
    ];
    ?>
</head>

<body>
    <!-- sidebar -->
    <?php
    include("admin_sidebar.php");
    ?>
    <!-- end of sidebar -->

    <!-- content -->
    <div class="content px-4 pb-2">
        <div class="row">
            <div class="col-lg-12 rounded-bottom p-3 fs-3 font-weight-bold text-white text-center bg-primary">
                Data Analyst
            </div>
            <div class="col-lg-12 py-3 px-0">
                <div class="row">
                    <?php
                    // Iterate through the data array and create cards for each table
                    foreach ($data as $table => $rowCount) {
                        if (in_array($table, $tables)) {
                            $index = array_search($table, $tables);
                            echo '<div class="col-2">
                                    <div class="card text-center p-1 mb-2" style="background-color: ' . $chartColors[$index] . '; border: 1px solid ' . $chartColors[$index] . ';">
                                        <i class="' . $icons[$table] . ' text-primary fs-2 p-2"></i>
                                        <span class="fs-4">' . $rowCount . '</span>
                                        <span class="text-secondary">' . $customLabels[$index] . '</span>
                                    </div>
                                </div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-12 py-3 px-0">
                <canvas id="rowCountsChart"></canvas>

                <script>
                // Data fetched from PHP
                var tableData = <?php echo json_encode($data); ?>;
                var customLabels = <?php echo json_encode($customLabels); ?>;
                var rowCountData = Object.values(tableData);

                // Create Chart.js instance
                var ctx = document.getElementById('rowCountsChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: customLabels,
                        datasets: [{
                            label: 'Row Counts',
                            data: rowCountData,
                            backgroundColor: <?php echo json_encode($chartColors); ?>,
                            borderColor: <?php echo json_encode($chartColors); ?>,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                </script>
            </div>
        </div>
    </div>
    <!-- end of content -->
</body>

</html>