<?php

//Update Expire Booking
require 'connection.php';

$query = "select * from Booking where booking_status = 'Waiting'";
$result = mysqli_query($con, $query);
$update_row = 0;
$time_now = substr(strtr(substr(date("c"), 0, 19), "T", " "), 11, 19);
$date_now = strtr(substr(date("c"), 0, 19), "T", " ");
while ($row = mysqli_fetch_array($result)) {
    
    $matchingID = $row["matchingID"];
    $bookingID = $row["bookingID"];
    $expire_time = $row["expire_date"];
    if ($expire_time < $date_now) { // Check Date Time
        $update_query = "update Booking set booking_status = 'Reject' , member_noti = 1 where bookingID = $bookingID";
        if (mysqli_query($con, $update_query)) {
            $roomID = $row["roomID"];
            $plus_room_query = "update RoomPerFloor set roomPerFloor = roomPerFloor + 1 where matchingID = $matchingID";
            if (mysqli_query($con, $plus_room_query)) {
                $update_row = $update_row + 1;
                echo '<script>alert("Update Success '. $update_row .' Rows")</script>';
            } else {
                echo '<script>alert("Update Failed")</script>';
            }
        }
    }
}
                echo '<script>alert("Date Now = '. $expire_time .' Time Now = '. $date_now .' Time 2 Now = '. substr(strtr(substr($expire_time, 0, 19), "T", " "), 11, 19) .'")</script>';
?>
