<template>
  <div class="container">
    <div v-if="this.schoolYear.length > 0">
      <div class="card">
        <div class="card-header">題庫</div>

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

          <router-link
            class="btn btn-primary btn-block"
            :to="'/view/SchoolYear/' + schoolYearId"
            >查看題庫</router-link
          >
        </div>
      </div>
    </div>

    <div class="container text-center" v-if="schoolYearId == 0">
      <div class="card">
        <div class="card-header">訊息</div>

        <div class="card-body">
          <div class="card-text">目前沒有開放學年度題庫查看。</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../api";

export default {
  data() {
    return {
      schoolYearId: 0,
      categoryId: 0,
      currentIndex: 0,
    };
  },
  mounted() {
    this.$store.dispatch("getSchoolYear");
    this.$store.dispatch("getCategories");
  },
  computed: {
    schoolYear() {
      let data = this.$store.getters.getSchoolYear;

      if (data == null) {
        return [];
      } else {
        data = data.filter((d) => d.isOpen && !d.isFinish);
        this.schoolYearId = data[0] == undefined ? 0 : data[0].id;
      }

      return data;
    },
    categories() {
      let data = this.$store.getters.getCategories;

      if (data == null) {
        return [];
      } else if (data.length > 0) {
        this.categoryId = data[0] == undefined ? 0 : data[0].id;
      }

      return data;
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
  },
};
</script>
