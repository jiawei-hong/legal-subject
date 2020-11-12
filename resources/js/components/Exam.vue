<template>
    <div class="container">
        <div v-if="isExam === false && this.schoolYear.length > 0">
            <div class="card">
                <div class="card-header">測驗</div>

                <div class="card-body">
                    <div class="form-group text-left">
                        <label for="schoolyear">學年度:</label>
                        <select v-model="schoolYearId" class="form-control" id="schoolyear">
                            <option :value="year.id" v-for="year in schoolYear">
                                {{ year.year }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group text-left">
                        <label for="legal">測驗題庫:</label>
                        <select v-model="categoryId" class="form-control" id="legal">
                            <option :value="category.id" v-for="category in categories">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-block" @click="startExam">
                        開始測驗
                    </button>
                </div>
            </div>
        </div>

        <div class="container text-center" v-if="schoolYearId == 0">
            <div class="card">
                <div class="card-header">訊息</div>

                <div class="card-body">
                    <div class="card-text">目前沒有開放學年度提供測驗。</div>
                </div>
            </div>
        </div>

        <div v-if="isExam === true">
            <div class="d-flex mt-2">
                <button @click="prevIndex" class="btn btn-primary w-50 mr-2">
                    上一題
                </button>
                <button @click="nextIndex" class="btn btn-primary w-50 mr-2">
                    下一題
                </button>

                <button @click="fillAnswer" class="btn btn-primary w-50 mr-2">
                    填充答案
                </button>
            </div>

            <div class="card">
                <div class="card-header text-center">題目</div>

                <div class="card-body">
                    <h5 class="card-title">
                        {{
                        currentIndex +
                        1 +
                        ". " +
                        examQuestions.questions[currentIndex].question
                        }}
                    </h5>

                    <div class="form-group">
                        <div v-for="item in examQuestions.options[currentIndex]">
                            <input
                                type="radio"
                                name="currentIndex"
                                :value="item.id"
                                v-model="userAnswers[currentIndex]"
                            />
                            {{ item.value }}
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center d-flex">
                    <button class="btn btn-primary btn-block mt-3" @click="judgeAnswer">
                        結束測驗
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../api";
import {checkPermission} from "../userAPI";

export default {
    data() {
        return {
            isExam: false,
            schoolYearId: 0,
            categoryId: 0,
            currentIndex: 0,
            userAnswers: new Array(50).fill(0),
        };
    },
    async mounted() {
        let token =
            this.$store.getters.getUser.length === 0
                ? ""
                : this.$store.getters.getUser.token;

        let data = await checkPermission({token: token});

        if (data === null) {
            swal
                .fire({
                    title: "Message",
                    text: "無權訪問。",
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
                .then(() => {
                    this.$router.push("/");
                });
        }

        await this.$store.dispatch("getSchoolYear");
        await this.$store.dispatch("getCategories");
    },
    computed: {
        schoolYear() {
            let data = this.$store.getters.getSchoolYear;

            if (data == null) {
                return [];
            } else {
                data = data.filter((d) => d.isOpen && !d.isFinish);
                this.schoolYearId = data[0] === undefined ? 0 : data[0].id;
            }

            return data;
        },
        categories() {
            let data = this.$store.getters.getCategories;

            if (data == null) {
                return [];
            } else if (data.length > 0) {
                this.categoryId = data[0] === undefined ? 0 : data[0].id;
            }

            return data;
        },
        examQuestions() {
            return this.$store.getters.getViewSchoolYearData;
        },
    },
    methods: {
        startExam() {
            swal
                .fire({
                    title: "Tips",
                    text: "測驗中沒有按結束測驗的話成績一律不保存。",
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
                .then(() => {
                    axios.post("/api/users/getScoresCount", {
                        id: this.$store.getters.getUser.id,
                        yearId: this.schoolYearId,
                        token: this.$store.getters.getUser.token,
                    }).then((res) => {
                        if (res.data >= 2) {
                            swal.fire({
                                title: "Tips",
                                text: "測驗次數已經達到兩次。",
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            });
                        } else {
                            this.$store.dispatch(
                                "getViewSchoolYearData",
                                this.schoolYearId
                            );
                            this.isExam = true;
                        }
                    });
                });
        },
        prevIndex() {
            if (this.currentIndex - 1 < 0) {
                this.currentIndex = this.examQuestions.questions.length - 1;
            } else {
                this.currentIndex--;
            }
        },
        nextIndex() {
            if (this.currentIndex + 1 > this.examQuestions.questions.length - 1) {
                this.currentIndex = 0;
            } else {
                this.currentIndex++;
            }
        },
        judgeAnswer() {
            swal
                .fire({
                    title: "確定要送出了嗎?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                })
                .then((result) => {
                    if (
                        result.value &&
                        this.userAnswers.filter((d) => d === 0).length === 0
                    ) {
                        axios
                            .post("/api/users/addScore", {
                                category_id: this.categoryId,
                                year_id: this.schoolYearId,
                                user_id: this.$store.getters.getUser.id,
                                userAnswer: this.userAnswers,
                                questions: this.examQuestions.questions,
                                token: this.$store.getters.getUser.token,
                            })
                            .then(() => {
                                swal
                                    .fire({
                                        text: "成績傳送完成。",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500,
                                    })
                                    .then(() => {
                                        this.$router.push("/Scores");
                                    });
                            });
                    } else if (result.value) {
                        swal.fire({
                            text: "尚未有題目還未填寫。",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
        },
        fillAnswer() {
            this.examQuestions.options.forEach((d, i) => {
                this.userAnswers[i] = d[1].id;
            });
        },
    },
};
</script>
