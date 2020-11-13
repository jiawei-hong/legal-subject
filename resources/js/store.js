import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import createPersistedState from 'vuex-persistedstate';
import { getUserScores,getCategories,getSchoolYear,getSchoolYearQuestions } from './userAPI';

Vue.use(Vuex);

const config = {
    userData:[],
    schoolYear:[],
    viewSchoolYearData:[],
    categories:[],
    scores:[],
    questions:[],
    answerRecord:[],
};

export default new Vuex.Store({
    plugins:[
        createPersistedState()
    ],
    state:config,
    getters:{
        getUser: state => state.userData,
        getSchoolYear:state => state.schoolYear,
        getViewSchoolYearData:state => state.viewSchoolYearData,
        getCategories: state => state.categories,
        getScores: state => state.scores,
        getQuestions: state => state.questions,
        getAnswerRecord: state => state.answerRecord,
    },
    mutations:{
        setUser: (state,payload) => state.userData = payload,
        setSchoolYear: (state,payload) => state.schoolYear = payload,
        setViewSchoolYearData: (state,payload) => state.viewSchoolYearData = payload,
        setCategories: (state,payload) => state.categories = payload,
        setScores:(state,payload) => state.scores = payload,
        logout: state => state.userData = [],
        setQuestions: (state,payload) => state.questions = payload,
        setAnswerRecord: (state,payload) => state.answerRecord = payload,
    },
    actions:{
        setUser({commit},payload){
            commit('setUser',payload);
        },
        logout({commit}){
            commit('logout');
        },
        async getSchoolYear({commit}){
            let data = await getSchoolYear();

            commit('setSchoolYear',data);
        },
        async getViewSchoolYearData({commit},id){
            let data = await getSchoolYearQuestions({
                params:{
                    id:id
                }
            });

            commit('setViewSchoolYearData',data);
        },
        async getCategories({commit}){
            let data = await getCategories();

            commit('setCategories',data);
        },
        async getScores({commit},data){
            let scoresData = await getUserScores(data);

            commit('setScores',scoresData);
        },
        getQuestions({commit},data){
            Axios.post('/api/getQuestions',data).then(res => commit('setQuestions',res.data));
        },
        setQuestions({commit},data){
            commit('setQuestions',data);
        },
        getAnswerRecord({commit},payload){
            commit('setAnswerRecord',payload);
        }
    }
});
