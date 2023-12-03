import axios from 'axios';

export const apiGet = async (uri, data = null) => {
    const params = { params: {} }
    data && Object.entries(data).forEach(([key, value]) => {
        params.params[key] = value;
    });

    try {
        return await axios.get(uri, params)
    } catch (error) {
        //TODO error handling
        console.log(error);
    }
}

export const apiPost = async (uri, data) => {
    const params = { params: {} }
    Object.entries(data).forEach(([key, value]) => {
        params.params[key] = value;
    });

    try { 
        return await axios.post(uri, params);
    } catch (error) {
        console.log(error);
    }

}

export const apiDelete = async(uri,data =null) =>
{
    const params = {params:{}};
    Object.entries(data).forEach(([key,value])=>{
        params.params[key] =value;
    });

    try {
        return await axios.delete(uri,params);
    } catch (error) {
        console.log(error)
    }
}

