<template>
    <swiper :navigation="true" :modules="modules" speed="500" loop="true" class="mySwiper">
      <swiper-slide v-for="(image, index) in randomImages" :key="index" lazy="true">
        <a :href="image" aria-label="Room Image">
          <img :src="image" alt="Room Image" class="img-responsive swiper-lazy" loading="lazy" />
        </a>
      </swiper-slide>
    </swiper>
  </template>
  
  <script>
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import 'swiper/css'; // Import Swiper styles
  import 'swiper/css/navigation';
  import { Navigation } from 'swiper/modules';
  
  // Import images directly
  import img1 from '../assets/room_imgs/1.jpg';
  import img2 from '../assets/room_imgs/2.jpg';
  import img3 from '../assets/room_imgs/3.jpg';
  import img4 from '../assets/room_imgs/4.jpg';
  import img5 from '../assets/room_imgs/5.jpg';
  import img6 from '../assets/room_imgs/6.jpg';
  import img7 from '../assets/room_imgs/7.jpg';
  import img8 from '../assets/room_imgs/8.jpg';
  import img9 from '../assets/room_imgs/9.jpg';
  import img10 from '../assets/room_imgs/10.jpg';
  import img11 from '../assets/room_imgs/11.jpg';
  import img12 from '../assets/room_imgs/12.jpg';
  import img13 from '../assets/room_imgs/13.jpg';
  import img14 from '../assets/room_imgs/14.jpg';
  import img15 from '../assets/room_imgs/15.jpg';
  import img16 from '../assets/room_imgs/16.jpg';
  import img17 from '../assets/room_imgs/17.jpg';
  import img18 from '../assets/room_imgs/18.jpg';
  import img19 from '../assets/room_imgs/19.jpg';
  import img20 from '../assets/room_imgs/20.jpg';
  import img21 from '../assets/room_imgs/21.jpg';
  import img22 from '../assets/room_imgs/22.jpg';
  import img23 from '../assets/room_imgs/23.jpg';
  import img24 from '../assets/room_imgs/24.jpg';
  import img25 from '../assets/room_imgs/25.jpg';
  import img26 from '../assets/room_imgs/26.jpg';
  import img27 from '../assets/room_imgs/27.jpg';
  import img28 from '../assets/room_imgs/28.jpg';
  import img29 from '../assets/room_imgs/29.jpg';
  import img30 from '../assets/room_imgs/30.jpg';
  import img31 from '../assets/room_imgs/31.jpg';
  import img32 from '../assets/room_imgs/32.jpg';
  import img33 from '../assets/room_imgs/33.jpg';
  import img34 from '../assets/room_imgs/34.jpg';
  import img35 from '../assets/room_imgs/35.jpg';
  import img36 from '../assets/room_imgs/36.jpg';
  import img37 from '../assets/room_imgs/37.jpg';
  
  export default {
    components: {
      Swiper,
      SwiperSlide,
    },
    data() {
      return {
        modules: [Navigation],
        images: [
          img1,
          img2,
          img3,
          img4,
          img5,
          img6,
          img7,
          img8,
          img9,
          img10,
          img11,
          img12,
          img13,
          img14,
          img15,
          img16,
          img17,
          img18,
          img19,
          img20,
          img21,
          img22,
          img23,
          img24,
          img25,
          img26,
          img27,
          img28,
          img29,
          img30,
          img31,
          img32,
          img33,
          img34,
          img35,
          img36,
          img37,
        ],
        randomImages: [],
      };
    },
    methods: {
      getRandomImages() {
        // Shuffle the images array
        const shuffled = this.images.sort(() => 0.5 - Math.random());
        // Select the first 5 images from the shuffled array
        this.randomImages = shuffled.slice(0, 5);
      },
    },
    mounted() {
      this.getRandomImages(); // Get 5 random images when the component is mounted
    },
  };
  </script>
  
  <style scoped>
  .swiper {
    width: 100%;
    height: 100%;
  }
  
  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 15px; /* Rounded corners for the slide container */
  }
  
  .swiper-slide img {
    display: block;
    width: 100%; /* Ensure images fit the container */
    height: auto; /* Maintain aspect ratio */
    border-radius: 15px; /* Match the slide's border radius */
  }
  </style>
  