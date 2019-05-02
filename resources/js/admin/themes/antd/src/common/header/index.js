import React, { Component } from 'react';
import { Link,Redirect } from 'react-router-dom';
import {
    Layout, Menu,message
} from 'antd';

const {
    Header,
} = Layout;

class HeaderCommon extends Component {
    render() {
        return (
            <Layout>
                <Header className="header">
                    <div className="logo" />
                    <Menu
                        theme="dark"
                        mode="horizontal"
                        defaultSelectedKeys={['1']}
                        style={{ lineHeight: '64px' }}
                    >
                        <Menu.Item key="1">
                            <Link to="/admin">
                            仪表盘
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="2">
                            <Link to="/admin/goods/show">
                            商品管理
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="3">
                            <Link to="/admin/userList">
                            订单管理
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="4">
                            <Link to="/admin/userList">
                            用户管理
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="5">
                            <Link to="/admin/userList">
                                系统设置
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="6">
                            <Link to="/admin/userList">
                                卡密管理
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="8">
                            <Link to="/admin/userList">
                                工单管理
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="9">
                            <Link to="/admin/userList">
                                公告管理
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="10">
                            <Link to="/admin/userList">
                                服务器管理
                            </Link>
                        </Menu.Item>
                        <Menu.Item key="11">
                            <Link to="/admin/userList">
                                自定义页面
                            </Link>
                        </Menu.Item>
                        <Menu.Item onClick={userHome} key="12">
                            用户中心
                        </Menu.Item>
                    </Menu>
                </Header>
            </Layout>
        );
    }
}
const userHome = ()=>{
    window.location.href='/home';
};

export default HeaderCommon
