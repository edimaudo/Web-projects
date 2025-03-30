//

function sendEmails() {
  var sheet = SpreadsheetApp.getActiveSheet();
  var startRow = 2; // First row of data to process
  var numRows = 7; // Number of rows to process
  var dataRange = sheet.getRange(startRow, 1, numRows, 3)
  var data = dataRange.getValues();
  for (i in data) {
    var row = data[i];
    var emailAddress = row[1]; // Second column
    var message = row[2]; // Third column
    var subject = "My review notes";
    MailApp.sendEmail(emailAddress, subject, message);
  }
}
