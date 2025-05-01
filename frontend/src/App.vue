<template>
  <div id="app">

    <div class="main-content">



      <header>
        <br>
        <NavBar />
        <br> <br>
      </header> <br>




      <main>
        <RouterView></RouterView>
      </main>


    </div>


    <footer class="footer">
      <!-- <div class="container"> -->
        <Footer />
      <!-- </div> -->
    </footer>


  </div>


</template>



<script>
import NavBar from './components/Navbar.vue';
import Footer from './components/Footer.vue';



export default {

  components: {
    NavBar,
    Footer
  }

}

</script>

<style scoped></style>
