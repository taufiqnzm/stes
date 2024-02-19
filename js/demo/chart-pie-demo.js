// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Ketidakhadiran", "Urusan Rasmi", "Kecemasan", "CRK", "Cuti Lain", "Cuti Bersalin", "Cuti Haji Umrah", "Keberadaan Jam"],
    datasets: [{
      data: [absentCount, officialCount, emergencyCount, crkCount, cutiLainCount, cutiBersalinCount, cutihajiUmrahCount, keberadaanJamCount], // Use the variables here
      backgroundColor: ['#f6c23e', '#36b9cc', '#e74a3b', '#5a5c69', '#AF27F2', '#F227CD', 'rgb(22, 160, 133)', '#C2187F'],
      hoverBackgroundColor: ['#f6c23e', '#36b9cc', '#e74a3b', '#5a5c69', '#AF27F2', '#F227CD', 'rgb(22, 160, 133)', '#C2187F'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    aspectRatio: 10, // Set the aspect ratio to 1 to make the pie chart round
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
