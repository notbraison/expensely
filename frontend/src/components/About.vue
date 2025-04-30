<template>
    <div class="about-us-container">
      <h1>About Us</h1>
      <p>Welcome to our Building Management System! We are dedicated to providing high-quality room booking services for our customers. Whether you're looking for a space for a meeting, an event, or a short stay, we have a variety of rooms available to meet your needs.</p>
      
      <h2>Our Services</h2>
      <ul>
        <li>Room Booking: Easily book rooms for meetings, events, or stays through our user-friendly platform.</li>
        <li>Customer Support: Our dedicated customer support team is here to assist you with any inquiries or issues.</li>
        <li>Flexible Options: Choose from a variety of rooms to suit your specific requirements and preferences.</li>
        <li>Secure Payments: Enjoy secure and hassle-free payment options for all your bookings.</li>
      </ul>
  
      <h2>Available Rooms</h2>
      <p>We offer a range of rooms to cater to different needs:</p>
      <ul>
        <li>Conference Rooms: Ideal for business meetings and conferences, equipped with modern amenities.</li>
        <li>Event Spaces: Perfect for hosting events, parties, and gatherings with ample space and facilities.</li>
        <li>Guest Rooms: Comfortable and well-furnished rooms for short stays, providing a home-like experience.</li>
      </ul>
      <p>Contact us today to learn more about our room availability and to make your booking. We look forward to serving you!</p>
    </div>

    <Backbutton/>
  </template>
  
  <script>
import Backbutton from './Backbutton.vue';

  export default {
    name: 'About',
    components:{
      Backbutton
    }
  };
  </script>
  
  <style scoped>
  .about-us-container {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
  }
  
  h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
  }
  
  h2 {
    font-size: 2rem;
    margin-top: 20px;
    margin-bottom: 10px;
  }
  
  p {
    font-size: 1.2rem;
    margin-bottom: 15px;
    line-height: 1.5;
  }
  
  ul {
    list-style-type: disc;
    margin-left: 20px;
    margin-bottom: 20px;
  }
  
  li {
    font-size: 1.2rem;
    margin-bottom: 10px;
  }
  </style>
  