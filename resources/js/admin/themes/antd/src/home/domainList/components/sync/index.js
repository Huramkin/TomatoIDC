import React, { PureComponent } from 'react';
import { connect } from 'react-redux';
import {Button, Col, Drawer, Form, Input, Layout, Row, Select} from "antd";
const { Option } = Select;
class Sync extends PureComponent {
    render() {
        const { getFieldDecorator ,getFieldValue } = this.props.form;
        const {syncForm} = this.props;
        return (
            <Drawer
                title="快速同步"
                width={360}
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
                            <Form.Item label="解析地址">
                                {getFieldDecorator('address', {
                                    rules: [{max:50, min:1, required: true, message: '请输入要正确的解析地址' }],
                                })(<Input placeholder="请输入要解析到的地址"  />)}
                            </Form.Item>
                        </Col>
                    </Row>
                    <Row gutter={16}>
                        <Col span={24}>
                            <Form.Item label="类型">
                                {getFieldDecorator('type', {
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
                    <Button  type="primary">
                        编辑
                    </Button>
                </div>
            </Drawer>

        )
    }

}

const mapState = (state) => ({
    list: state.getIn(['domain', 'syncForm'])
});

const mapDispatch = (dispatch)=>({

});

const SyncForm = Form.create()(Sync);//浪费了一天，记录一下
export default connect(mapState, mapDispatch)(SyncForm);
