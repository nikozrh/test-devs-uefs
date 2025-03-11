<template>
    <div class="not-found-container">
        <h1 class="error-code">404</h1>
        <p class="error-message">Ops! Página não encontrada</p>
        <p class="error-details">
            A página que você está procurando pode ter sido movida, removida ou nunca existiu.
        </p>
        <router-link to="/" class="back-home-btn">Voltar para a Página Inicial</router-link>
    </div>
</template>

<script>
export default {
    name: "NotFound",
};
</script>

<style scoped>
.not-found-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    text-align: center;
    background-color: #f8f9fa;
    /* Fundo claro */
    color: #333;
    /* Cor do texto */
}

.error-code {
    font-size: 6rem;
    font-weight: bold;
    color: #d9534f;
    /* Vermelho suave */
    margin: 0;
}

.error-message {
    font-size: 1.5rem;
    font-weight: bold;
    margin: 10px 0;
}

.error-details {
    font-size: 1rem;
    color: #666;
    margin-bottom: 20px;
}

.back-home-btn {
    display: inline-block;
    text-decoration: none;
    padding: 10px 20px;
    font-size: 1rem;
    color: #fff;
    background-color: #007bff;
    /* Azul */
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.back-home-btn:hover {
    background-color: #0056b3;
    /* Azul escuro no hover */
}
</style>
