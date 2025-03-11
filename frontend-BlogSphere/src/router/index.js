import { createRouter, createWebHistory } from 'vue-router';
import Users from '../pages/Users.vue';
import Posts from '../pages/Posts.vue';
import Tags from '../pages/Tags.vue';

const routes = [
  { path: '/users', component: Users },
  { path: '/posts', component: Posts },
  { path: '/tags', component: Tags },
  { path: '/', redirect: '/users' }, // Redireciona para /users como padrão
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
