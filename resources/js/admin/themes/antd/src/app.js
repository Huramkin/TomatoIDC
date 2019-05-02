import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route } from "react-router-dom";
import { Globalstyle } from './style';
import store from './store';
import { Provider } from 'react-redux';
import  IndexPage from  './home/index/'
import './App.css';
import HeaderCommon from './common/header/';
import FooterCommon from './common/footer/';
import GoodsList from './home/goodsList/';
import NoMatch from './common/noMatch';

export default class App extends Component {
    render() {
        return (
            <Provider store={store}>
                <BrowserRouter>
                    <div>
                        <HeaderCommon />
                        <Route path='/admin/' exact component={IndexPage} />
                        <Route path='/admin/goods/show' exact component={GoodsList} />
                        <FooterCommon />
                    </div>
                </BrowserRouter>
            </Provider>
        );
    }
}

if (document.getElementById('home')) {
    ReactDOM.render(<App />, document.getElementById('home'));
}
