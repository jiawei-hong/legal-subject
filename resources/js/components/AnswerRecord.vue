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

        <div class="scoreboard">
            <div class="item">
                <span>#</span>
                <span>班級</span>
                <span>學號</span>
                <span>姓名</span>
                <span>作答一</span>
                <span>作答二</span>
            </div>

            <div v-for="(item, index) in result" class="item">
                <span>{{ index + 1 }}</span>
                <span>{{ item.student_class }}</span>
                <span>{{ item.student_number }}</span>
                <span>{{ item.student_name }}</span>
                <span>{{
                        Object.keys(item.record[0]).indexOf('score') != -1 ? item.record[0].score : item.record[0]
                    }}</span>
                <span>{{
                        Object.keys(item.record[1]).indexOf('score') != -1 ? item.record[1].score : item.record[1]
                    }}</span>
            </div>
        </div>
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
