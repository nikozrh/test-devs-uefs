<template>
  <nav class="bg-blue-500 text-white p-4">
    <ul class="flex space-x-4">
      <li><router-link to="/users">Usuários</router-link></li>
      <li><router-link to="/posts">Posts</router-link></li>
      <li><router-link to="/tags">Tags</router-link></li>
    </ul>
  </nav>
</template>

<script>
export default { name: 'Navbar' };
</script>
