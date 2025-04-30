<template>
  <div class="features-container">
    <router-link to="/browserooms">
     <h3 class="hover-text">Explore Our Featured Rooms</h3> 
    </router-link>
    
    <div class="feature-cards">
      <button class="nav-button" @click="prevFeature">Prev</button>
      <div class="feature-card" v-for="(feature, index) in visibleFeatures" :key="index">
        <img :src="feature.image" alt="Feature Image" class="feature-image" />
        <h3>{{ feature.title }}</h3>
      </div>
      <button class="nav-button" @click="nextFeature">Next</button>
    </div>
  </div>
</template>

<script>
import img1 from '../assets/images/appartmentlivingroombluecouch.jpg';
import img2 from '../assets/images/appartmentlivingroom.jpg';
import img3 from '../assets/images/midsizebedroomwhite.jpg';
import img4 from '../assets/images/appartmentlivingroomwhiteelegant.jpg';
import img5 from '../assets/images/deskworkerview.jpg';
import img6 from '../assets/images/smalltightofficespace.jpg';
import img7 from '../assets/images/desk2applecomputers.jpg';
import img8 from '../assets/images/officespaceobserverangle.jpg';
import img9 from '../assets/images/appartmentlivingroomcouchminimal.jpg';

export default {
  name: 'FeatureCards',
  data() {
    return {
      features: [
        { title: 'King Room', image: img1 },
        { title: 'Queen Room', image: img2 },
        { title: 'Bedsitter', image: img3 },
        { title: 'Suite', image: img4 },
        { title: 'Deluxe Room', image: img5 },
        { title: 'Economy Room', image: img6 },
        { title: 'Office Space', image: img7 },
        { title: 'Studio Apartment', image: img8 },
        { title: 'Penthouse', image: img9 }
      ],
      currentIndex: 0,
      visibleCount: 4 // Number of cards to show at a time
    };
  },
  computed: {
    visibleFeatures() {
      return this.features.slice(this.currentIndex, this.currentIndex + this.visibleCount);
    }
  },
  methods: {
    nextFeature() {
      if (this.currentIndex + this.visibleCount < this.features.length) {
        this.currentIndex += this.visibleCount;
      }
    },
    prevFeature() {
      if (this.currentIndex - this.visibleCount >= 0) {
        this.currentIndex -= this.visibleCount;
      }
    }
  }
};
</script>

<style scoped>
.hover-text {
  color: black; /* Default color */
  transition: color 0.3s ease; /* Smooth transition */
}

.hover-text:hover {
  color: red; /* Color on hover */
}

.features-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 2rem;
}

.feature-cards {
  display: flex;
  align-items: center;
}

.feature-card {
  background-color: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin: 1rem;
  width: 220px;
  text-align: center;
  transition: transform 0.3s;
}

.feature-card:hover {
  transform: translateY(-5px);
}

.feature-image {
  width: 100%;
  height: 200px; /* Adjust height as needed */
  object-fit: cover; /* Maintain aspect ratio */
  border-radius: 10px;
}

.nav-button {
  background-color: #007bff; /* Primary color */
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  margin: 0 10px; /* Space between buttons and cards */
  cursor: pointer;
  transition: background-color 0.3s;
}

.nav-button:hover {
  background-color: #0056b3; /* Darker shade on hover */
}

/* Responsive */
@media (max-width: 768px) {
  .feature-card {
    width: 90%; /* Adjust for smaller screens */
  }
}
</style>
