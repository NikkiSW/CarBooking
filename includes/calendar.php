<?php
require_once("config/db.php");

// Let's retrieve a list of bookings from the database
function getBookings() {
  $db = new Database();

  $query  = "SELECT b.id, b.booked_date, b.user_id, u.first_name, u.last_name ";
  $query .= "FROM booking b ";
  $query .= "INNER JOIN user u ";
  $query .= "ON b.user_id = u.id ";
  $result = $db->query($query);
  $bookingArr = array();
  
  if ($result['success'] == true) {
	  $bookingArr = $result['rows'];
  } else {
	  echo "A database error has occurred.";
  } //if

  return $bookingArr;
}

// Check if anyone has booked for the date being passed
function checkBookings($checkDate) {

  $bookingArr = getBookings();
  $personBooked = "";
  $bookingDetails = array();

  while (list($index) = each($bookingArr)) {

    if ($checkDate == $bookingArr[$index]["booked_date"]) {
      $bookingDetails["bookingId"] = $bookingArr[$index]["id"];
      $bookingDetails["personBooked"] = $bookingArr[$index]["first_name"] . " " . $bookingArr[$index]["last_name"];
    } // if

  } // while

  reset($bookingArr);
  return $bookingDetails;
}

// Build the calendar to display
function renderCalendar($strMonth, $strYear) {

  $date = mktime(12, 0, 0, $strMonth, 1, $strYear);
  $daysInMonth = date("t", $date);
  $dayOffset = date("w", $date);
  $nextday = 1;
  $next = date("Y-m-",strtotime($strYear."-".$strMonth."-01 +1 months"));

  if ($dayOffset > 0) {
    $prevmonthdaystart = date("t",strtotime($strYear."-".$strMonth."-01 -1 months")) - ($dayOffset -1);
    $prev = date("Y-m-",strtotime($strYear."-".$strMonth."-01 -1 months"));
  }

  $calendarWeeks = ceil(($daysInMonth + $dayOffset) / 7) - 1;
  echo '<h1>'.date("F", $date).' '.$strYear.'</h1>';

  if ($strMonth == 1) {
    $lastMonth = 12;
    $navYearB = $strYear - 1;
  } // if
  else {
    $lastMonth = $strMonth - 1;
    $navYearB = $strYear;
  } // else
  if ($strMonth == 12) {
    $nextMonth = 1;
    $navYearF = $strYear + 1;
  } // if
  else {
    $nextMonth = $strMonth + 1;
    $navYearF = $strYear;
  } // else

  $strMonth = str_pad($strMonth, 2 , "0", STR_PAD_LEFT);
  $lastMonth = str_pad($lastMonth, 2 , "0", STR_PAD_LEFT);
  $nextMonth = str_pad($nextMonth, 2 , "0", STR_PAD_LEFT);
  echo '<div class="nav">';
  echo '<a class="nav_prev" href="viewCalendar.php?navMonth='.$lastMonth.'&navYear='.$navYearB.'">&lt;&lt Previous Month</a>';
  echo '<a class="nav_next" href="viewCalendar.php?navMonth='.$nextMonth.'&navYear='.$navYearF.'">Next Month &gt;&gt;</a>';
  echo '</div>';

  for ($rowIndex = 0; $rowIndex <= $calendarWeeks; $rowIndex++) {

    for ($colIndex = 1; $colIndex <= 7; $colIndex++) {

      $currentDay = ($colIndex - $dayOffset) + ($rowIndex * 7);

      // next month
      if ($currentDay > $daysInMonth) {
        $after = str_pad($nextday, 2 , "0", STR_PAD_LEFT);
        echo '<time datetime="'.$next.$after.'" class="not month">';
        $fullDate = $navYearF.'-'.$nextMonth.'-'.$after;
        $bookingDetails = checkBookings($fullDate);

        if (!empty($bookingDetails)) {
          echo '<a href="viewBooking.php?bookingId='.$bookingDetails["bookingId"].'">'.$after.'</a>';
          echo '<div class="info">';
          echo "<b>Booked:</b><br />" . $bookingDetails["personBooked"];
          echo '</div>';
        } // if
        else {
          echo '<a href="makeBooking.php?bookingDate='.$fullDate.'">'.$after.'</a>';
        }

        echo '</time>';
        $nextday++;
      } // if
      // last month
      else if ($currentDay < 1) {
        echo '<time datetime="';
        echo $prev.str_pad($prevmonthdaystart, 2 , "0",STR_PAD_LEFT);
        echo '" class="notmonth">';
        $fullDate = $navYearB.'-'.$lastMonth.'-'.$prevmonthdaystart;
        $bookingDetails = checkBookings($fullDate);

        if (!empty($bookingDetails)) {
          echo '<a href="viewBooking.php?bookingId='.$bookingDetails["bookingId"].'">'.$prevmonthdaystart.'</a>';
          echo '<div class="info">';
          echo '<b>Booked:</b><br />' . $bookingDetails["personBooked"];
          echo '</div>';
        } // if
        else {
          echo '<a href="#">'.$prevmonthdaystart.'</a>';
        } // else
        echo '</time>';
        $prevmonthdaystart++;
      } //else if
      // current month
      else {
        $current = str_pad($currentDay, 2 , "0",STR_PAD_LEFT);
        echo '<time datetime="';
        echo $strYear.'-'.str_pad($strMonth, 2 , "0",STR_PAD_LEFT);
        echo '-'.$current.'">';
        $fullDate = $strYear.'-'.$strMonth.'-'.$current;
        $bookingDetails = checkBookings($fullDate);

        if (!empty($bookingDetails)) {
          echo '<a href="viewBooking.php?bookingId='.$bookingDetails["bookingId"].'" id='.$currentDay.'" >'.$current.'</a>';
          echo '<div class="info">';
          echo '<b>Booked:</b><br />' . $bookingDetails["personBooked"];
          echo '</div>';
        } // if
        else {

          if ($fullDate > date('Y-m-d')) {
            echo '<a href="makeBooking.php?bookingDate='.$fullDate.'" id='.$currentDay.'" >'.$current.'</a>';
          } // if
          else if ($fullDate == date('Y-m-d')) {
            echo '<a href="#"><b>'.$currentDay.'</b></a>';
          } // else iff
          else {
            echo '<a href="#">'.$currentDay.'</a>';
          } // else
        } // else
        echo '</time>';
      } // else
    } // for
  } // for
}
?>