import axios from 'axios'
import * as constants from './constants'

export const getGoodsList = ()=>{
    return (dispatch) => {
        axios.get('/admin/api/v1/goods/list').then((res)=>{
            dispatch({
                type: constants.GET_GOODS_LIST,
                data: res.data.data
            })
        });
    }
};

export const delGoods = (id)=>{
    return (dispatch)=>{
        axios.post('',{
            id:id
        })
    }
};
