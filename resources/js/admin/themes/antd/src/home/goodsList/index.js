import React, { PureComponent } from 'react';
import { connect } from 'react-redux'
import { actionCreators } from "./store";
import { Popconfirm,Table, Divider,Breadcrumb, Tag, message , Drawer, Form, Button, Col, Row, Input, Select,Layout } from 'antd';
const {
    Content,
} = Layout;

function cancelDelGoods() {
    message.error('取消删除商品');
}


class GoodsList extends PureComponent {

    render() {
        const columns = [{
            title: '商品名称',
            dataIndex: 'title',
            key: 'title',
            render: text => <a href="javascript:;">{text}</a>,
        }, {
            title: 'Age',
            dataIndex: 'age',
            key: 'age',
        }, {
            title: 'Address',
            dataIndex: 'address',
            key: 'address',
        }, {
            title: 'Tags',
            key: 'tags',
            dataIndex: 'tags',
            render: tags => (
                <span>
      {tags.map(tag => {
          let color = tag.length > 5 ? 'green' : 'geekblue';
          return <Tag color={ color} key={tag}>{tag.toUpperCase()}</Tag>;
      })}
    </span>
            ),
        }, {
            title: '操作',
            key: 'action',
            render: (action) => (
                <span>
      <a href="javascript:;">编辑</a>
      <Divider type="vertical" />
      <Popconfirm title="确认要删除该商品?" onConfirm={() => this.delGoods(action)} onCancel={cancelDelGoods} okText="确认" cancelText="取消">
      <a href="javascript:;">删除</a>
      </Popconfirm>
    </span>
            ),
        }];
        const goodsTable= [];
        const { goodsList } = this.props;
        if (goodsList && goodsList.size !== 0) {
            goodsList.map(
                function (item) {
                    goodsTable.push({
                        key: item.get('id'),
                        title: item.get('title'),
                        age: 32,
                        address: 'New York No. 1 Lake Park',
                        tags: [item.get('status'), item.get('categories_id')],
                        action: item.get('id')
                    })
                }
            );
        }
        return (
            <Layout>
                <Content style={{ padding: '0 50px' }}>
                    <Breadcrumb style={{ margin: '16px 0' }}>
                        <Breadcrumb.Item>后台管理</Breadcrumb.Item>
                        <Breadcrumb.Item>商品管理</Breadcrumb.Item>
                        <Breadcrumb.Item>商品列表</Breadcrumb.Item>
                    </Breadcrumb>

                    <Layout style={{ padding: '24px 0', background: '#fff' }}>
                        <Content style={{ padding: '0 24px', minHeight: 280 }}>
                            <Row gutter={16}>
                                <Col span={24}>
                                    <Button
                                        type="primary"
                                    >
                                        新增商品
                                    </Button>
                                    <Table columns={columns} dataSource={goodsTable} />
                                </Col>
                            </Row>
                        </Content>
                    </Layout>
                </Content>
            </Layout>
        );
    }
    delGoods(goods){
        this.props.delGoods(goods.key)
    }

    componentDidUpdate(prevProps, prevState){

    }
    componentDidMount() {
        this.props.getGoodsList();
    }
}

const mapState = (state)=>({
    goodsList: state.getIn(['goods','goodsList']),
});

const mapDispatch = (dispatch) => ({
    getGoodsList() {
        dispatch(actionCreators.getGoodsList())
    },
    delGoods(id){
        dispatch(actionCreators.delGoods(id))
    }
});

const CustomForm = Form.create()(GoodsList);//浪费了一天，记录一下
export default connect(mapState,mapDispatch)(CustomForm)
