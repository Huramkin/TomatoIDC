import axios from 'axios'
import * as constants from './constants'

export const getServersList = ()=>{
    return (dispatch) => {
        axios.get('/admin/api/v1/index').then((res)=>{
            dispatch({
                type: constants.GET_SERVERS_LIST,
                data: res.data.data
            })
        });
    }
};
