<?php

require 'connection.php';
//Update Expire Booking
require 'connection.php';

    $query = "select * from booking where booking_status = 'Waiting'";
    $result = mysqli_query($con, $query);
    $update_row = 0;
    $time_now = substr(strtr(substr(date("c"), 0, 19), "T", " "), 11, 19);
    $date_now = strtr(substr(date("c"), 0, 19), "T", " ");
    while ($row = mysqli_fetch_array($result)) {

        $bookingID = $row["bookingID"];
        $expire_time = $row["expire_date"];
        if ($expire_time <= $date_now) { // Check Date Time
            if (substr($expire_time, 11, 19) < $time_now) { // Check Time
                $update_query = "update booking set booking_status = 'Reject' where bookingID = $bookingID";
                if (mysqli_query($con, $update_query)) {
                    $roomID = $row["roomID"];
                    $plus_room_query = "update rooms set roomAvailable = roomAvailable + 1 where roomID = $roomID";
                    if (mysqli_query($con, $plus_room_query)) {
                        $update_row = $update_row + 1;
                    }
                }
            }
        }
    }

?>
