//doughnut
$(document).ready(function () {
  $(".service-container").each(function () {
    var container = $(this);
    var service = container.data("service");
    var resto = 100 - service;
    var ctxD = document.getElementById("doughnutChart").getContext("2d");
    var myLineChart = new Chart(ctxD, {
      type: "doughnut",
      data: {
        labels: ["Espacio utilizado", "Libre"],
        datasets: [
          {
            data: [service, resto],
            backgroundColor: ["#F7464A", "#46BFBD"],
            hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"],
          },
        ],
      },
      options: {
        responsive: true,
      },
    });
  });
});
