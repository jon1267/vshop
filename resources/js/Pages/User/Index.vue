<script setup>
import UserLayouts from './Layouts/UserLayouts.vue';

defineProps({
  products: Array,
})

const addToCart = (product) => {
  console.log(product);
}
</script>

<template>

  <UserLayouts>
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Latest products list</h2>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          <div v-for="product in products" :key="product.id" class="group relative ">
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80 ">

              <img @click="addToCart(product)" v-if="product.product_images.length > 0" :src="`/${product.product_images[0].image}`" :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
              <img v-else src="/product_images/no-image.svg.png" :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />

              <!-- add to cart icon (? here it not work for me ...) -->

            </div>
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm text-gray-700">
                  <span aria-hidden="true" class="absolute inset-0" />
                  {{ product.title }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ product.brand.name }}</p>
              </div>

              <!-- add to cart icon (and here it work...) -->
              <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer">
                <div @click="addToCart(product)" class="bg-blue-700 p-2 rounded-full"  >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </div>
              </div>
              <!-- add to cart icon -->

              <p class="text-sm font-medium text-gray-900">${{ product.price }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </UserLayouts>

</template>
