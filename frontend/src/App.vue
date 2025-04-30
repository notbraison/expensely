<template>
  <div id="app">
    <header>
      <NavBar/>  
    </header> <br>
      

    

<main>
  <RouterView></RouterView> 
</main>
    
    
    
    
    <footer>
      <Footer/>
    </footer>
  </div>


</template>



<script >
import NavBar from './components/Navbar.vue';
import Footer from './components/Footer.vue';



export default{
    
    components:{
     NavBar,
     Footer
    }
    
}

</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Reset styles for the app container */
#app {
  padding: 0; /* Ensure no padding for the app container */
  min-height: 100vh; /* Make sure the app takes full height */
}


/* Main content styles */
main {
  padding: 15px; /* Optional: Adjust as needed for your main content */
}

/* Footer styles */
footer {
  padding: 0; /* Remove any padding */
  margin: 0; /* Ensure no margin */
  background-color: #24262b; /* Footer background color */
  text-align: center; /* Center the text */
}








</style>
