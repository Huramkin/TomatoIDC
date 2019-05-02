import { fromJS } from 'immutable';
import * as constants from './constants'

const defaultState = fromJS({
    domainList : [],
    syncForm: false,
    addForm: false,
    reloadDomainList: false,
    errMsg: null,
    syncResolutionMsg: null,
});

export default (state = defaultState, action) => {
    switch(action.type) {
        case constants.CHANGE_DOMAIN_LIST:
            return state.merge({
                domainList : fromJS(action.list),
                reloadDomainList:false,
                syncResolutionMsg:null,
            });
        case constants.CLOSE_DRAWER:
            return state.merge({
                syncForm: false,
                addForm: false,
                syncResolutionMsg: null
            });
        case constants.OPEN_SYNC_FROM:
            return state.merge({
                syncForm: true,
                addForm: false
            });
        case constants.OPEN_ADD_FROM:
            return state.merge({
                syncForm: false,
                addForm: true
            });
        case constants.SET_SYNC_FORM:
            return state.merge({
                syncForm: false,
                reloadDomainList:true,
                addForm: false,
                errMsg: action.errMsg
            });
        case constants.SET_ADD_FORM:
            return state.merge({
                syncForm: false,
                reloadDomainList:true,
                addForm: false,
                errMsg: action.errMsg
            });
        case constants.SYNC_RESOLUTION:
            return state.merge({
                reloadDomainList:true,
                syncResolutionMsg:action.syncResolutionMsg
            });
        case constants.DEL_DOMAIN:
            return state.merge({
                reloadDomainList:true,
            });
        default:
            return state;
    }
}
