<?php
// Include your database connection logic or configuration file here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $selected_sellers = $_POST["selected_sellers"];
    $buyer_id = $_POST["buyer_id"];

    // Generate a unique hashed ID for the transaction
    $transaction_id = hash('sha256', uniqid());

    // Initialize an empty array to store sellers' IDs
    $sellers_ids = [];

    // Process selected sellers
    foreach ($selected_sellers as $seller_id) {
        // Update the status to "trade closed" for the selected seller
        $update_status_sql = "UPDATE transactions SET status = 'trade closed' WHERE buyer_id = '$buyer_id' AND seller_id = '$seller_id' AND status = 'open'";
        $conn->query($update_status_sql);

        // Store seller's ID in the array
        $sellers_ids[] = $seller_id;
    }

    // Store data in the transactions table
    foreach ($sellers_ids as $seller_id) {
        $insert_transaction_sql = "INSERT INTO transactions (transaction_id, buyer_id, seller_id) VALUES ('$transaction_id', '$buyer_id', '$seller_id')";
        $conn->query($insert_transaction_sql);
    }

    echo "<script>alert('Trade successful.');</script>";
} else {
    echo "Invalid request.";
}
?>
