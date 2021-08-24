import axios from 'axios';

const API_URL = 'http://localhost:4747/';

class AuthService {
    login(user) {
        return axios
            .post(API_URL + 'login', {
                email: user.email,
                password: user.password
            })
            .then(response => {
                if (response.data.data.token) {
                    localStorage.setItem('user', JSON.stringify(response.data.data));
                }
                return response.data.data;
            });
    }
    logout() {
        localStorage.removeItem('user');
    }
    register(user) {
        return axios.post(API_URL + 'register', {
            username: user.username,
            email: user.email,
            password: user.password,
            confirmPassword: user.confirmPassword
        });
    }
}

export default new AuthService();
