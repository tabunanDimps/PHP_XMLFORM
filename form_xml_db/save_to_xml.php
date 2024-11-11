<?php
// Get form data
$loanId = $_POST['loan_id'];
$loan_amount = $_POST['loan_amount'];
$interest = $_POST['interest']; // Author is now a single value
$service_fee = $_POST['service_fee'];

// Load existing XML file or create a new one
$xml = file_exists('library.xml') ? simplexml_load_file('library.xml') : new SimpleXMLElement('<library></library>');

// Check if book ID already exists
// $bookExists = false;
// foreach ($xml->book as $book) {
//     if ((string)$book->book_id === $bookId) {
//         $bookExists = true;
//         break;
//     }
// }

$bookExists = false;
foreach ($xml->loans as $loans) {
    if ((string)$loans->loan_id === $loanId) {
        $loanExists = true;
        break;
    }
}
// If book ID already exists, display warning message and redirect
if ($loansExists) {
    echo "<script>alert('Loan ID already exists. Data was not saved.'); window.location.href = 'form.html';</script>";
    exit();
}

// Add new book to XML
$loan = $xml->addChild('loan');
$loan->addChild('loan_id', $loanId); // Add book ID
$loan->addChild('loan_amount', $loan_amount);
$loan->addChild('interest', $interest);
$loan->addChild('service_fee', $service_fee);

// Save XML to file
$xml->asXML('library.xml');

// Display success message and redirect
echo "<script>alert('Loan successfully saved.'); window.location.href = 'save_to_db.php';</script>";
exit();
?>
