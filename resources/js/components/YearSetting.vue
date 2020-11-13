<template>
    <div class="container">
        <div class="mt-3">
            <button
                @click="redirectToCreateSchoolYear"
                class="btn btn-primary btn-block"
            >
                新增學年度
            </button>
        </div>

        <div v-if="schoolYear">
            <div class="card-columns">
                <div class="card" v-for="item in schoolYear">
                    <div class="card-header text-center">
                        {{ item.year }}
                    </div>

                    <div class="card-body text-center">
                        <button
                            class="btn btn-block"
                            @click="openSchoolYear(item.id, item.isOpen)"
                            :class="!item.isOpen ? 'btn-success' : 'btn-danger'"
                        >
                            {{ !item.isOpen ? "開啟" : "關閉" }}
                        </button>
                        <router-link
                            class="btn btn-primary btn-block"
                            :to="'/view/SchoolYear/' + item.id"
                        >查看題庫
                        </router-link
                        >
                        <router-link
                            class="btn btn-primary btn-block"
                            :to="'/view/FullMarks/' + item.id"
                        >查看滿分
                        </router-link>
                        <router-link
                            class="btn btn-primary btn-block"
                            :to="'/view/Finish/' + item.id"
                        >查看結果
                        </router-link>
                        <router-link
                            class="btn btn-primary btn-block"
                            :to="'/view/AnswerRecord/' + item.id"
                        >填答紀錄
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="card">
                <div class="card-header">訊息</div>

                <div class="card-body text-left">
                    <div class="card-text ml-5">目前沒有任何的學年度。</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {toggleSchoolYear} from "../userAPI";

    export default {
        mounted() {
            this.$store.dispatch("getSchoolYear", this.$store.getters.getUser.token);

            if (this.$store.getters.getUser.permission !== "管理員") {
                swal
                    .fire({
                        title: "Message",
                        text: "無權訪問。",
                        timer: 1000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    })
                    .then(() => {
                        this.$router.push("/");
                    });
            }
        },
        computed: {
            schoolYear() {
                return this.$store.getters.getSchoolYear;
            },
        },
        methods: {
            redirectToCreateSchoolYear() {
                this.$router.push("/createSchoolYear");
            },
            async openSchoolYear(id, bool) {
                swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    toast: true,
                    text: "進行操作中，請稍後。",
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });

                let token = this.$store.getters.getUser.token;
                let data = await toggleSchoolYear({
                    id: id,
                    bool: bool,
                    token: token
                });

                await this.$store.dispatch("getSchoolYear", token);
            },
        },
    };
</script>
