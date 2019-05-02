import React, {PureComponent} from 'react';
import {
    Layout, Breadcrumb, Drawer, Input, Select,
} from 'antd';
import {connect} from 'react-redux'
import {actionCreators} from "./store";
import {Table, Divider, Tag , Button ,Icon ,Row, Col ,Form,message} from 'antd';
import {Link} from "react-router-dom";

const {
    Content,
} = Layout;
const { Option } = Select;




class DomainListPage extends PureComponent {

    render() {
        const columns = [{
            title: '域名',
            dataIndex: 'domain',
        }, {
            title: '标签',
            key: 'tags',
            dataIndex: 'tags',
            render: tags => (
                <span>
      {tags.map(tag => {
          let color = 'geekblue';
          if (tag === 'loser') {
              color = 'volcano';
          }
          return <Tag color={color} key={tag}>{tag}</Tag>;
      })}
    </span>
            ),
        }, {
            title: '操作',
            key: 'action',
            dataIndex: 'action',
            render: action => (
                <span>
                <a href="javascript:;" onClick={this.props.SyncResolution.bind(this,action)} >同步</a>|
                <a href="javascript:;" onClick={this.props.SyncResolutionForce.bind(this,action)} >强制同步</a>|
                    <Link to={'/admin/resolutionList/'+ action } key={action}>
                        详细
                    </Link>|
                     <a href="javascript:;" onClick={this.props.DelDomain.bind(this,action)} >删除</a>
                </span>

            ),
        }
        ];

        const data = [];
        const { getFieldDecorator ,getFieldValue } = this.props.form;
        const {domainList,syncForm,addForm,syncResolutionMsg} = this.props;
        domainList.map(
            function (item) {
                data.push({
                    'id': item.get('id'),
                    'domain': item.get('domain'),
                    'tags':[item.get('platform'),item.get('type')],
                    'action': item.get('domain')
                })
            }
        );

        if (this.props.reloadDomainList  && this.props.reloadDomainList === true){
            this.props.getDomainList();
        }

        return (
            <Layout>
                <Content style={{padding: '0 50px'}}>
                    <Breadcrumb style={{margin: '16px 0'}}>
                        <Breadcrumb.Item>后台管理</Breadcrumb.Item>
                        <Breadcrumb.Item>域名操作</Breadcrumb.Item>
                        <Breadcrumb.Item>域名列表</Breadcrumb.Item>
                    </Breadcrumb>
                    <Layout style={{padding: '24px 0', background: '#fff'}}>
                        <Content style={{padding: '0 24px', minHeight: 280}}>
                            <Row>
                                <Col span={2}>
                                    <Button type="ghost" onClick={this.props.openAddForm} >
                                        新镇域名
                                    </Button>
                                </Col>
                                <Drawer
                                    title="添加域名"
                                    width={360}
                                    onClose={this.props.closeDrawer}
                                    visible={addForm}
                                    style={{
                                        overflow: 'auto',
                                        height: 'calc(100% - 108px)',
                                        paddingBottom: '108px',
                                    }}
                                >
                                    <Form layout="vertical" hideRequiredMark>
                                        <Row gutter={16}>
                                            <Col span={24}>
                                                <Form.Item label="平台">
                                                    {getFieldDecorator('platform', {
                                                        initialValue:"Dnspod",
                                                        rules: [{ required: true, message: '请选择解析方式' }],
                                                    })(
                                                        <Select placeholder="请选择解析方式">
                                                            <Option value="Dnspod">Dnspod</Option>
                                                        </Select>
                                                    )}
                                                </Form.Item>
                                            </Col>
                                            <Row gutter={16}>
                                                <Col span={24}>
                                                    <Form.Item label="域名">
                                                        {getFieldDecorator('domain', {
                                                            rules: [{max:50, min:1, required: true, message: '请输入要正确的解析地址' }],
                                                        })
                                                        (<Input placeholder="请输入要解析到的地址"  />)}
                                                    </Form.Item>
                                                </Col>
                                            </Row>
                                            <Row gutter={16}>
                                                <Col span={24}>
                                                    <Form.Item label="Key">
                                                        {getFieldDecorator('key', {
                                                            rules: [{ required: true, message: '请输入API KEY' }],
                                                        })
                                                        (<Input placeholder="请输入API KEY"  />)}
                                                    </Form.Item>
                                                </Col>
                                            </Row>
                                            <Row gutter={16}>
                                                <Col span={24}>
                                                    <Form.Item label="Token">
                                                        {getFieldDecorator('token', {
                                                            rules: [{ required: true, message: '请输入API Token' }],
                                                        })
                                                        (<Input placeholder="请输入API Token"  />)}
                                                    </Form.Item>
                                                </Col>
                                            </Row>
                                        </Row>
                                    </Form>
                                    <div
                                        style={{
                                            position: 'absolute',
                                            left: 0,
                                            bottom: 0,
                                            width: '100%',
                                            borderTop: '1px solid #e9e9e9',
                                            padding: '10px 16px',
                                            background: '#fff',
                                            textAlign: 'right',
                                        }}
                                    >
                                        <Button onClick={this.props.closeDrawer} style={{ marginRight: 8 }}>
                                            取消
                                        </Button>
                                        <Button onClick={this.props.setAddForm.bind(
                                            this,
                                            getFieldValue('platform'),
                                            getFieldValue('domain'),
                                            getFieldValue('key'),
                                            getFieldValue('token')
                                        )}  type="primary">
                                            编辑
                                        </Button>
                                    </div>
                                </Drawer>
                                <Col span={2}>
                                    <Button type="primary" onClick={this.props.openSyncForm} >
                                        快速同步
                                    </Button>
                                </Col>
                                <Drawer
                                    title="快速同步"
                                    width={540}
                                    onClose={this.props.closeDrawer}
                                    visible={syncForm}
                                    style={{
                                        overflow: 'auto',
                                        height: 'calc(100% - 108px)',
                                        paddingBottom: '108px',
                                    }}
                                >
                                    <Form layout="vertical" hideRequiredMark>
                                        <Row gutter={16}>
                                            <Col span={24}>
                                                <Form.Item label="类型">
                                                    {getFieldDecorator('platform', {
                                                        initialValue:"Dnspod",
                                                        rules: [{ required: true, message: '请选择解析方式' }],
                                                    })(
                                                        <Select placeholder="请选择解析方式">
                                                            <Option value="Dnspod">Dnspod</Option>
                                                        </Select>
                                                    )}
                                                </Form.Item>
                                            </Col>
                                        </Row>
                                        <Row gutter={16}>
                                            <Col span={24}>
                                                <Form.Item label="Key">
                                                    {getFieldDecorator('key', {
                                                        rules: [{ required: true, message: '请输入要正确的key' }],
                                                    })(<Input placeholder="请输入要key"  />)}
                                                </Form.Item>
                                            </Col>
                                        </Row>
                                        <Row gutter={16}>
                                            <Col span={24}>
                                                <Form.Item label="Token">
                                                    {getFieldDecorator('token', {
                                                        rules: [{ required: true, message: '请输入要正确的token' }],
                                                    })(<Input placeholder="请输入要token"  />)}
                                                </Form.Item>
                                            </Col>
                                        </Row>
                                        <Row gutter={16}>
                                            <Col span={24}>
                                                <Form.Item label="同步解析记录（BETA）">
                                                    {getFieldDecorator('syncResolution', {
                                                        initialValue:"0",
                                                        rules: [{ required: true, message: '请选择解析方式' }],
                                                    })(
                                                        <Select placeholder="请选择解析方式">
                                                            <Option value="0">否</Option>
                                                            <Option value="1">是</Option>
                                                        </Select>
                                                    )}
                                                </Form.Item>
                                            </Col>
                                        </Row>
                                    </Form>
                                    <div
                                        style={{
                                            position: 'absolute',
                                            left: 0,
                                            bottom: 0,
                                            width: '100%',
                                            borderTop: '1px solid #e9e9e9',
                                            padding: '10px 16px',
                                            background: '#fff',
                                            textAlign: 'right',
                                        }}
                                    >
                                        <Button onClick={this.props.closeDrawer} style={{ marginRight: 8 }}>
                                            取消
                                        </Button>
                                        <Button  type="primary" onClick={
                                            this.props.setSyncForm.bind(
                                                this,
                                                getFieldValue('platform'),
                                                getFieldValue('key'),
                                                getFieldValue('token'),
                                                getFieldValue('syncResolution'),
                                            )}>
                                            编辑
                                        </Button>
                                    </div>
                                </Drawer>
                                <Col span={24}>
                                    <Table rowKey="id" columns={columns} dataSource={data}/>
                                </Col>
                            </Row>
                        </Content>
                    </Layout>
                </Content>
            </Layout>
        );
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (prevProps.syncResolutionMsg && prevProps.syncResolutionMsg !== null){
            message.success(prevProps.syncResolutionMsg);
        }
    }

    componentDidMount() {
        this.props.getDomainList();
    }

}

const mapState = (state) => ({
    domainList: state.getIn(['domain', 'domainList']),
    syncForm: state.getIn(['domain', 'syncForm']),
    addForm: state.getIn(['domain', 'addForm']),
    reloadDomainList: state.getIn(['domain', 'reloadDomainList']),
    syncResolutionMsg: state.getIn(['domain', 'syncResolutionMsg'])
});

const mapDispatch = (dispatch) => ({
    getDomainList() {
        dispatch(actionCreators.getDomainList())
    },
    closeDrawer(){
        dispatch(actionCreators.closeDrawer())
    },
    openSyncForm(){
        dispatch(actionCreators.openSyncForm())
    },
    openAddForm(){
        dispatch(actionCreators.openAddForm())
    },
    setSyncForm(platform,key,token,syncResolution){
        dispatch(actionCreators.setSyncForm(platform,key,token,syncResolution))
    },
    setAddForm(platform,domain,key,token){
        dispatch(actionCreators.setAddForm(platform,domain,key,token))
    },
    SyncResolution(domain){
        dispatch(actionCreators.SyncResolution(domain))
    },
    SyncResolutionForce(domain){
        dispatch(actionCreators.SyncResolutionForce(domain))
    },
    DelDomain(domain){
        dispatch(actionCreators.DelDomain(domain))
    }


});

const DomainList = Form.create()(DomainListPage);//浪费了一天，记录一下
export default connect(mapState, mapDispatch)(DomainList)
