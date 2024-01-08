<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import Header from './Header.vue';
import Footer from './Footer.vue';
import Hero from './Hero.vue';

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
})

</script>

<template>
  <!-- header -->
  <Header />
  <!-- end header -->

  <!-- main content -->
  <!-- hero section (in main) -->
  <Hero />
  <!-- end hero section (in main) -->

  <slot />
  <!-- end main content -->

  <!-- footer -->
  <Footer />
  <!-- end footer -->
</template>

