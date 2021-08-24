<template>
  <div>
    <div
      class="ui fixed inverted four item menu"
      :style="{ backgroundColor: colors.second }"
    >
      <div class="ui container">
        <router-link to="/home" class="header item margin-menu-itens">
          <font-awesome-icon icon="desktop" class="padding-menu-icon-text" />Sistema
        </router-link>
        <router-link
          v-if="!currentUser"
          to="/register"
          class="header item margin-menu-itens"
        >
          <font-awesome-icon
            icon="user-plus"
            class="padding-menu-icon-text"
          />Criar conta
        </router-link>
        <router-link
          v-if="!currentUser"
          to="/login"
          class="header item margin-menu-itens"
        >
          <font-awesome-icon
            icon="sign-in-alt"
            class="padding-menu-icon-text"
          />Login
        </router-link>
        <router-link
          v-if="currentUser"
          to="/profile"
          class="header item margin-menu-itens"
        >
          <font-awesome-icon icon="user" class="padding-menu-icon-text" />
          {{ currentUser.username }}
        </router-link>
        <router-link
          v-if="currentUser"
          to="/users"
          class="header item margin-menu-itens"
        >
          <font-awesome-icon :icon="['fas', 'users']" class="padding-menu-icon-text" />
          Mostrar usuários
        </router-link>
        <a
          v-if="currentUser"
          class="header item margin-menu-itens"
          href
          @click.prevent="logOut"
        >
          <font-awesome-icon icon="sign-out-alt" class="padding-menu-icon-text" /> Sair
        </a>
      </div>
    </div>
    <div class="content">
      <router-view />
    </div>
  </div>
</template>

<script>
import colors from "./utils/styles/colors";
export default {
  data() {
    return {
      colors: colors,
    };
  },
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
  },
  methods: {
    logOut() {
      this.$store.dispatch("auth/logout");
      this.$router.push("/login");
    },
  },
};
</script>
<style>
.margin-menu-itens {
  margin-right: 1%;
  margin-left: 1%;
}
.padding-menu-icon-text {
  margin-right: 10%;
}
.ui.menu .item img.logo {
  margin-right: 1.5em;
}
</style>