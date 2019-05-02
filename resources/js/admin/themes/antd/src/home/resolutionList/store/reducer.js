import { fromJS } from 'immutable';
import * as constants from './constants'

const defaultState = fromJS({
    resolutionList : [],
    editVisible : false,
    selectId : null,
    selectResolutionId : null,
    selectResolution : null,
    editAddress: null,
    editType: null,
    setResolutionFail: null,
    setResolutionSuccess: null,
    reloadResolutionList: false,
});

export default (state = defaultState, action) => {
    switch(action.type) {
        case constants.CHANGE_RESOLUTION_LIST:
            return state.merge({
                resolutionList : fromJS(action.list),
                reloadResolutionList : false
            });
        case constants.SHOW_DRAWER:
            return state.merge({
                editVisible : true,
                selectId: action.selectId,
                selectResolution: action.selectResolution,
                editAddress:action.editAddress,
                selectResolutionId:action.selectResolutionId,
                editType:action.editType
            });
        case constants.CLOSE_DRAWER:
            return state.merge({
                editVisible : false,
                selectId: null ,
                selectResolution: null,
                editAddress:null,
                selectResolutionId:null,
                editType:null,
            });
        case constants.CHANGE_EDIT_ADDRESS:
            return state.merge({
                editAddress : action.address,
            });
        case constants.SET_RESOLUTION_SUCCESS:
            return state.merge({
                setResolutionSuccess : action.resp,
                reloadResolutionList : true
            });
        case constants.SET_RESOLUTION_FAIL:
            return state.merge({
                setResolutionFail : action.resp,
            });

        case constants.DEL_RESOLUTION:
            return state.merge({
                reloadResolutionList :true
            });

        case constants.CLEAR_RESOLUTION_STATUS:
            return state.merge({
                setResolutionFail : null,
                setResolutionSuccess : null,
            });
        default:
            return state;
    }
}
