import { createContext, useContext, useState } from 'react';
import { login } from './authService';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {

    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState({})

    const handleLogin = async (email, password) => {
        try {
            const response = await login(email, password);
            
            if (response.status === 200) {
                setIsAuthenticated(true);
                setUser(response.data.data.user);
            };

        } catch (error) {
            console.log(error);
        }
    }

    return (
        <AuthContext.Provider value={{user,isAuthenticated, handleLogin}}>
            {children}
        </AuthContext.Provider>
    )
}

export const useAuth = () => useContext(AuthContext);