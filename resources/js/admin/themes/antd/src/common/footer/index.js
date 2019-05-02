import React, { Component } from 'react';
import {
    Layout,
} from 'antd';

const {
    Footer,
} = Layout;

class FooterCommon extends Component {
    render() {
        return (
            <Layout>
                <Footer style={{ textAlign: 'center' }}>
                    TIDC ©2019 Created by MercyCloud
                </Footer>
            </Layout>
        );
    }
}

export default FooterCommon
