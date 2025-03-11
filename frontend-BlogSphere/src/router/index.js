import { createRouter, createWebHistory } from "vue-router";

// Importar as páginas
const Home = () => import("../pages/Home.vue");
const Users = () => import("../pages/Users.vue");
const Tags = () => import("../pages/Tags.vue");
const Posts = () => import("../pages/Posts.vue");
const Forum = () => import ("../pages/Forum.vue");

const routes = [
  {
    path: "/", // Página inicial
    name: "Home",
    component: Home,
    meta: { title: "Página Inicial" },
  },
  {
    path: "/users", // Página de usuários
    name: "Users",
    component: Users,
    meta: { title: "Gerenciamento de Usuários" },
  },
  {
    path: "/tags", // Página de tags
    name: "Tags",
    component: Tags,
    meta: { title: "Gerenciamento de tags" },
  },
  {
    path: "/posts", // Página de postagens
    name: "Posts",
    component: Posts,
    meta: { title: "Gerenciamento de postagens" },
  },

  {
    path: "/:pathMatch(.*)*", // Captura rotas inválidas
    name: "NotFound",
    component: () => import("../pages/NotFound.vue"), // Página de erro
    meta: { title: "Página não encontrada" },
  },

  {
    path: "/forum",
    name: "Forum",
    component: Forum,
    meta: { title: "Fórum" },
  },
  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
