<?php
// Include your database connection logic or configuration file here

// Fetch data from the transactions table
$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Logbook</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Transaction ID</th><th>Buyer ID</th><th>Seller ID</th><th>Status</th></tr>";

    // Display data in the logbook table
    while ($row = $result->fetch_assoc()) {
        $transaction_id = $row['transaction_id'];
        $buyer_id = $row['buyer_id'];
        $seller_id = $row['seller_id'];
        $status = $row['status'];

        echo "<tr><td>$transaction_id</td><td>$buyer_id</td><td>$seller_id</td><td>$status</td></tr>";
    }

    echo "</table>";
} else {
    echo "No transactions in the logbook.";
}
?>
