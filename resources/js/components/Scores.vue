<template>
    <div class="row">
        <div class="col-sm-6" v-for="score in scores">
            <div class="card text-center">
                <div class="card-header">
                    {{ score[1] }}
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ score[2] + '學年度' }}</h5>
                    <p class="card-text">測驗分數：{{ score[3] }}</p>
                    <router-link v-if="score[5] === 1" class="btn btn-primary btn-block"
                                 :to="'view/scores/' + score[0]">詳細資料
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {checkPermission} from "../api";

export default {
    async mounted() {
        let token = this.$store.getters.getUser.token;
        let data = await checkPermission({token: token});

        if (data === null || data !== '學生') {
            await this.$router.push("/");
        }

        await this.$store.dispatch("getScores", {
            id: this.$store.getters.getUser.id,
            token: token,
        });
    },
    computed: {
        scores() {
            return this.$store.getters.getScores;
        }
    }
};
</script>
