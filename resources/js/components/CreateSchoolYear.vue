<template>
    <div class="container">
        <input type="file" name="file" id="questionFile" style="display: none"/>
        <div class="mt-3">
            <button @click="redirectToYearSetting" class="btn btn-primary btn-block">
                返回學年度設置
            </button>
        </div>

        <div class="card">
            <div class="card-header">創建學年度</div>

            <div class="card-body">
                <div class="mb-2">
                    學年度
                    <input
                        type="text"
                        class="form-control"
                        v-model="schoolYear"
                        placeholder="請輸入學年度 Ex:109-1"
                    />
                </div>

                <div class="mb-2">
                    <button @click="createSchoolYear" class="btn btn-primary w-100">
                        創建
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            schoolYear: null,
        };
    },
    methods: {
        createSchoolYear() {
            let regex = /\d{3}-\d{1}$/u;

            if (regex.test(this.schoolYear)) {
                axios
                    .post("/api/addSchoolYear", {
                        schoolYear: this.schoolYear,
                        token: this.$store.getters.getUser.token,
                    })
                    .then(async (res) => {
                        await this.selectQuestionFile(res.data.data).then(() => {
                            swal.fire({
                                title: "Message",
                                text: res.data.msg,
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            })
                        });
                    });
            } else {
                swal
                    .fire({
                        title: "Message",
                        text: "請填入學年度或格式錯誤。",
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    })
                    .then(() => {
                        this.schoolYear = "";
                    });
            }
        },
        redirectToYearSetting: function () {
            this.$router.push("/YearSetting");
        },
        async selectQuestionFile(id) {
            let file = document.querySelector("#questionFile");
            let data = new FormData();
            let token = this.$store.getters.getUser.token;

            file.addEventListener("change", async (e) => {
                data.append("file", e.target.files[0]);
                data.append("token", token);
                data.append("yearId",id);
                swal.fire({
                    title: "Message",
                    text: "導入題目資料處理中，導入完成會有新的提示，請耐心等候",
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });

                let x = await axios.post("/api/importQuestion", data).then(res => res.data);

                swal.fire({
                    title: "Message",
                    text: `${x.msg}`,
                    showConfirmButton: true,
                }).then(() => {
                    this.$router.push('/YearSetting');
                });
            });

            file.click();
        },
    },
};
</script>
