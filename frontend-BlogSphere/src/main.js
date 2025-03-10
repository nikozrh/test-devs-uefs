import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import './styles/tailwind.css'; 

const app = createApp(App);
app.use(router); // Instala o Vue Router
app.mount('#app');
