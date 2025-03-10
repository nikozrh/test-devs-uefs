<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow-md">
        <slot />
        <button @click="closeModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">
          Fechar
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Modal',
    props: {
      isOpen: {
        type: Boolean,
        required: true,
      },
    },
    emits: ['close'],
    methods: {
      closeModal() {
        this.$emit('close');
      },
    },
  };
  </script>
  