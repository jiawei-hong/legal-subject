<template>
    <div class="mt-2">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">選擇班級</span>
            </div>
            <select v-model="searchClass" class="form-control">
                <option value="">
                    全部班級
                </option>
                <option :value="item" v-for="item in schoolClass">
                    {{ item }}
                </option>
            </select>
        </div>

        <table class="scoreboard table table-dark">
            <tr class="item">
                <td>#</td>
                <td>班級</td>
                <td>學號</td>
                <td>姓名</td>
                <td>作答一</td>
                <td>作答二</td>
            </tr>

            <tr v-for="(item, index) in result" class="item">
                <td>{{ index + 1 }}</td>
                <td>{{ item.student_class }}</td>
                <td>{{ item.student_number }}</td>
                <td>{{ item.student_name }}</td>
                <td>{{
                        Object.keys(item.record[0]).indexOf('score') != -1 ? item.record[0].score : item.record[0]
                    }}</td>
                <td>{{
                        Object.keys(item.record[1]).indexOf('score') != -1 ? item.record[1].score : item.record[1]
                    }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
import {getUserAnswerRecord} from "../api";

export default {
    data() {
        return {
            searchClass: ''
        }
    },
    async mounted() {
        let data = await getUserAnswerRecord({
            year_id: this.$route.params.id,
            token: this.$store.getters.getUser.token
        });

        await this.$store.dispatch('getAnswerRecord', data.data);
    },
    computed: {
        result() {
            if (this.searchClass !== '') {
                return this.$store.getters.getAnswerRecord.filter(d => d['student_class'] === this.searchClass);
            }

            return this.$store.getters.getAnswerRecord;
        },
        schoolClass() {
            return new Set(this.$store.getters.getAnswerRecord.map(d => d['student_class']));
        }
    }
}
</script>
