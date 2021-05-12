<template>
    <div class="container">
        <button class="btn btn-primary btn-block mt-2" @click="downloadXlsx">
            下載Excel
        </button>

        <div class="container mt-3">
            <table class="scoreboard text-center table table-bordered table-striped">
                <tr class="item">
                    <td>班級名稱</td>
                    <td>學生學號</td>
                    <td>學生姓名</td>
                </tr>

                <tr v-for="(item, index) in result" class="item">
                    <td>{{ item['className'] }}</td>
                    <td>{{ item['studentNumber'] }}</td>
                    <td>{{ item['studentName'] }}</td>
                </tr>
            </table>
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
