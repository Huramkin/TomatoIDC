import axios from 'axios'
import * as constants from './constants'

const changeResolutionList = (ResolutionList) => ({
    type: constants.CHANGE_RESOLUTION_LIST,
    list: ResolutionList
});

export const getResolutionList = (domain)=>{
    return (dispatch) => {
        axios.get('/api/v1/admin/resolution?domain=' + domain).then((res)=>{
            const result = res.data.data;
            dispatch(changeResolutionList(result))
        });
    }
};

export const showDrawer = (selectId,selectResolution,editAddress,editType,selectResolutionId)=>{
    return ( dispatch ) =>{
        dispatch({
            type: constants.SHOW_DRAWER,
            selectId:selectId,
            selectResolution: selectResolution,
            editAddress: editAddress,
            editType:editType,
            selectResolutionId:selectResolutionId
        })
    }
};

export const closeDrawer = ()=>{
    return ( dispatch ) =>{
        dispatch({
            type: constants.CLOSE_DRAWER
        })
    }
};

export const removeResolution = (id)=>{
    return ( dispatch ) =>{
        axios.post('/api/v1/admin/resolution/del',{
            id: id
        }).then(
            dispatch({
                type: constants.DEL_RESOLUTION
            })
        )
    }
};

export const changeEditAddress = (address)=>{
    return ( dispatch ) =>{
        dispatch({
            type: constants.CHANGE_EDIT_ADDRESS,
            address: address
        })
    }
};

export const editResolution = ()=>{
    return ( dispatch ) =>{
        dispatch({
            type: constants.CLOSE_DRAWER
        })
    }
};

export const clearResolutionStatus = ()=>{
    return ( dispatch ) =>{
        dispatch({
            type: constants.CLEAR_RESOLUTION_STATUS
        })
    }
};

export const setResolution = (selectId,address,type)=>{
    return ( dispatch ) => {
        axios.post(
            "/api/v1/user/resolution/update",
            {
                id: selectId,
                address: address,
                type: type
            }
        ).then(function (resp) {
            if (resp.data.code === 0) {
                dispatch({
                    type: constants.SET_RESOLUTION_SUCCESS,
                    resp: resp.data
                })
            }else{
                dispatch({
                    type: constants.SET_RESOLUTION_FAIL,
                    resp: resp.data
                })
            }
        }).catch(function (resp) {
            dispatch({
                type: constants.SET_RESOLUTION_FAIL,
                resp: {
                    code: 1002,
                    msg: "请求错误"
                }
            })
        });
        dispatch({
            type: constants.CLOSE_DRAWER
        })
    }
};
