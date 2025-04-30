<template>
    <div class="reports-container">
      <h1>Reports</h1>
      <p>View and analyze the different reports related to bookings and user demographics.</p>
  
      <div class="report-section">
        <h2>User Demographics</h2>
        <canvas id="demographicsChart"></canvas>
      </div>
  
      <div class="report-section">
        <h2>Booking Trends Over Time</h2>
        <canvas id="bookingTrendsChart"></canvas>
      </div>
  
      <div class="report-section">
        <h2>Occupancy Rates</h2>
        <canvas id="occupancyRatesChart"></canvas>
      </div>
  
      <div class="report-section">
        <h2>Additional Insights</h2>
        <canvas id="additionalInsightsChart"></canvas>
      </div>
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
    name: 'Reports',
    mounted() {
      this.fetchUserDemographics();
      this.fetchBookingTrends();
      this.fetchOccupancyRates();
      // Fetch data for the additional insights chart if needed
    },
    methods: {
      async fetchUserDemographics() {
        const response = await fetch('/api/reports/user-demographics');
        const data = await response.json();
  
        const labels = data.map(item => item.gender);
        const counts = data.map(item => item.count);
  
        this.renderDemographicsChart(labels, counts);
      },
      renderDemographicsChart(labels, counts) {
        const ctx = document.getElementById('demographicsChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Number of Users',
              data: counts,
              backgroundColor: ['#FF6384', '#36A2EB'],
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
              backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
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
  .reports-container {
    padding: 2rem;
  }
  
  .report-section {
    margin: 2rem 0;
  }
  
  canvas {
    max-width: 600px;
    margin: 1rem auto;
  }
  </style>
  