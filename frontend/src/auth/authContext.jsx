import { createContext, useContext, useState } from 'react';
import { login } from './authService';
import { useAxios } from '../api/api';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {

    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState({})
    const [authenticating, setAuthenticating] = useState(true)

    const handleLogin = async (email, password) => {
        try {
            setAuthenticating(true)
            const response = await login(email, password);
            setAuthenticating(false)
            if (response.status === 200) {
                setIsAuthenticated(true);
                setUser(response.data.data.user);
            };

        } catch (error) {
            console.log(error);
        }
    }

    return (
        <AuthContext.Provider value={{user,isAuthenticated,authenticating, handleLogin}}>
            {children}
        </AuthContext.Provider>
    )
}

export const useAuth = () => useContext(AuthContext);