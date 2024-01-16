<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import Header from './Header.vue';
import Footer from './Footer.vue';

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
  <slot />
  <!-- end main content -->

  <!-- footer -->
  <Footer />
  <!-- end footer -->
</template>

