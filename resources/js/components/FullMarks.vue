<template>
    <div class="container">
        <button class="btn btn-primary btn-block mt-2" @click="downloadXlsx">
            下載Excel
        </button>

        <div class="container mt-3">
            <div class="scoreboard">
                <div class="item">
                    <span>#</span>
                    <span>班級名稱</span>
                    <span>學生學號</span>
                    <span>學生姓名</span>
                </div>

                <div v-for="(item, index) in result" class="item">
                    <span>{{ index + 1 }}</span>
                    <span>{{ item['className'] }}</span>
                    <span>{{ item['studentNumber'] }}</span>
                    <span>{{ item['studentName'] }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
      return {
          result:null
      }
    },
    mounted() {
        let id = this.$route.params.id;

        axios.post(`api/getFullMarks/${id}`,{
            token:this.$store.getters.getUser.token
        }).then(res => this.result = res.data);
    },
    methods: {
        downloadXlsx() {
            axios
                .get(`/api/fullMarks/${this.$route.params.id}`, {
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
