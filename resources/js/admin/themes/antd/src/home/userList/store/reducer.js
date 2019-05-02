import { fromJS } from 'immutable';
import * as constants from './constants'

const defaultState = fromJS({
    userList : [],
    userLoginUrl: null
});

export default (state = defaultState, action) => {
    switch(action.type) {
        case constants.CHANGE_USER_LIST:
            return state.merge({
                userList : fromJS(action.list)
            });
        case constants.GET_USER_LOGIN_URL:
            return state.merge({
                userLoginUrl : action.data
            });
        default:
            return state;
    }
}
