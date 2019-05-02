import { fromJS } from 'immutable';
import * as constants from './constants'

const defaultState = fromJS({
    goodsList : [],
});

export default (state = defaultState, action) => {
    switch(action.type) {
        case constants.GET_GOODS_LIST:
            return state.merge({
                goodsList : fromJS(action.data),
            });
        default:
            return state;
    }
}
