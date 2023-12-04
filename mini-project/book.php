<?php
    date_default_timezone_set('Asia/Kolkata');
    $VehicleNumber = $_POST['VehicleNumber'];
    $VehicleType = $_POST['VehicleType'];
    $OwnerName = $_POST['OwnerName'];
    $ContactNumber = $_POST['ContactNumber'];
    $City = $_POST['City'];
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i");

    $conn = new mysqli('localhost','root','','mini-project');
    $allSlots = range(1, 100);
    $query = "SELECT DISTINCT ParkingSlot FROM slot";
    $result = $conn->query($query);
    $usedSlots = array();
    while ($row = $result->fetch_assoc()) {
        $usedSlots[] = $row['ParkingSlot'];
    }
    $remainingSlots = array_diff($allSlots, $usedSlots);

    if($conn->connect_error){
        die('Connection Failed :  '.$conn->connect_error);
    }else{
        $queryAvailableSlot = "SELECT MIN(ParkingSlot) AS availableSlot FROM slot WHERE ExitTime IS NOT NULL";
        $resultAvailableSlot = $conn->query($queryAvailableSlot);

        $row = $resultAvailableSlot->fetch_assoc();
        $availableSlot = $row['availableSlot'];
        if ($availableSlot === null) {
            // If all slots are in use, assign the next slot number
            $queryNextSlot = "SELECT MAX(ParkingSlot) + 1 AS nextSlot FROM slot";
            $resultNextSlot = $conn->query($queryNextSlot);
    
            $rowNextSlot = $resultNextSlot->fetch_assoc();
            $availableSlot = $rowNextSlot['nextSlot'];
        }
        // else{
        //     $stmt = $conn->prepare("INSERT INTO slot (VehicleNumber, VehicleType,OwnerName,ContactNumber,ParkingSlot,EntryDate,EntryTime) VALUES (?, ?, ?,?,?,?,?)");
        //     $stmt->bind_param("ssssiss",$VehicleNumber, $VehicleType,$OwnerName,$ContactNumber,$ParkingSlot,$currentDate,$currentTime);
        //     $stmt->execute();
        //     echo '<script>alert("Your slot has been booked");
        //     window.location.href = "./thankyou.html";</script>';
        //     $stmt->close();
        // }

        $stmt = $conn->prepare("INSERT INTO slot (VehicleNumber, VehicleType, OwnerName, ContactNumber, ParkingSlot, EntryDate, EntryTime, City) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("ssssisss", $VehicleNumber, $VehicleType, $OwnerName, $ContactNumber, $availableSlot, $currentDate, $currentTime, $City);

        if ($stmt->execute()) {
            $conn->commit();
            echo '<script>alert("Your slot has been booked. Parking Slot: ' . $availableSlot . '");
                window.location.href = "./show1.php";</script>';
        } else {
            throw new Exception("Error booking slot. Please try again later.");
        }

    }
    $conn->close();
?>