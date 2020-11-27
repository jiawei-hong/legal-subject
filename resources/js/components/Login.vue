<template>
  <div class="container">
    <div class="card">
      <div class="card-header">登入</div>

      <div class="card-body">
        <div class="mb-2">
          帳號：
          <input
            type="text"
            class="form-control"
            v-model="account"
            placeholder="請輸入帳號"
            @keypress.enter="loginProcess"
          />
        </div>

        <div class="mb-2">
          密碼：
          <input
            type="password"
            class="form-control"
            v-model="password"
            placeholder="請輸入密碼"
            @keypress.enter="loginProcess"
          />
        </div>

        <div class="mb-2 text-center d-flex">
          <button @click="loginProcess" class="btn btn-primary w-50 mr-1">
            登入
          </button>
          <button @click="resetProcess" class="btn btn-primary w-50 mr-1">
            重設
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { userLogin } from "../api";

export default {
  data() {
    return {
      account: null,
      password: null,
    };
  },
  methods: {
    async loginProcess() {
      let data = await userLogin({
        account: this.account,
        password: this.password,
      });

      if (data.data != null) {
        this.$store.dispatch("setUser", data.data);
      }

      swal
        .fire({
          title: "Message",
          text: data.msg,
          timer: 3000,
          timerProgressBar: true,
          showConfirmButton: false,
        })
        .then(() => {
          data.status ? this.$router.push("/") : this.resetProcess();
        });
    },
    resetProcess() {
      this.account = null;
      this.password = null;
    },
  },
};
</script>
