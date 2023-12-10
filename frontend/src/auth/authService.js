import {apiPost} from '../api/api';
import  {API_URLS}  from '../api/apiConfig';'../api/apiConfig'

export const login = async (formData) => 
{
    const{email,password} = formData
    const payload = ({email:email, password:password})
    return await apiPost(API_URLS.login,payload);
     
} 

export const register = async (formData)=>{
    const {username, email, password,passwordConfirmation} = formData;
    const payload = ({name:username, email:email, password:password, password_confirmation:passwordConfirmation})
    console.log(payload)
    const result = await apiPost(API_URLS.register,payload);
    console.log(result)
}