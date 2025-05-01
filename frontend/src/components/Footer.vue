<template>
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="footer-col">
          <h4>Company</h4>
          <ul>
            <li><router-link to="/About">About Us</router-link></li>
            <li><router-link to="/services">Our Services</router-link></li>
            <li><router-link to="/privacy-policy">Privacy Policy</router-link></li>
            <li><router-link to="/contact-us">Contact Us</router-link></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Get Help</h4>
          <ul>
            <li><router-link to="/FAQ">FAQ</router-link></li>
            <li><router-link to="/booking-guide">Booking Guide</router-link></li>
            <li><router-link to="/payment-options">Payment Options</router-link></li>
            <li><router-link to="/cancellation-policy">Cancellation Policy</router-link></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Our Services</h4>
          <ul>
            <li><router-link to="/browserooms">Room Booking</router-link></li>
            <li><router-link to="/under-construction">Room Management</router-link></li>
            <li><router-link to="/customer-support">Customer Support</router-link></li>
            <li><router-link to="/under-construction">Feedback</router-link></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Follow Us</h4>
          <div class="social-links">
            <a href="#" class="social-link" style="color: #4267B2;">Facebook</a>
            <a href="#" class="social-link" style="color: #1DA1F2;">Twitter</a>
            <a href="#" class="social-link" style="color: #C32AA3;">Instagram</a>
            <a href="#" class="social-link" style="color: #0077B5;">LinkedIn</a>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p> © 2025 Copyright: <a href="https://github.com/notbraison" class="footer-link">Braison</a></p>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer',
}
</script>

<style scoped>

body {
  line-height: 1.5;
  font-family: 'Poppins', sans-serif;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.container {
  width: 100%;
  padding-left: 0;
  padding-right: 0;

}

.row {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  width: 100%;
}

.footer {
  background-color: #24262b;
  padding: 50px 0;
  color: #ffffff;
  width: 100%; /* Ensure the footer takes full width */
  position: relative;
}

.footer-col {
  width: 23%;
  padding: 0 15px;
  margin-bottom: 20px; /* Bottom margin to separate the columns */
}

.footer-col h4 {
  font-size: 18px;
  color: #e91e63; /* Accent color for headings */
  margin-bottom: 35px;
  font-weight: 500;
  position: relative;
}

.footer-col h4::before {
  content: '';
  position: absolute;
  left: 0;
  bottom: -10px;
  background-color: #e91e63; /* Accent color */
  height: 2px;
  width: 50px;
}

.footer-col ul {
  list-style: none;
}

.footer-col ul li:not(:last-child) {
  margin-bottom: 10px;
}

.footer-col ul li a {
  font-size: 16px;
  color: #000000; /* Black for links */
  text-decoration: none;
  font-weight: 300;
  transition: color 0.3s ease;
}

.footer-col ul li a:hover {
  color: #e91e63; /* Change link color on hover */
}

.social-links {
  margin-top: 10px;
  display: flex;
  flex-direction: column; /* Vertical alignment */
}

.social-link {
  margin-bottom: 10px; /* Space between social links */
  font-size: 16px;
  transition: color 0.5s;
}

.social-link:hover {
  color: #e91e63; /* Accent color on hover */
}

.footer-bottom {
  background-color: #1a1a1a; /* Darker footer bottom */
  text-align: center;
  padding: 2px 0;
  color: black;
}

/* Responsive */
@media (max-width: 767px) {
  .footer-col {
    width: 50%;
    margin-bottom: 30px;
  }
}

@media (max-width: 574px) {
  .footer-col {
    width: 100%;
  }
}
</style>
