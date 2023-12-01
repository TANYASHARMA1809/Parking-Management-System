<?php
$conn = new mysqli('localhost', 'root', '', 'mini-project');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

$query = "SELECT * FROM slot";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Data</title>
    <style>
        body {
            background: linear-gradient(135deg, #3498db, #2c3e50); /* Gradient background */
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            text-align: center;
            color: #fff;
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #fff;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

<h2>Booking Summary</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Vehicle Number</th>
            <th>Vehicle Type</th>
            <th>Owner Name</th>
            <th>Contact Number</th>
            <th>Parking Slot</th>
            <th>Entry Date</th>
            <th>Entry Time</th>
            <th>Exit Date</th>
            <th>Exit Time</th>
            <th>City</th>
            <th>Amount/bill</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['ID'] ?></td>
                <td><?= $row['VehicleNumber'] ?></td>
                <td><?= $row['VehicleType'] ?></td>
                <td><?= $row['OwnerName'] ?></td>
                <td><?= $row['ContactNumber'] ?></td>
                <td><?= $row['ParkingSlot'] ?></td>
                <td><?= $row['EntryDate'] ?></td>
                <td><?= $row['EntryTime'] ?></td>
                <td><?= $row['ExitDate'] ?></td>
                <td><?= $row['ExitTime'] ?></td>
                <td><?= $row['City'] ?></td>
                <td><?= calculateAmount($row['EntryDate'], $row['EntryTime'], $row['ExitDate'], $row['ExitTime']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>

<?php

function calculateAmount($entryDate, $entryTime, $exitDate, $exitTime) {
    // Add your logic to calculate the amount based on entry and exit details
    // For example, you can calculate the duration and apply a rate
    // return "$20"; // Replace with your calculated amount
    $entryTimestamp = strtotime("$entryDate $entryTime");
    $exitTimestamp = strtotime("$exitDate $exitTime");

    // Calculate the duration in hours
    $durationInHours = ceil(($exitTimestamp - $entryTimestamp) / 3600);

    // Minimum charge for the first hour
    $minimumCharge = 5;

    // Additional charge for every subsequent hour
    $additionalChargePerHour = 5;

    // Calculate the total amount
    $totalAmount = $minimumCharge + ($additionalChargePerHour * max(0, $durationInHours - 1));

    return "$" . number_format($totalAmount, 2);
}
?>
