<template>
<main>

    <div class="header">
        <h1>Available Services</h1>
    </div>

    <vue-horizontal class="horizontal" >
      <section v-for="item in items" :key="item.title">
        <h3>{{ item.title }}</h3>
        <p>{{ item.content }}</p>
      </section>
    </vue-horizontal>
</main>
        

    
  </template>

<script>
import VueHorizontal from "vue-horizontal";

export default {
    name:'servicesList',
  components: {VueHorizontal},
  data() {
    return {
      // E.g: creates 20 array items...
      items: [...Array(5).keys()].map((i) => {
        return {title: `Item ${i+1}`, content:''};
      }),
    }
  }
}
</script>

<style>

section {
  padding: 10px 14px;
  background: #f5f5f5;
  margin-right:20px;
}
.header{
    font-size:24px;
    text-align: center;
    font-weight: 600;
    box-sizing: border-box
}

</style>
