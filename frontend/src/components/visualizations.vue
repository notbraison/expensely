<template>
  <div class="visualizations-container">
    <h1>User Demographics</h1>
    <canvas id="demographicsChart"></canvas>

    <h1>Booking Trends Over Time</h1>
    <canvas id="bookingTrendsChart"></canvas>

    <h1>Occupancy Rates</h1>
    <canvas id="occupancyRatesChart"></canvas>

    <h1>Additional Visualization</h1>
    <canvas></canvas>
  </div>

  <Backbutton/>
</template>

<script>
import { Chart } from 'chart.js';
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  mounted() {
    this.fetchUserDemographics();
    this.fetchBookingTrends();
    this.fetchOccupancyRates();
    // You can call a method for the fourth visualization here
  },
  methods: {
    async fetchUserDemographics() {
  try {
    const response = await fetch('/api/reports/user-demographics');
    
    // Log the response to check its content
    const text = await response.text(); // Get response as text
    console.log(text); // Log the raw response text

    // Check if the response is valid JSON
    const data = JSON.parse(text); // Attempt to parse the text as JSON

    const labels = data.map(item => item.gender);
    const counts = data.map(item => item.count);

    this.renderDemographicsChart(labels, counts);
  } catch (error) {
    console.error('Error fetching user demographics:', error);
    this.error = 'Error fetching user demographics: ' + error.message;
  }
}
,
    renderDemographicsChart(labels, counts) {
      const ctx = document.getElementById('demographicsChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Number of Users',
            data: counts,
            backgroundColor: ['#FF6384', '#36A2EB'], // Colors for bars
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },
    async fetchBookingTrends() {
      const response = await fetch('/api/reports/booking-trends');
      const data = await response.json();

      const labels = data.map(item => item.date);
      const bookings = data.map(item => item.bookings);

      this.renderBookingTrendsChart(labels, bookings);
    },
    renderBookingTrendsChart(labels, bookings) {
      const ctx = document.getElementById('bookingTrendsChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Bookings Over Time',
            data: bookings,
            borderColor: '#42A5F5',
            fill: false,
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },
    async fetchOccupancyRates() {
      const response = await fetch('/api/reports/occupancy-rates');
      const data = await response.json();

      const labels = data.map(item => `Room ${item.room.room_name}`);
      const bookings = data.map(item => item.bookings);

      this.renderOccupancyRatesChart(labels, bookings);
    },
    renderOccupancyRatesChart(labels, bookings) {
      const ctx = document.getElementById('occupancyRatesChart').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            label: 'Occupancy Rates',
            data: bookings,
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
          }
        }
      });
    }
  }
};
</script>

<style scoped>
.visualizations-container {
  padding: 2rem;
}

canvas {
  max-width: 600px;
  margin: 1rem auto;
}

.placeholder {
  height: 200px; /* Placeholder for the fourth visualization */
  background-color: #f0f0f0;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.2em;
  color: #888;
}
</style>
