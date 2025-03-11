<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-gray-200 p-6 rounded shadow-lg max-w-md w-full">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props: {
        isOpen: Boolean,
    },
};
</script>

<style scoped>
.bg-black {
    background-color: rgba(14, 13, 13, 0.5);
    /* Fundo escuro translúcido */
}

.bg-gray-200 {
    background-color: #c6c9cf;
    /* Fundo cinza claro */
    border-radius: 8px;
}

.shadow-lg {
    box-shadow: 0 8px 16px rgba(14, 13, 13, 0.2);
    /* Sombra */
}
</style>