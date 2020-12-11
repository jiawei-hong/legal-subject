<template>
    <div class="container">
        <div class="mt-3">
            <router-link class="btn btn-primary btn-block" to="createSchoolYear">新增學年度</router-link>
        </div>

        <div v-if="schoolYear">
            <div class="card-columns">
                <div class="card" v-for="item in schoolYear">
                    <div class="card-header text-center">
                        {{ item.year }}
                    </div>

                    <div class="card-body text-center">
                        <div class="dropdown mb-1">
                            <button class="btn btn-primary dropdown-toggle btn-block" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                開關功能
                            </button>
                            <div class="dropdown-menu mb-3 text-center btn-block">
                                <button
                                    class="btn w-75 mb-1"
                                    @click="toggleSchoolYear(item.id, item.isOpen)"
                                    :class="!item.isOpen ? 'btn-success' : 'btn-danger'"
                                >
                                    {{ !item.isOpen ? "開啟題庫查看" : "關閉題庫查看" }}
                                </button>

                                <button
                                    class="btn w-75 mb-1"
                                    @click="toggleExam(item.id, item.isExam)"
                                    :class="!item.isExam ? 'btn-success' : 'btn-danger'"
                                >
                                    {{ !item.isExam ? "開啟題庫測驗" : "關閉題庫測驗" }}
                                </button>

                                <button
                                    class="btn w-75 mb-1"
                                    @click="toggleAnswerRecord(item.id, item.isAnswerRecord)"
                                    :class="!item.isAnswerRecord ? 'btn-success' : 'btn-danger'"
                                >
                                    {{ !item.isAnswerRecord ? "開啟詳細資料" : "關閉詳細資料" }}
                                </button>
                            </div>
                        </div>

                        <div class="dropdown mb-1">
                            <button class="btn btn-primary dropdown-toggle btn-block" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                查看功能
                            </button>
                            <div class="dropdown-menu mb-3 text-center btn-block">
                                <router-link
                                    class="btn btn-primary w-75 mb-1"
                                    :to="'/view/SchoolYear/' + item.id"
                                >查看題庫
                                </router-link
                                >
                                <router-link
                                    class="btn btn-primary w-75 mb-1"
                                    :to="'/view/FullMarks/' + item.id"
                                >查看滿分
                                </router-link>
                                <router-link
                                    class="btn btn-primary w-75 mb-1"
                                    :to="'/view/Finish/' + item.id"
                                >查看結果
                                </router-link>
                                <router-link
                                    class="btn btn-primary w-75 mb-1"
                                    :to="'/view/AnswerRecord/' + item.id"
                                >填答紀錄
                                </router-link>
                            </div>
                        </div>

                        <div class="dropdown mb-1">
                            <button class="btn btn-primary dropdown-toggle btn-block" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                時間功能
                            </button>

                            <div class="dropdown-menu mb-3 text-center btn-block">
                                <router-link
                                    class="btn btn-primary w-75 mb-1"
                                    :to="'/createTime/' + item.id"
                                >創建時間
                                </router-link>
                                <router-link
                                    class="btn btn-primary w-75 mb-1"
                                    :to="'/modifyTime/' + item.id"
                                >修改時間
                                </router-link>
                            </div>
                        </div>
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
import {toggleSchoolYear, toggleAnswerRecord, toggleExam} from "../api";

export default {
    mounted() {
        this.$store.dispatch("getSchoolYear", this.$store.getters.getUser.token);

        if (this.$store.getters.getUser.permission !== "管理員") {
            swal.fire({
                title: "Message",
                text: "無權訪問。",
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false,
            }).then(() => {
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
        getToken(){
          return this.$store.getters.getUser.token;
        },
        getSchoolYear() {
            return this.$store.dispatch('getSchoolYear', this.getToken());
        },
        showMessage(msg){
            swal.fire({
                position: 'top-end',
                icon: 'success',
                toast: true,
                title:`訊息: ${msg}`,
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        },
        async toggleSchoolYear(id, bool) {
            let data =await toggleSchoolYear({
                id: id,
                bool: bool,
                token: this.getToken()
            });

            this.showMessage(data.msg);
            this.getSchoolYear();
        },
        async toggleAnswerRecord(id, bool) {
            let data =await toggleAnswerRecord({
                id: id,
                bool: bool,
                token: this.getToken()
            });

            this.showMessage(data.msg);
            this.getSchoolYear();
        },
        async toggleExam(id, bool) {
            let data = await toggleExam({
                id: id,
                bool: bool,
                token: this.getToken()
            });

            this.showMessage(data.msg);
            this.getSchoolYear();
        }
    },
};
</script>
