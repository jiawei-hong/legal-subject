<template>
    <div class="container">
        <input type="file" name="file" id="questionFile" style="display: none"/>
        <div class="mt-3">
            <router-link class="btn btn-primary btn-block" to="YearSetting">返回學年度設置</router-link>
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
import {addSchoolYear} from "../api";

export default {
    data() {
        return {
            schoolYear: null,
        };
    },
    methods: {
        async createSchoolYear() {
            let regex = /\d{3}-\d{1}$/u;

            if (regex.test(this.schoolYear)) {
                let data = await addSchoolYear({
                    schoolYear: this.schoolYear,
                    token: this.$store.getters.getUser.token,
                })

                if(data.status)
                    await this.selectQuestionFile(data.id);


                swal.fire({
                    title: "Message",
                    text: data.msg,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
            } else {
                swal.fire({
                    title: "Message",
                    text: "請填入學年度或格式錯誤。",
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(() => {
                    this.schoolYear = "";
                });
            }
        },
        async selectQuestionFile(id) {
            let file = document.querySelector("#questionFile");
            let data = new FormData();
            let token = this.$store.getters.getUser.token;

            file.addEventListener("change", async (e) => {
                data.append("file", e.target.files[0]);
                data.append("token", token);
                data.append("yearId", id);
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
