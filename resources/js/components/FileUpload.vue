<template>
    <div class="container">
        <div class="form-group">
            <input type="file" name="file" id="studentFile" style="display: none"/>
            <span>
        導入學生資料(.xlsx):
        <input
            type="button"
            id="selectStudentFileBtn"
            class="btn btn-primary btn-block mt-2"
            value="選取檔案"
            @click="selectStudentFile"
        />
      </span>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            async selectStudentFile() {
                let file = document.querySelector("#studentFile");
                let selectFileBtn = document.querySelector("#selectStudentFileBtn");
                let data = new FormData();
                let token = this.$store.getters.getUser.token;

                file.addEventListener("change", (e) => {
                    selectFileBtn.value = e.target.files[0].name;
                    data.append("file", e.target.files[0]);
                    data.append("token", token);
                    swal.fire({
                        title: "Message",
                        text: "導入學生資料處理中，導入完成會有新的提示，請耐心等候",
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                    axios.post("/api/createUsers", data).then((res) => {
                        console.log(res);
                        swal.fire({
                            title: "Message",
                            text: `${res.data.msg}`,
                            showConfirmButton: true,
                        });
                    });
                });

                file.click();
            }
        },
    };
</script>
