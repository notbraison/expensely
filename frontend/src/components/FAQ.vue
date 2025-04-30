<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">Frequently Asked Questions</h2>
    <div class="faq-item" v-for="(item, index) in faqs" :key="index">
      <h5 @click="item.show = !item.show" class="faq-question">
        {{ item.question }}
      </h5>
      <p v-if="item.show" class="faq-answer">{{ item.answer }}</p>
    </div>
  </div>

  <div>
    <Backbutton />
  </div>
</template>

<script>
import Backbutton from './Backbutton.vue';

export default {
  components:{
    Backbutton
  },
  data() {
    return {
      faqs: [
        { question: "How do I book a room?", answer: "You can book a room by navigating to the booking section and selecting your desired room." },
        { question: "What is the cancellation policy?", answer: "Cancellations must be made at least 24 hours in advance." },
        { question: "Can I change my booking?", answer: "Yes, you can modify your booking details through your account." },
      ],
    };
  },
};
</script>

<style scoped>
.faq-item {
  margin-bottom: 15px;
}
.faq-question {
  cursor: pointer;
  color: #007bff;
}
.faq-answer {
  margin-top: 5px;
  color: #555;
}
</style>
