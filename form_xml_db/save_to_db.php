<?php
// Parse XML data
$xml = simplexml_load_file('library.xml');

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = ""; // No password
$database = "library";

// connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and insert data into database
foreach ($xml->loan as $loan) {
    $loanId = ($loan->loan_id);
    $loan_amount = ($loan->loan_amount);
    $interest = ($loan->interest);
    $service_fee = $loan->service_fee;



    // Check if book ID already exists in the database
    $checkQuery = "SELECT COUNT(*) AS count FROM loans WHERE loan_id = '$loanId'";
    $checkResult = $conn->query($checkQuery);
    $row = $checkResult->fetch_assoc();
    if ($row['count'] > 0) {
        echo "Error: Duplicate book ID found for book with ID: $loanId. Data was not inserted.";
        continue;
    }

    // Insert data into database
    $sql = "INSERT INTO loans (loanid, loan_amount, interest, service_fee, ) VALUES ('$loan_Id', '$loan_amount', '$interest', '$service_fee')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();

// Redirect back to the HTML page
header("Location: form.html");
exit();
?>
