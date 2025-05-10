<template>
  <div>
    <Line :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale);

export default {
  name: 'LineChart',
  components: {
    Line,
  },
  props: {
    data: Array,
  },
  computed: {
    chartData() {
      return {
        labels: this.data.map(item => item.date),  // Dates as labels
        datasets: [
          {
            label: 'Expense Trends',
            data: this.data.map(item => item.expense),  // Expense data
            fill: false,
            borderColor: 'rgba(75,192,192,1)',
            tension: 0.1,
          },
        ],
      };
    },
    chartOptions() {
      return {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Expense Trends',
          },
        },
        scales: {
          x: {
            title: {
              display: true,
              text: 'Date',
            },
          },
          y: {
            title: {
              display: true,
              text: 'Amount',
            },
            beginAtZero: true,
          },
        },
      };
    },
  },
};
</script>

<style scoped>
/* Additional styling for the chart */
</style>
