function createPopularityChart(labels, data) {
    var ctx = document.getElementById("popularityChart").getContext("2d");
    var popularityChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Popularity",
            data: data,
            backgroundColor: ["#ff1f5a", "#ffac1f", "#3ad46b", "#21a1ff"],
            hoverBackgroundColor: ["#ff1f5a", "#ffac1f", "#3ad46b", "#21a1ff"],
            borderWidth: 0,
          },
        ],
      },
      options: {
        animation: {
          duration: 2000,
          easing: "easeInOutQuart",
        },
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
                max: 100,
                fontColor: "white",
                fontFamily: "Roboto, sans-serif",
              },
              gridLines: {
                color: "rgba(255,255,255,0.3)",
              },
            },
          ],
          xAxes: [
            {
              ticks: {
                fontColor: "white",
                fontFamily: "Roboto, sans-serif",
              },
              gridLines: {
                display: false,
              },
            },
          ],
        },
        legend: {
          display: false,
        },
        tooltips: {
          enabled: true,
          backgroundColor: "rgba(0, 0, 0, 0.8)",
          titleFontColor: "white",
          bodyFontColor: "white",
          displayColors: false, // Set displayColors to false to remove the colored rectangle
          callbacks: {
            label: function (tooltipItem, data) {
              return "Popularity: " + tooltipItem.yLabel;
            },
          },
        },
      },
    });
  }