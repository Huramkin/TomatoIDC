import axios from 'axios'
import * as constants from './constants'

const changeDomainList = (DomainList) => ({
    type: constants.CHANGE_DOMAIN_LIST,
    list: DomainList
});

export const getDomainList = ()=>{
    return (dispatch) => {
        axios.get('/api/v1/admin/domain').then((res)=>{
            const result = res.data.data;
            dispatch(changeDomainList(result))
        });
    }
};
export const DelDomain = (domain)=>{
    return (dispatch) => {
        axios.post('/api/v1/admin/domain/del',{
            domain : domain
        }).then((res)=>{
            dispatch({
                type: constants.DEL_DOMAIN,
            })
        });
    }
};
export const setSyncForm = (platform,key,token,syncResolution)=>{
    return (dispatch) => {
        axios.post('/api/v1/dnspod/sync/domain',{
            id: key,
            token: token,
            syncResolution: syncResolution
        }).then((res)=>{
            const result = res.data.data;
            dispatch({
                type: constants.SET_SYNC_FORM,
                data: result,
                errMsg: null
            })
        }).catch((res)=>{
            const result = res.data.data;
            dispatch({
                type: constants.SET_SYNC_FORM,
                data: result,
                errMsg: result
            })
        });
        dispatch({
            type: constants.SET_SYNC_FORM,
            data: null,
            errMsg: "error"
        })
    }
};
export const setAddForm = (platform,domain,key,token)=>{
    return (dispatch) => {
        axios.post('/api/v1/admin/domain/add',{
            platform: platform,
            domain: domain,
            key: key,
            token: token
        }).then((res)=>{
            const result = res.data.data;
            dispatch({
                type: constants.SET_ADD_FORM,
                data: result,
                errMsg: null
            })
        }).catch((res)=>{
            const result = res.data.data;
            dispatch({
                type: constants.SET_ADD_FORM,
                data: result,
                errMsg: result
            })
        });
        dispatch({
            type: constants.SET_ADD_FORM,
            data: null,
            errMsg: "error"
        })
    }
};

export const closeDrawer = ()=>{
    return (dispatch) => {
            dispatch({
                type:constants.CLOSE_DRAWER
            })
    }
};

export const openSyncForm = ()=>{
    return (dispatch) => {
            dispatch({
                type:constants.OPEN_SYNC_FROM
            })
    }
};
export const SyncResolutionForce = (domain)=>{
    return (dispatch) => {
            axios.post('/api/v1/dnspod/sync/resolution',{
                domain:domain,
                forceResolution:1,
            }).then((res)=> {
                dispatch({
                    type:constants.SYNC_RESOLUTION,
                    syncResolutionMsg:res.data.msg
                })
                }
            )
    }
};

export const SyncResolution = (domain)=>{
    return (dispatch) => {
        axios.post('/api/v1/dnspod/sync/resolution',{
            domain:domain,
            forceResolution:0,
        }).then((res)=> {
                dispatch({
                    type: constants.SYNC_RESOLUTION,
                    syncResolutionMsg:res.data.msg
                })
            }
        )
    }
};

export const openAddForm = ()=>{
    return (dispatch) => {
            dispatch({
                type:constants.OPEN_ADD_FROM
            })
    }
};
