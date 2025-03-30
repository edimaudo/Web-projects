//

function setRowColors() {
var range = SpreadsheetApp.getActiveSheet().getDataRange();
var statusColumnOffset = getStatusColumnOffset();
for (var i = range.getRow(); i < range.getLastRow(); i++) {
rowRange = range.offset(i, 0, 1);
status = rowRange.offset(0, statusColumnOffset).getValue();
if (status == 'Completed') {
rowRange.setBackgroundColor("#99CC99");
} else if (status == 'In Progress') {
rowRange.setBackgroundColor("#FFDD88");
} else if (status == 'Not Started') {
rowRange.setBackgroundColor("#CC6666");
}
}
}
//Returns the offset value of the column titled "Status"
//(eg, if the 7th column is labeled "Status", this function returns 6)
function getStatusColumnOffset() {
lastColumn = SpreadsheetApp.getActiveSheet().getLastColumn();
var range = SpreadsheetApp.getActiveSheet().getRange(1,1,1,lastColumn);
for (var i = 0; i < range.getLastColumn(); i++) {
if (range.offset(0, i, 1, 1).getValue() == "Status") {
return i;
}
}
}
