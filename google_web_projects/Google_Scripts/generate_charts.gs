//auto generate charts
function GradeChart() {
  var spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = spreadsheet.getSheets()[0];

  var gradechart = sheet.newChart()
    .setChartType(Charts.ChartType.LINE)
    .addRange(sheet.getRange('A1:B11'))
    .setPosition(5, 5, 0, 0)
    .build();

  sheet.insertChart(gradechart);
}
