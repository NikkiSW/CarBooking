function validateBookingForm() {

  var bookingReason = document.getElementById("bookingReason");

  if (bookingReason.value == "") {
    alert("Please provide a reason for your booking");
    bookingReason.focus();
    return false;
  }

  return true;
}