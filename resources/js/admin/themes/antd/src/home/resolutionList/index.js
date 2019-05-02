import React, { PureComponent } from 'react';
import {
    Layout, Breadcrumb,
} from 'antd';
import { connect } from 'react-redux'
import { actionCreators } from "./store";
import { message , Table, Drawer, Form, Button, Col, Row, Input, Select } from 'antd';

const {
    Content,
} = Layout;

const { Option } = Select;

class ResolutionList extends PureComponent {

    render() {
        const { getFieldDecorator ,getFieldValue } = this.props.form;
        const columns = [{
            title: '域名',
            dataIndex: 'name',
        }, {
            title: '解析地址',
            dataIndex: 'address',
        }, {
            title: '记录类型',
            dataIndex: 'type',
        },{
            title: '操作',
            key: 'action',
            dataIndex: 'action',
            render: action => (
                <span>
           <a href="javascript:;" onClick={this.props.showDrawer.bind(
               this,
               action,
               resolutionList.get(action)
           )}>编辑解析</a>|
            <a href="javascript:;" onClick={this.props.removeResolution.bind(
               this,
               action,
               resolutionList.get(action)
           )}>删除</a>
        </span>
            ),
        }];
        const data = [];
        const {
            reloadResolutionList,
            resolutionList,
            editVisible,
            selectResolution,
            editAddress,
            editType,
            selectResolutionId,
            setResolutionSuccess,
            setResolutionFail,
        } = this.props;



        if(resolutionList.size !== 0) {
            resolutionList.map(
                function (item , index) {
                    data.push({
                        'id': item.get('id'),
                        'address': item.get('address'),
                        'name': item.get('prefix'),
                        'type': item.get('type'),
                        'action': index
                    })
                }
            );
        }

        if (reloadResolutionList === true){
            this.props.getResolutionList(this.props.match.params.domain);
        }

        if (selectResolution !== null && selectResolution.size !== 0){
            if (editAddress == null){
                this.props.changeEditAddress(selectResolution.get('address'))
            }
        }

        return (
            <Layout>
                <Content style={{ padding: '0 50px' }}>
                    <Breadcrumb style={{ margin: '16px 0' }}>
                        <Breadcrumb.Item>用户中心</Breadcrumb.Item>
                        <Breadcrumb.Item>域名操作</Breadcrumb.Item>
                        <Breadcrumb.Item>域名解析</Breadcrumb.Item>
                    </Breadcrumb>
                    <Layout style={{ padding: '24px 0', background: '#fff' }}>
                        <Content style={{ padding: '0 24px', minHeight: 280 }}>
                            <Table rowKey="id" columns={columns} dataSource={data} />
                        </Content>

                        <Drawer
                            title="编辑解析"
                            width={360}
                            onClose={this.props.closeDrawer}
                            visible={editVisible}
                            style={{
                                overflow: 'auto',
                                height: 'calc(100% - 108px)',
                                paddingBottom: '108px',
                            }}
                        >
                            <Form layout="vertical" hideRequiredMark>
                                <Row gutter={16}>
                                    <Col span={24}>
                                        <Form.Item label="解析地址">
                                            {getFieldDecorator('address', {
                                                initialValue:editAddress,
                                                rules: [{max:50, min:1, required: true, message: '请输入要正确的解析地址' }],
                                            })(<Input placeholder="请输入要解析到的地址"  />)}
                                        </Form.Item>
                                    </Col>
                                </Row>
                                <Row gutter={16}>
                                    <Col span={24}>
                                        <Form.Item label="类型">
                                            {getFieldDecorator('type', {
                                                initialValue:editType,
                                                rules: [{ required: true, message: '请选择解析方式' }],
                                            })(
                                                <Select placeholder="请选择解析方式">
                                                    <Option value="CNAME">CNAME</Option>
                                                    <Option value="A" >A</Option>
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
                                <Button onClick={this.props.setResolution.bind(
                                    this,
                                    selectResolutionId,
                                    getFieldValue("address"),
                                    getFieldValue("type"))
                                } type="primary">
                                    编辑
                                </Button>
                            </div>
                        </Drawer>

                    </Layout>
                </Content>
            </Layout>
        );
    }

    componentDidUpdate(prevProps, prevState){
        if (prevProps.setResolutionSuccess && prevProps.setResolutionSuccess.size !== 0){
            message.success('修改解析记录成功', 3);
            this.props.clearResolutionStatus();
        }
        if (prevProps.setResolutionFail && prevProps.setResolutionFail.size !== 0) {
            message.error('修改解析记录失败', 3);
            this.props.clearResolutionStatus();
        }
    }
    componentDidMount() {
        this.props.getResolutionList(this.props.match.params.domain);
    }
}

const mapState = (state)=>({
    resolutionList: state.getIn(['resolution','resolutionList']),
    editVisible: state.getIn(['resolution','editVisible']),
    selectId: state.getIn(['resolution','selectId']),
    selectResolution: state.getIn(['resolution','selectResolution']),
    editAddress: state.getIn(['resolution','editAddress']),
    editType: state.getIn(['resolution','editType']),
    selectResolutionId: state.getIn(['resolution','selectResolutionId']),
    reloadResolutionList: state.getIn(['resolution','reloadResolutionList']),
    setResolutionFail: state.getIn(['resolution','setResolutionFail']),
    setResolutionSuccess: state.getIn(['resolution','setResolutionSuccess'])
});

const mapDispatch = (dispatch) => ({
    getResolutionList(domain) {
        dispatch(actionCreators.getResolutionList(domain))
    },
    closeDrawer(){
        dispatch(actionCreators.closeDrawer())
    },
    showDrawer(selectId,selectResolution){
        dispatch(actionCreators.showDrawer(
            selectId,
            selectResolution,
            selectResolution.get('address'),
            selectResolution.get('type'),
            selectResolution.get('id')
        ))
    },
    changeEditAddress(address){
        dispatch(actionCreators.changeEditAddress(address))
    },
    editResolution(){
        dispatch(actionCreators.editResolution())
    },
    setResolution(selectId,address,type){
        dispatch(actionCreators.setResolution(selectId,address,type))
    },
    clearResolutionStatus(){
        dispatch(actionCreators.clearResolutionStatus())
    },
    removeResolution(id,selectResolution){
        dispatch(actionCreators.removeResolution(selectResolution.get('id')))
    }
});

const CustomForm = Form.create()(ResolutionList);//浪费了一天，记录一下
export default connect(mapState,mapDispatch)(CustomForm)
