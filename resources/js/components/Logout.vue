<template></template>

<script>
import { userLogout } from "../userAPI";

export default {
  async mounted() {
    swal.fire({
      title: "Message",
      text: "登出成功!",
      timer: 2000,
      timerProgressBar: true,
      showConfirmButton: false,
    });

    await userLogout({ token: this.$store.getters.getUser.token });
    this.$store.dispatch("logout");
    this.$router.push("/");
  },
};
</script>
