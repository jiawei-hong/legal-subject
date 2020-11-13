<template>
    <div class="container mt-3">
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
                <span>{{ item.record[0] }}</span>
                <span>{{ item.record[1] }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    import { getUserAnswerRecord } from "../userAPI";

    export default {
        async mounted(){
            let data = await getUserAnswerRecord({
                year_id: this.$route.params.id,
                token:this.$store.getters.getUser.token
            });

            console.log(data.data);
            this.$store.dispatch('getAnswerRecord',data.data);
        },
        computed:{
            result(){
                return this.$store.getters.getAnswerRecord;
            }
        }
    }
</script>
