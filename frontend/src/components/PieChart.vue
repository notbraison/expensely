<template>
  <div>
    <Pie :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale);

export default {
  name: 'PieChart',
  components: {
    Pie,
  },
  props: {
    data: Array,
  },
  computed: {
    chartData() {
      return {
        labels: this.data.map(item => item.category),  // Category names as labels
        datasets: [
          {
            label: 'Expense by Category',
            data: this.data.map(item => item.value),  // Expense value for each category
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF5733'],  // Colors for the segments
            borderColor: '#fff',
            borderWidth: 1,
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
            text: 'Expense by Category',
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
