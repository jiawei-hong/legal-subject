<template>
    <div class="container">
        <button class="btn btn-primary btn-block mt-2" @click="downloadXlsx">
            下載Excel
        </button>

        <div class="container mt-3">
            <div class="scoreboard">
                <div class="item">
                    <span>班級名稱</span>
                    <span>學生學號</span>
                    <span>學生姓名</span>
                </div>

                <div v-for="(item, index) in result" class="item">
                    <span>{{ item['className'] }}</span>
                    <span>{{ item['studentNumber'] }}</span>
                    <span>{{ item['studentName'] }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getFullMarks} from "../api";

export default {
    data() {
        return {
            result: null
        }
    },
    async mounted() {
        let id = this.$route.params.id;

        this.result = await getFullMarks({
            params:{
                year_id: id,
                token: this.$store.getters.getUser.token
            }
        });
    },
    methods: {
        downloadXlsx() {
            let id = this.$route.params.id;

            axios.get(`/api/fullMarks/${id}`, {
                headers: {
                    "Content-Disposition": "attachment; filename=template.xlsx",
                    "Content-Type":
                        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                },
                responseType: "blob",
                params:{
                    year_id:id,
                    token: this.$store.getters.getUser.token
                }
            }).then((response) => {
                const url = window.URL.createObjectURL(response.data);
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
