import React, {PureComponent} from 'react';
import {connect} from 'react-redux'
import {actionCreators} from "./store";
import axios from "axios";
import {CopyToClipboard} from 'react-copy-to-clipboard';

import {
    Table, Layout, Breadcrumb, Tag ,Button,Icon,notification
} from 'antd';

import {Link} from "react-router-dom";

const {
    Content,
} = Layout;





class UserListPage extends PureComponent {
    render() {
        const data = [];
        const columns = [
            {
                title: 'ID',
                dataIndex: 'id',
            },{
                title: '邮箱',
                dataIndex: 'email',
            }, {
                title: '用户名',
                dataIndex: 'username',
            }, {
                title: '名称',
                dataIndex: 'name',
            }, {
                title: '创建时间',
                dataIndex: 'created_at',
            },{
                title: '操作',
                key: 'action',
                dataIndex: 'action',
                render: action => (
                    <span>
                详细|
            <a href="javascript:;" onClick={this.props.getUserLoginUrl.bind(this,action)}>用户URL</a>
            </span>
                ),
            }
        ];
        const { userList,userLoginUrl } = this.props;
        // consolo.log( userList )
        userList.map(
            function (item) {
                data.push({
                    'id': item.get('id'),
                    'email': item.get('email'),
                    'username': item.get('username'),
                    'name': item.get('name'),
                    'created_at': item.get('created_at'),
                    'action': item,
                })
            }
        );

        return (
            <Layout>
                <Content style={{padding: '0 50px'}}>
                    <Breadcrumb style={{margin: '16px 0'}}>
                        <Breadcrumb.Item>后台管理</Breadcrumb.Item>
                        <Breadcrumb.Item>用户操作</Breadcrumb.Item>
                        <Breadcrumb.Item>用户列表</Breadcrumb.Item>
                    </Breadcrumb>
                    <Layout style={{padding: '24px 0', background: '#fff'}}>
                        <Content style={{padding: '0 24px', minHeight: 280}}>
                            <Table rowKey="id" columns={columns} dataSource={data}/>
                        </Content>
                    </Layout>
                </Content>
            </Layout>
        );
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.userLoginUrl !== null){
            <CopyToClipboard text={prevProps.userLoginUrl}/>
            notification.info({
                message: '生成到URL为：（30分钟内有效）',
                description: prevProps.userLoginUrl,
                placement: 'bottomLeft'
            });
        }
    }

    componentDidMount() {
        this.props.getUserList();
    }

}

const mapState = (state) => ({
    userList : state.getIn(['user', 'userList']),
    userLoginUrl : state.getIn(['user', 'userLoginUrl'])
});

const mapDispatch = (dispatch) => ({
    getUserList() {
        dispatch(actionCreators.getUserList())
    },
    getUserLoginUrl(user) {
        dispatch(actionCreators.getUserLoginUrl(user.get('email')))
    }
});

export default connect(mapState, mapDispatch)(UserListPage)
