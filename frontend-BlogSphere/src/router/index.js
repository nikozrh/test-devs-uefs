import { createRouter, createWebHistory } from 'vue-router';
import Users from '../pages/Users.vue';
import Posts from '../pages/Posts.vue';
import Tags from '../pages/Tags.vue';

const routes = [
  { path: '/', component: Users },
];

export const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;