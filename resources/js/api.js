import axios from 'axios';

export default {
    getSchoolYear(token) {
        return axios.get('/api/getSchoolYear',{
            params:{
                token:token
            }
        }).then(res => {
            if (res.status)
                return res.data;
        })
    },
    switchSchool(id, bool,token) {
        return axios.post('api/switchSchoolYear', {
            id: id,
            bool: bool,
            token:token
        }).then(res => {
            if (res.status)
               return res.data;
        });
    },
    getSchoolYearQuestions (id){
        return axios.get('/api/getSchoolYearQuestions',{
            params:{
                id:id
            }
        }).then(res => {
            if (res.status)
                return res.data;
        });
    },
    getCategories() {
        return axios.get('/api/getCategories').then(res => {
            if (res.status)
                return res.data;
        });
    },
    getCheckPermission(token) {
        return axios.post('/api/checkPermission', {
            token: token
        }).then(res => {
            if (res.status)
                return res.data;
        });
    }
}
