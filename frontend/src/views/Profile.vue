<template>
  <div class="ui middle aligned center aligned grid">
    <div class="column" style="margin-top: 8%">
      <h2 class="ui teal image header">
        <img
          src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"
          class="profile-img-card"
        />
        <div class="content">Atualizar meus dados</div>
      </h2>
      <form
        class="ui large form"
        @submit.prevent="handleUpdate"
        data-vv-scope="form-1"
      >
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
                @input="checkUsername"
              />
            </div>
            <div
              v-if="usernameError"
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
                type="text"
                name="email"
                placeholder="Email"
                :style="{ backgroundColor: colors.fifth }"
                @input="checkEmail"
              />
            </div>
            <div
              v-if="mailError"
              class="ui negative message"
              style="padding: 1% 0 1% 0"
            >
              <ul>
                <li>Email é obrigatório</li>
                <li>Email deve ter um formato válido</li>
              </ul>
            </div>
          </div>
          <button class="ui fluid large teal submit button">Atualizar</button>
        </div>
      </form>
      <div v-if="errorMessages" class="ui error message">
        <ul v-for="(message, index) in errorMessages" :key="index">
          <li>{{ message }}</li>
        </ul>
      </div>
      <h2 class="ui orange image header" style="margin-top: 8%">
        Atualizar Senha
      </h2>
      <form
        class="ui large form"
        @submit.prevent="handleUpdatePassword"
        data-vv-scope="form-2"
      >
        <div
          class="ui stacked segment"
          :style="{ backgroundColor: colors.fourth }"
        >
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input
                v-model="user.password"
                v-validate="'required|min:6|max:40|verify_password'"
                type="password"
                name="password"
                placeholder="Nova senha"
                @input="checkPassword"
              />
            </div>
            <div
              v-if="passwordError"
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
                placeholder="Repita a nova senha"
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
          <button class="ui fluid large orange submit button">
            Atualizar senha
          </button>
        </div>
      </form>
      <div v-if="successMessage" class="ui success message">
        <li>{{ successMessage }}</li>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../models/user";
import colors from "../utils/styles/colors";
import axios from "axios";
import authHeader from "../services/auth-header";

const API_URL = "http://localhost:4747/";

export default {
  name: "Profile",
  data() {
    return {
      user: new User("", "", "", ""),
      submitted: false,
      errorMessages: "",
      successMessage: "",
      mailError: false,
      usernameError: false,
      passwordError: false,
      colors: colors,
      confirmPassError: false,
    };
  },
  mounted() {
    if (!this.currentUser) {
      this.$router.push("/login");
    }
    this.user.username = this.currentUser.username;
    this.user.email = this.currentUser.email;
  },
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
  },
  methods: {
    checkPassword() {
      this.checkConfirmPassword();
      var strongRegex = new RegExp(
        "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
      );
      if (!strongRegex.test(this.user.password)) {
        this.passwordError = true;
      } else {
        this.passwordError = false;
      }
    },
    checkConfirmPassword() {
      if (
        this.user.password != this.user.confirmPassword ||
        !this.user.confirmPassword
      ) {
        this.confirmPassError = true;
      } else {
        this.confirmPassError = false;
      }
    },
    checkUsername() {
      const re = /^[a-z0-9]+$/i;
      if (re.test(this.user.username)) {
        this.usernameError = false;
      } else {
        this.usernameError = true;
      }
    },
    checkEmail() {
      const re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (re.test(String(this.user.email).toLowerCase())) {
        this.mailError = false;
      } else {
        this.mailError = true;
      }
    },
    handleUpdate() {
      this.errorMessages = "";
      this.successMessage = "";
      this.submitted = true;
      if (!this.usernameError && !this.mailError) {
        axios
          .post(
            API_URL + "users/update",
            {
              username: this.user.username,
              email: this.user.email,
            },
            {
              headers: authHeader(),
            }
          )
          .then((response) => {
            if (response.data) {
              this.successMessage = "Dados atualizados com sucesso.";
            }
          })
          .catch((error) => {
            if (error.response) {
              this.errorMessages = error.response.data.data;
            }
          });
      }
    },
    handleUpdatePassword() {
      this.errorMessages = "";
      this.successMessage = "";
      this.submitted = true;
      this.checkPassword();
      if (this.confirmPassError || this.passwordError) {
        return;
      }
      axios
        .post(
          API_URL + "users/updatePassword",
          {
            password: this.user.password,
            confirmPassword: this.user.confirmPassword,
          },
          {
            headers: authHeader(),
          }
        )
        .then((response) => {
          if (response.data) {
            this.successMessage = "Dados atualizados com sucesso.";
          }
        })
        .catch((error) => {
          if (error.response.data) {
            this.errorMessages = error.response.data.data;
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
