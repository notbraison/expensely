<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Our Services</h2>
    <p>We offer a variety of services to make your stay comfortable and enjoyable:</p>
    
    <div class="service-item">
      <h5>Room Booking</h5>
      <p>Seamlessly book rooms through our platform, with various options available to suit your needs.</p>
    </div>
    
    <div class="service-item">
      <h5>24/7 Customer Support</h5>
      <p>Our dedicated support team is available around the clock to assist you with any inquiries or issues.</p>
    </div>
    
    <div class="service-item">
      <h5>Flexible Payment Options</h5>
      <p>We provide multiple payment methods, including credit cards, mobile money, and bank transfers, ensuring a hassle-free experience.</p>
    </div>
    
    <div class="service-item">
      <h5>Cleaning Services</h5>
      <p>Enjoy a clean and hygienic environment with our regular cleaning services, available upon request.</p>
    </div>
    
    <div class="service-item">
      <h5>Local Attractions</h5>
      <p>Discover the best local attractions and experiences with our curated guides and recommendations.</p>
    </div>
    
    <div class="service-item">
      <h5>Feedback and Reviews</h5>
      <p>We value your feedback! Share your experience with us to help us improve our services.</p>
    </div>
  </div>
  <br>
  <Backbutton/>
</template>

<script>
import Backbutton from './Backbutton.vue';

export default {
  components:{
        Backbutton
    },
  name: "Services",
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}

.service-item {
  margin-bottom: 20px;
  padding: 15px;
  border: 1px solid #eaeaea;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.service-item h5 {
  margin-bottom: 10px;
  color: #007bff;
}
</style>
