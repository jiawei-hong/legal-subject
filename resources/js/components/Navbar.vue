<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <router-link class="navbar-brand" to="/">法律常識</router-link>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown" v-if="userData.length != 0">
            <span
                id="navbarDropdown"
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
              {{ userData.username }}
            </span>

                        <div
                            class="dropdown-menu dropdown-menu-right"
                            aria-labelledby="navbarDropdown"
                        >
                            <div v-if="userData.permission == '管理員'">
                                <router-link to="/Upload" class="nav-link">上傳檔案</router-link>
                                <router-link to="/YearSetting" class="nav-link">管理學年度</router-link>
                            </div>

                            <div v-else>
                                <router-link to="/Exam" class="nav-link">測驗</router-link>
                                <router-link to="/Scores" class="nav-link">分數</router-link>
                            </div>

                            <router-link to="/Logout" class="nav-link">登出</router-link>
                        </div>
                    </li>

                    <li class="nav-item" v-else>
                        <router-link to="/Login" class="nav-link">登入 <span class="sr-only">(current)</span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    computed: {
        userData: function () {
            return this.$store.getters.getUser;
        },
    },
};
</script>
