import React, { PureComponent } from 'react';
import { connect } from 'react-redux'
import { actionCreators } from "./store";
import {
    Layout, Breadcrumb,Statistic, Card, Row, Col, Icon ,Table, Divider, Tag,Timeline,List,Tooltip
} from 'antd';

const {
     Content,
} = Layout;

const columns = [{
    title: 'Name',
    dataIndex: 'name',
    key: 'name',
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
          let color = tag.length > 5 ? 'geekblue' : 'green';
          if (tag === 'loser') {
              color = 'volcano';
          }
          return <Tag color={color} key={tag}>{tag.toUpperCase()}</Tag>;
      })}
    </span>
    ),
}, {
    title: 'Action',
    key: 'action',
    render: (text, record) => (
        <span>
      <a href="javascript:;">Invite {record.name}</a>
      <Divider type="vertical" />
      <a href="javascript:;">Delete</a>
    </span>
    ),
}];

 class IndexPage extends PureComponent {
    render() {
        const data = [{
            key: '1',
            name: 'John Brown',
            age: 32,
            address: 'New York No. 1 Lake Park',
            tags: ['nice', 'developer'],
        }, {
            key: '2',
            name: 'Jim Green',
            age: 42,
            address: 'London No. 1 Lake Park',
            tags: ['loser'],
        }, {
            key: '3',
            name: 'Joe Black',
            age: 32,
            address: 'Sidney No. 1 Lake Park',
            tags: ['cool', 'teacher'],
        }];

        const updatelog = [
            '123',
            '123'
        ];
        const {orderCount,userCount,workOrderCount} = this.props;
        return (
            <Layout>
                <Content style={{ padding: '0 50px' }}>
                    <Breadcrumb style={{ margin: '16px 0' }}>
                        <Breadcrumb.Item>后台管理</Breadcrumb.Item>
                        <Breadcrumb.Item>全局监控</Breadcrumb.Item>
                        <Breadcrumb.Item>仪表盘</Breadcrumb.Item>
                    </Breadcrumb>
                    <Layout style={{ padding: '24px 0', background: '#fff' }}>
                        <Content style={{ padding: '0 24px', minHeight: 280 }}>
                            <Row gutter={16}>
                                <Col span={6}>
                                    <Card>
                                        <Statistic
                                            title="开通的服务"
                                            value={orderCount}
                                        />
                                    </Card>
                                </Col>
                                <Col span={6}>
                                    <Card>
                                        <Statistic
                                            title="注册的用户"
                                            value={userCount}
                                        />
                                    </Card>
                                </Col>
                                <Col span={6}>
                                    <Card>
                                        <Statistic
                                            title="开启的工单"
                                            value={workOrderCount}
                                        />
                                    </Card>
                                </Col>
                                <Col span={6}>
                                    <Card>
                                        <Statistic
                                            title="在线的服务器"
                                            value={21}
                                        />
                                    </Card>
                                </Col>
                            </Row>
                            <Divider orientation="left">服务器状态</Divider>
                            <Row gutter={16}>
                                <Col span={18}>
                                    <Table columns={columns} dataSource={data} />
                                </Col>
                                <Col span={6}>
                                    <Card
                                        title="状态变化"
                                    >
                                        <Timeline>
                                            <Timeline.Item>Create a services site 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Solve initial network problems 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Technical testing 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Network problems being solved 2015-09-01</Timeline.Item>
                                        </Timeline>
                                    </Card>
                                </Col>
                            </Row>
                            <Divider>TIDC</Divider>
                            <Row gutter={16}>
                                <Col span={6}>
                                    <Card
                                        title="版本发布"
                                    >
                                        <Timeline>
                                            <Timeline.Item>Create a services site 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Solve initial network problems 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Technical testing 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Network problems being solved 2015-09-01</Timeline.Item>
                                        </Timeline>
                                    </Card>
                                </Col>
                                <Col span={6}>
                                    <Card
                                        title="更新记录"
                                    >
                                        <Timeline>
                                            <Timeline.Item>Create a services site 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Solve initial network problems 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Technical testing 2015-09-01</Timeline.Item>
                                            <Timeline.Item>Network problems being solved 2015-09-01</Timeline.Item>
                                        </Timeline>
                                    </Card>
                                </Col>

                                <Col span={6}>
                                    <Card
                                        title="更多信息"
                                    >
                                        <p>当前版本：</p>
                                        <p>系统公告：</p>
                                        <Tooltip title="
                                        TIDC版本更新提醒，公告发布服务器。
                                        用于提醒新版本和发布公告，
                                        不会影响或存储站点任何内容。
                                        二开版本可以在CloudCenterController.php内修改为自己的服务器地址
                                        ">
                                            <span>TIDC服务器:</span>
                                        </Tooltip>
                                    </Card>
                                </Col>
                                <Col span={6}>
                                    <List
                                        header={<div>更新内容</div>}
                                        footer={  <a href="www.baidu.com"> 查看更多 </a>}
                                        bordered
                                        size="small"
                                        dataSource={updatelog}
                                        renderItem={item => (<List.Item>{item}</List.Item>)}
                                    />
                                </Col>
                            </Row>
                        </Content>
                    </Layout>
                </Content>
            </Layout>
        );
    }

    componentDidMount() {
        this.props.getServersList();
    }
 }


const mapState = (state)=>({
    servers: state.getIn(['index','servers']),
    userCount: state.getIn(['index','userCount']),
    orderCount: state.getIn(['index','orderCount']),
    workOrderCount: state.getIn(['index','workOrderCount']),
});

const mapDispatch = (dispatch) => ({
    getServersList() {
        dispatch(actionCreators.getServersList())
    },
});


export default connect(mapState,mapDispatch)(IndexPage)
