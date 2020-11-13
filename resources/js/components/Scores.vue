<template>
    <div class="row">
        <div class="col-sm-6" v-for="(item, index) in scores">
            <div class="card text-center">
                <div class="card-header">
                    {{ item[1] }}
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ item[2] + '學年度' }}</h5>
                    <p class="card-text">測驗分數：{{ item[3] }}</p>
                    <router-link class="btn btn-primary btn-block" :to="'view/scores/' + item[0]">詳細資料</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {checkPermission} from "../userAPI";

export default {
    async mounted() {
        let token = (this.$store.getters.getUser.length = 0
            ? ""
            : this.$store.getters.getUser.token);

        let data = await checkPermission({token: token});

        if (data === null || data !== '學生') {
            swal.fire({
                title: "Message",
                text: "無權訪問。",
                timer: 100,
                timerProgressBar: true,
                showConfirmButton: false,
            }).then(() => {
                this.$router.push("/");
            });
        } else {
            await this.$store.dispatch("getScores", {
                id: this.$store.getters.getUser.id,
                token: token,
            });
        }
    },
    computed: {
        scores: function () {
            return this.$store.getters.getScores;
        }
        ,
    }
};
</script>
