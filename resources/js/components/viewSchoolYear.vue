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

    <div class="card" v-if="examQuestions.questions">
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
            <button
              class="btn btn-lg w-100 text-left mt-2"
              :class="
                item.id === examQuestions.answers[currentIndex].option_id
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
        <button class="btn btn-primary btn-block mb-1" @click="backIndex">
          結束查看
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../api";

export default {
  data() {
    return {
      currentIndex: 0,
    };
  },
  mounted() {
    let id = this.$route.params.id;

    this.$store.dispatch("getQuestions", { id: id });

    swal.fire({
      title: "Message",
      text: "載入題目中，請稍後。",
      timer: 3000,
      timerProgressBar: true,
      showConfirmButton: false,
    });
  },
  computed: {
    examQuestions() {
      return this.$store.getters.getQuestions;
    },
  },
  methods: {
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
    backIndex() {
      let permission = this.$store.getters.getUser.permission;

      if (permission == "管理員") this.$router.push("/YearSetting");
      else this.$router.push("/");
    },
  },
};
</script>
