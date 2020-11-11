import Axios from 'axios';

const baseRequest = Axios.create({
    baseURL: 'api/'
})

const adminRequest = Axios.create({
    baseURL : 'api/admin/'
})

const userRequest = Axios.create({
    baseURL: 'api/users/'
});

export const userLogin = data => baseRequest.post('login', data).then(res => res.data);
export const userLogout = token => baseRequest.patch('logout', token).then(res => res.data);
export const getUserScores = data => userRequest.post('getScores',data).then(res => res.data);
export const createUsers = data => adminRequest.post('createUsers',data).then(res => res.data);
