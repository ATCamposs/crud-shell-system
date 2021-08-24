<template>
  <div class="ui middle aligned center aligned grid">
    <div class="column" style="margin-top: 8%">
      <h2 class="ui teal image header">
        <img
          src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"
          class="profile-img-card"
        />
        <div class="content">Entre com sua conta</div>
      </h2>
      <form class="ui large form" @submit.prevent="handleLogin">
        <div
          class="ui stacked segment"
          :style="{ backgroundColor: colors.fourth }"
        >
          <div class="field">
            <div class="ui left icon input">
              <i class="mail icon"></i>
              <input
                v-model="user.email"
                v-validate="'required|email'"
                type="text"
                name="email"
                placeholder="Email"
                :style="{ backgroundColor: colors.fifth }"
              />
            </div>
            <div
              v-if="errors.has('email')"
              class="ui negative message"
              style="padding: 1% 0 1% 0"
            >
              <ul>
                <li>Email é obrigatório</li>
                <li>Email deve ter um formato válido</li>
              </ul>
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input
                v-model="user.password"
                v-validate="'required|min:6|max:40|verify_password'"
                type="password"
                name="password"
                placeholder="Senha"
              />
            </div>
            <div
              v-if="errors.has('password')"
              class="ui negative message"
              style="padding: 1% 0 1% 0"
            >
              <ul>
                <li>Senha é obrigatória</li>
                <li>Deve conter no mínimo 6 caracteres</li>
                <li>Deve conter no máximo 40 caracteres</li>
                <li>1 caractere especial(@#$% etc..)</li>
                <li>1 letra maiúscula</li>
                <li>1 letra minúscula</li>
                <li>1 número</li>
              </ul>
            </div>
          </div>
          <button class="ui fluid large teal submit button" :disabled="loading">
            <span
              v-show="loading"
              class="spinner-border spinner-border-sm"
            ></span>
            <span>Login</span>
          </button>
        </div>
        <div v-if="message" class="ui error message">{{ message }}</div>
      </form>

      <div class="ui message" :style="{ backgroundColor: colors.fourth }">
        <p :style="{ color: colors.fifth }"> Novo por aqui ?
        <router-link to="/register" style="color: #007FFF;">
          Crie uma conta
        </router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../models/user";
import colors from "../utils/styles/colors";
export default {
  name: "Login",
  data() {
    return {
      user: new User("", ""),
      loading: false,
      message: "",
      colors: colors,
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
  },
  created() {
    if (this.loggedIn) {
      this.$router.push("/profile");
    }
  },
  methods: {
    handleLogin() {
      this.loading = true;
      this.$validator.validateAll().then((isValid) => {
        if (!isValid) {
          this.loading = false;
          return;
        }

        if (this.user.email && this.user.password) {
          this.$store.dispatch("auth/login", this.user).then(
            () => {
              this.$router.push("/profile");
            },
            (error) => {
              this.loading = false;
              this.message =
                (error.response && error.response.data) ||
                error.message ||
                error.toString();
            }
          );
        }
      });
    },
  },
};
</script>

<style scoped>
.profile-img-card {
  width: 120px;
  height: 120px;
  margin: 0 auto 10px;
  display: block;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;
}
.image {
  margin-top: -100px;
}
.column {
  max-width: 450px;
}
</style>
