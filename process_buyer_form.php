<?php
// Include your database connection logic or configuration file here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $buyer_name = $_POST["buyer_name"];
    $aadhar_no = $_POST["aadhar_no"];
    $eb_no = $_POST["eb_no"];
    $phone_no = $_POST["phone_no"];

    // Generate a unique hashed ID for the buyer
    $buyer_id = hash('sha256', uniqid());

    // Store data in the buyers table
    $sql = "INSERT INTO buyers (buyer_id, buyer_name, aadhar_no, eb_no, phone_no) VALUES ('$buyer_id', '$buyer_name', '$aadhar_no', '$eb_no', '$phone_no')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Redirect to the bidding page with the buyer ID
        header("Location: bidding.php?buyer_id=$buyer_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
