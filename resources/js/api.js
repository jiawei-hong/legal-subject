import Axios from 'axios';

const baseRequest = Axios.create({
    baseURL: '/legal_subject/api/'
})

const adminRequest = Axios.create({
    baseURL: '/legal_subject/api/admin/'
})

const userRequest = Axios.create({
    baseURL: '/legal_subject/api/users/'
});


// base request method
export const userLogin = data => baseRequest.post('login', data).then(res => res.data);
export const userLogout = token => baseRequest.patch('logout', token).then(res => res.data);
export const getCategories = () => baseRequest.get('getCategories').then(res => res.data);
export const getSchoolYear = () => baseRequest.get('getSchoolYear').then(res => res.data);
export const getSchoolYearQuestions = config => baseRequest.get('getSchoolYearQuestions', config).then(res => res.data);
export const checkPermission = data => baseRequest.post('checkPermission', data).then(res => res.data);


// user request method
export const getUserScores = data => userRequest.post('getScores', data).then(res => res.data);
export const getScoresDetail = data => userRequest.post('getScoresDetail', data).then(res => res.data);
export const getScoresCount = data => userRequest.post('getScoresCount', data).then(res => res.data);
export const addScore = data => userRequest.post('addScore', data).then(res => res.data);

// admin request method
export const createUsers = data => adminRequest.post('createUsers', data).then(res => res.data);
export const toggleSchoolYear = data => adminRequest.post('toggleSchoolYear', data).then(res => res.data);
export const toggleExam = data => adminRequest.post('toggleExam', data).then(res => res.data);
export const toggleAnswerRecord = data => adminRequest.post('toggleAnswerRecord', data).then(res => res.data);
export const getUserAnswerRecord = data => adminRequest.post('getUserAnswerRecord', data).then(res => res.data);
export const getFullMarks = data => adminRequest.get('getFullMarks', data).then(res => res.data);
export const addSchoolYear = data => adminRequest.post('addSchoolYear', data).then(res => res.data);
