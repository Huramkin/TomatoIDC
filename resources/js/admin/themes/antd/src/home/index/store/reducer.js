import { fromJS } from 'immutable';
import * as constants from './constants'

const defaultState = fromJS({
    servers : [],
    userCount : 0,
    orderCount : 0,
    workOrderCount : 0,
});

export default (state = defaultState, action) => {
    switch(action.type) {
        case constants.GET_SERVERS_LIST:
            return state.merge({
                servers : fromJS(action.data.servers),
                userCount : fromJS(action.data.userCount),
                orderCount : fromJS(action.data.orderCount),
                workOrderCount : fromJS(action.data.workOrderCount),
            });
        default:
            return state;
    }
}
