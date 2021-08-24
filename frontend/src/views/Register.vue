<template>
  <div class="ui middle aligned center aligned grid">
    <div class="column" style="margin-top: 8%">
      <h2 class="ui teal image header">
        <img
          src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"
          class="profile-img-card"
        />
        <div class="content">Registrar conta</div>
      </h2>
      <form class="ui large form" @submit.prevent="handleRegister">
        <div
          class="ui stacked segment"
          :style="{ backgroundColor: colors.fourth }"
        >
          <div class="field">
            <div class="ui left icon input">
              <i class="user icon"></i>
              <input
                v-model="user.username"
                v-validate="'required|min:3|max:26|alpha_num'"
                type="text"
                name="username"
                placeholder="Nome de usuário"
                :style="{ backgroundColor: colors.fifth }"
              />
            </div>
            <div
              v-if="errors.has('username')"
              class="ui negative message"
              style="padding: 1% 0 1% 0"
            >
              <ul>
                <li>Nome de usuário é obrigatório</li>
                <li>Deve conter no mínimo 3 caracteres</li>
                <li>Deve conter no máximo 26 caracteres</li>
                <li>Não pode conter caracteres especiais (@#$% etc..)</li>
              </ul>
              <small></small>
            </div>
          </div>
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
                @input="checkConfirmPassword"
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
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input
                v-model="user.confirmPassword"
                v-validate="'required|min:6|max:40'"
                type="password"
                name="confirmPassword"
                placeholder="Repita a senha"
                @input="checkConfirmPassword"
              />
            </div>
            <div
              v-if="confirmPassError"
              class="ui negative message"
              style="padding: 1% 0 1% 0"
            >
              <ul>
                <li>Repita a senha</li>
              </ul>
            </div>
          </div>
          <button class="ui fluid large teal submit button">Registrar</button>
        </div>
      </form>
      <div v-if="errorMessages" class="ui error message">
        <ul v-for="(message, index) in errorMessages" :key="index">
          <li>{{ message }}</li>
        </ul>
      </div>
      <div v-if="successMessage" class="ui success message">
        <ul v-for="(message, index) in successMessage" :key="index">
          <li>{{ message }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../models/user";
import colors from "../utils/styles/colors";

export default {
  name: "Register",
  data() {
    return {
      user: new User("", "", "", ""),
      submitted: false,
      errorMessages: "",
      successMessage: "",
      colors: colors,
      confirmPassError: false,
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
  },
  mounted() {
    if (this.loggedIn) {
      this.$router.push("/profile");
    }
  },
  methods: {
    checkConfirmPassword() {
      if (this.user.password != this.user.confirmPassword) {
        this.confirmPassError = true;
      } else {
        this.confirmPassError = false;
      }
    },
    handleRegister() {
      this.errorMessages = "";
      this.successMessage = "";
      this.submitted = true;
      if (
        !this.user.confirmPassword ||
        this.user.password != this.user.confirmPassword
      ) {
        this.$validator.validate();
        this.confirmPassError = true;
        return;
      }
      this.$validator.validate().then((isValid) => {
        if (isValid) {
          this.$store.dispatch("auth/register", this.user).then(
            (data) => {
              this.successMessage = {};
              this.successMessage.msg1 = data.data.message;
              this.successMessage.msg2 = "Por favor, faça login.";
            },
            (error) => {
              this.errorMessages = error.response.data.data;
            }
          );
        }
      });
    },
  },
};
</script>

<style scoped>
.column {
  max-width: 450px;
}

.profile-img-card {
  width: 120px;
  height: 120px;
  margin: 0 auto 10px;
  display: block;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;
}
</style>
