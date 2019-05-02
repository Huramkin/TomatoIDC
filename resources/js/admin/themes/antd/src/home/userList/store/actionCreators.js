import axios from 'axios'
import * as constants from './constants'


const changeUserList = (DomainList) => ({
    type: constants.CHANGE_USER_LIST,
    list: DomainList
});

export const getUserList = ()=>{
    return (dispatch) => {
        axios.get('/api/v1/admin/user').then((res)=>{
            const result = res.data.data;
            dispatch(changeUserList(result))
        });
    }
};

export const getUserLoginUrl = (email,id)=>{
    return (dispatch) => {
        axios.post('/api/v1/admin/make/user/url',{
            email:email
        }).then((res)=>{
            const result = res.data;
            dispatch({
                type: constants.GET_USER_LOGIN_URL,
                data: result
            })
        });
    }
};
