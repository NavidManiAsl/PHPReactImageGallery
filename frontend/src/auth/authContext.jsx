import { createContext, useContext, useState } from 'react';
import { login } from './authService';


const AuthContext = createContext();

export const AuthProvider = ({ children }) => {

    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState({})
    const [authenticating, setAuthenticating] = useState(true)

    const handleLogin = async (formData) => {
        if(isAuthenticated)return   
        try {
            setAuthenticating(true)
            const response = await login(formData);
            console.log(response);
            setAuthenticating(false)
            if (response?.status === 200) {
                setIsAuthenticated(true);
                setUser(response.data.data.user);
                document.cookie = `api_token=${response.data.data.token}`
                
            };

        } catch (error) {
            console.log(error)
        }
    }

    return (
        <AuthContext.Provider value={{user,isAuthenticated,authenticating, handleLogin}}>
            {children}
        </AuthContext.Provider>
    )
}

export const useAuth = () => useContext(AuthContext);