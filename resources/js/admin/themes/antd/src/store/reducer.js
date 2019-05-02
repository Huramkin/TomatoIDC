import { combineReducers } from 'redux-immutable';
// import { reducer as userReducer } from '../home/userList/store';
import {reducer as goodsReducer } from '../home/goodsList/store';
import {reducer as indexReducer } from '../home/index/store';
const reducer = combineReducers({
    // user : userReducer,
    goods:goodsReducer,
    index: indexReducer,
    // server: serverReducer
});

export default reducer;
