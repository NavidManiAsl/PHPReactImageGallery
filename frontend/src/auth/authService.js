import {apiPost} from '../api/api';
import  {API_URLS}  from '../api/apiConfig';'../api/apiConfig'

export const login = async (email, password) => 
{
    const payload = ({email:email, password:password})
    return await apiPost(API_URLS.login,payload);
     
} 