<template>
    <div class="container">
        <div class="d-flex mt-2">
            <button @click="prevIndex" class="btn btn-primary w-50 mr-2">
                上一題
            </button>
            <button @click="nextIndex" class="btn btn-primary w-50 mr-2">
                下一題
            </button>
        </div>

        <div class="card" v-if="questions">
            <div class="card-header text-center">題目</div>

            <div class="card-body">
                <h5 class="card-title">
                    <span :style="{color:questions[currentIndex]['correct']
                  ? 'green'
                  : 'red'}">
                        {{ questions[currentIndex]['correct'] ? '(O)' : '(X)' }}
                    </span>
                    {{
                        currentIndex +
                        1 +
                        " . " +
                        questions[currentIndex].question
                    }}
                </h5>

                <div class="form-group">
                    <div v-for="item in questions[currentIndex]['options']">
                        <button
                            class="btn btn-lg w-100 text-left mt-2"
                            :class="
                item.id === questions[currentIndex]['answer']['option_id']
                  ? 'btn-success'
                  : 'btn-danger'
              "
                        >
                            {{ item.value }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center d-flex">
                <button class="btn btn-primary btn-block mb-1" @click="exitService">
                    結束查看
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {getScoresDetail} from "../userAPI";

export default {
    async mounted() {
        let data = await getScoresDetail({
            id: this.$route.params.id,
            userId: this.$store.getters.getUser.id,
            token: this.$store.getters.getUser.token,
        });

        if (data.status) {
            await this.$store.dispatch('setQuestions', data.data)
        } else {
            swal.fire({
                title: "Message",
                text: data.msg,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
            })
                .then(() => {
                    this.$router.push('/Scores');
                });
        }
    },
    data() {
        return {
            currentIndex: 0,
        }
    },
    computed: {
        questions() {
            return this.$store.getters.getQuestions;
        },
    },
    methods: {
        prevIndex() {
            if (this.currentIndex - 1 < 0) {
                this.currentIndex = this.questions.length - 1;
            } else {
                this.currentIndex--;
            }
        },
        nextIndex() {
            if (this.currentIndex + 1 > this.questions.length - 1) {
                this.currentIndex = 0;
            } else {
                this.currentIndex++;
            }
        },
        exitService() {
            this.$router.push('/Scores');
        }
    }
}
</script>
