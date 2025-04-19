list = [
    {
        backgroundColor: 'rgba(54, 162, 235, 0.3)',   // 👈 Area fill (for line chart)
borderColor: 'rgba(54, 162, 235, 1)',         // 👈 Line or bar border color
pointBackgroundColor: '#ffffff',             // 👈 Dot color on line
pointBorderColor: 'rgba(54, 162, 235, 1)'  // 👈 Dot border color
    },
    {
        x: {
            ticks: {
              color: '#ffffff'    // 👈 X-axis numbers/text
            },
            grid: {
              color: 'rgba(255, 255, 255, 0.1)' // 👈 X-axis grid lines
          }
        }
          
    },
    {
        y: {
            ticks: {
              color: '#ffffff'    // 👈 Y-axis numbers/text
            },
            grid: {
              color: 'rgba(255, 255, 255, 0.1)' // 👈 Y-axis grid lines
          }
        }          
    },
    {
        legend: {
            labels: {
              color: '#ffffff'   // 👈 Legend text
            }
          },
          tooltip: {
            backgroundColor: '#222',   // 👈 Tooltip background
            titleColor: '#fff',        // 👈 Tooltip title
            bodyColor: '#ccc'          // 👈 Tooltip values
          }
          
    },

    {

    }
]  


// below graph code
//   const labels = <?php echo json_encode($labels); ?>;
//   const data = <?php echo json_encode($totals); ?>;

  let currentType = 'line';
  const ctx = document.getElementById('expenseChart').getContext('2d');

  let chart = new Chart(ctx, {
    type: currentType,
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Expense (₹)',
        data: data,
        backgroundColor: 'rgba(75, 192, 192, 0.3)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  function switchChart(type) {
    chart.destroy();
    chart = new Chart(ctx, {
      type: type,
      data: {
        labels: labels,
        datasets: [{
          label: 'Total Expense (₹)',
          data: data,
          backgroundColor: type === 'bar' ? 'rgba(255, 99, 132, 0.5)' : 'rgba(75, 192, 192, 0.3)',
          borderColor: type === 'bar' ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          fill: type === 'line',
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    currentType = type;
  }

