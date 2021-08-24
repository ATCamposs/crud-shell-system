<template>
  <div class="ui middle aligned center aligned grid">
    <div class="column" style="margin-top: 6%">
      <h2 style="color: white">Listagem de usuários</h2>
      <div class="top attached ui item menu">
        <div class="attached ui segment">ID</div>
        <div class="attached ui segment">Nome de usuário</div>
        <div class="attached ui segment">Email</div>
        <div class="attached ui segment">Criado em</div>
        <div class="attached ui segment">Ações</div>
      </div>
      <div v-for="(user, index) in usersList" :key="user + index">
        <div class="top attached ui item menu">
          <div class="attached ui segment">{{ user.id }}</div>
          <div class="attached ui segment">{{ user.username }}</div>
          <div class="attached ui segment">{{ user.email }}</div>
          <div class="attached ui segment">{{ user.created }}</div>
          <div class="attached ui segment">
            <button
              class="ui red submit button"
              @click="handleDeleteUser(user.id)"
            >
              Deletar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import authHeader from "../services/auth-header";
import axios from "axios";

const API_URL = "http://localhost:4747/";

export default {
  name: "Users",
  data() {
    return {
      usersList: {},
    };
  },
  mounted() {
    if (!this.currentUser) {
      this.$router.push("/login");
    }
    axios
      .get(API_URL + "users/index", {
        headers: authHeader(),
      })
      .then((response) => {
        this.usersList = response.data.data.users;
      })
      .catch((error) => {
        if (error.response.data) {
          this.errorMessages = error.response.data.data;
        }
      });
  },
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
  },
  methods: {
    handleDeleteUser(id) {
      axios
        .delete(API_URL + `users/delete/${id}`, {
          headers: authHeader(),
        })
        .then((response) => {
          if (response.status) {
            let i = this.usersList.map((data) => data.id).indexOf(id);
            this.usersList.splice(i, 1);
          }
        })
        .catch((error) => {
          if (error.response) {
            this.errorMessages = error.response.data.data;
          }
        });
    },
  },
};
</script>

<style>
.column {
  max-width: 90%;
}
</style>