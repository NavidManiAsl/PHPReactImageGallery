const API_BASE_URL = 'http://127.0.0.1:8000/api/v1/'

const API_ENDPOINTS = {
    login: 'login',
    logout: 'logout',
    register: 'register',
}

export const API_URLS = {
    login: `${API_BASE_URL}${API_ENDPOINTS.login}`,
    logout: `${API_BASE_URL}${API_ENDPOINTS.logout}`,
    register: `${API_BASE_URL}${API_ENDPOINTS.register}`


}