import { useState, useEffect } from 'react'
import axios from 'axios';
import { API_BASE_URL, API_ENDPOINTS } from './apiConfig';


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


    try {
        return await axios.post(uri, data);
    } catch (error) {
        console.log(error);
    }

}

export const apiDelete = async (uri, data = null) => {
    const params = { params: {} };
    Object.entries(data).forEach(([key, value]) => {
        params.params[key] = value;
    });

    try {
        return await axios.delete(uri, params);
    } catch (error) {
        console.log(error)
    }
}


export const useAxios = (url, method, params) => {
    const [response, setResponse] = useState(null);
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(
        () => {
            const controller = new AbortController;

            const fetchData = async () => {
                try {
                    const result = await axios({
                        baseURL: API_BASE_URL,
                        url: url,
                        method: method,
                        params: params,
                        signal: controller.signal
                    })
                    setResponse(result);
                } catch (error) {
                    setError(error)
                } finally {
                    setIsLoading(false)
                }
            }
            fetchData();
            return () => {
                controller.abort();
            }, []
        },
    )

    return [response, error, isLoading];
}
