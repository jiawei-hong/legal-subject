<template>
  <div class="container">
    <button class="btn btn-primary btn-block mt-2" @click="backToMain">
      返回主頁面
    </button>
    <button class="btn btn-primary btn-block mt-2" @click="downloadXlsx">
      下載Excel
    </button>

    <div class="card" v-if="recordData[currentIndex]">
      <div class="card-header text-center">題目</div>

      <div class="card-body">
        <h5 class="card-title">
          {{ recordData[currentIndex].question }}
        </h5>

        <div class="row">
          <div class="col-sm-6">
            <div class="card">
              <div class="card-body text-center">
                <h5 class="card-title">答對率</h5>
                <p class="card-text">
                  {{
                    (recordData[currentIndex].correct /
                      (recordData[currentIndex].correct +
                        recordData[currentIndex].incorrect)) *
                      100 +
                    "%"
                  }}
                </p>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="card">
              <div class="card-body text-center">
                <h5 class="card-title">答錯率</h5>
                <p class="card-text">
                  {{
                    (recordData[currentIndex].incorrect /
                      (recordData[currentIndex].correct +
                        recordData[currentIndex].incorrect)) *
                      100 +
                    "%"
                  }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer text-center d-flex">
        <button @click="prevIndex" class="btn btn-primary w-50 mr-2">
          上一題
        </button>
        <button @click="nextIndex" class="btn btn-primary w-50 mr-2">
          下一題
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
      recordIndex: 0,
      recordData: [],
    };
  },
  mounted() {
    if (this.$store.getters.getUser.permission !== "管理員")
      this.$router.push("/");

    axios
      .post("/api/getFinishData", {
        id: this.$route.params.id,
        token: this.$store.getters.getUser.token,
      })
      .then((res) => {
        if (res.status) {
          swal
            .fire({
              title: "Message",
              text: res.data.msg,
              timer: 2000,
              timerProgressBar: true,
              showConfirmButton: false,
            })
            .then(() => {
              if (res.data.data == undefined) {
                this.$router.push("/YearSetting");
              } else {
                this.recordData = res.data.data;
                this.currentIndex = Object.keys(this.recordData)[
                  this.recordIndex
                ];
              }
            });
        }
      });
  },
  methods: {
    prevIndex() {
      if (this.recordIndex - 1 < 0) {
        this.recordIndex = Object.keys(this.recordData).length - 1;
      } else {
        this.recordIndex--;
      }

      this.currentIndex = Object.keys(this.recordData)[this.recordIndex];
    },
    nextIndex() {
      if (this.recordIndex + 1 >= Object.keys(this.recordData).length) {
        this.recordIndex = 0;
      } else {
        this.recordIndex++;
      }

      this.currentIndex = Object.keys(this.recordData)[this.recordIndex];
    },
    backToMain() {
      this.$router.push("/YearSetting");
    },
    downloadXlsx() {
      axios
        .get(`/api/xlsx/${this.$route.params.id}`, {
          headers: {
            "Content-Disposition": "attachment; filename=template.xlsx",
            "Content-Type":
              "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
          },
          responseType: "arraybuffer",
          params: {
            token: this.$store.getters.getUser.token,
          },
        })
        .then((response) => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "template.xlsx");
          document.body.appendChild(link);
          link.click();
        });
    },
  },
};
</script>
