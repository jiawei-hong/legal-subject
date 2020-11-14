<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                最新訊息
            </div>

            <div class="card-body text-left">
                <div class="card-text ml-5">
                    管理員:
                    登入 -> 學年度設置 -> 新增學年度 | 開啟學年度

                    <br>

                    學生端:
                    登入 -> 測驗 -> 選擇學年度 -> 開始測驗
                </div>
            </div>

            <div class="card-footer text-center">
                {{ time }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        time: function () {
            return new Date().toLocaleDateString();
        }
    }
}
</script>
