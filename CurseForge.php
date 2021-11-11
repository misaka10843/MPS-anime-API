<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CurseForge Mod CN 加速节点</title>
    <link href="https://media.forgecdn.net/avatars/130/458/636460205549127215.png" rel="icon"
          type="image/x-ico"/>


    <style>
        body {
            background: url("https://dreamer-paul.gitee.io/anime-wallpaper/5.jpg") center/cover no-repeat fixed;
            width: 100% !important;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .hide-trash-bin .trash-bin {
            display: none;
        }

        .hide-trash-bin:hover .trash-bin {
            display: unset;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/react@17.0.1/umd/react.production.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@17.0.1/umd/react-dom.production.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@babel/standalone@7.13.10/babel.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/antd@4.13.1/dist/antd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@ant-design/icons@4.5.0/dist/index.umd.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/antd@4.13.1/dist/antd.min.css" rel="stylesheet">

    <script>
        function intToString(num) {
            if (num < 1000) {
                return num.toFixed(2).replace(/\.0+$|(\.[0-9]*[1-9])0+$/, "$1")
            }
            const si = [
                {v: 1E3, s: "K"},
                {v: 1E6, s: "M"},
                {v: 1E9, s: "B"},
                {v: 1E12, s: "T"},
                {v: 1E15, s: "P"},
                {v: 1E18, s: "E"}
            ];
            let i;
            for (i = si.length - 1; i > 0; i--) {
                if (num >= si[i].v) {
                    break;
                }
            }
            return (num / si[i].v).toFixed(2).replace(/\.0+$|(\.[0-9]*[1-9])0+$/, "$1") + si[i].s;
        }
    </script>

    <script type="text/babel">
        const Row = antd.Row
        const Col = antd.Col
        const Select = antd.Select
        const Card = antd.Card
        const Button = antd.Button
        const Spin = antd.Spin
        const Input = antd.Input
        const Affix = antd.Affix
        const List = antd.List
        const Popover = antd.Popover
        const Modal = antd.Modal
        const Switch = antd.Switch
        const Tag = antd.Tag
        const Table = antd.Table
        const Form = antd.Form
        const Tooltip = antd.Tooltip
        const Skeleton = antd.Skeleton

        const message = antd.message

        const DownloadOutlined = icons.DownloadOutlined
        const FireFilled = icons.FireFilled
        const DeleteFilled = icons.DeleteFilled
        const MenuOutlined = icons.MenuOutlined
        const SyncOutlined = icons.SyncOutlined
        const ExclamationCircleTwoTone = icons.ExclamationCircleTwoTone
        const PlusCircleTwoTone = icons.PlusCircleTwoTone

        const ABR_TAG_PROPS = [[], ["green", "R"], ["blue", "B"], ["purple", "A"]]
        const ABR = (props) =>
            <Tag color={ABR_TAG_PROPS[props.type][0]}>
                {ABR_TAG_PROPS[props.type][1]}
            </Tag>
        const FileSpan = (props) => {
            let file = props.file
            if (!file) return false
            let dependencies = []
            let addons = []
            let dependencyIndex = 0
            let addonIndex = 0
            for (let dependency of file.dependencies) {
                if (dependency.type === 3) {
                    dependency.index = dependencyIndex++
                    if (!state.minecraftModPackModList[dependency.addonId])
                        dependencies.push(dependency)
                } else {
                    dependency.index = addonIndex++
                    if (!state.minecraftModPackModList[dependency.addonId])
                        addons.push(dependency)
                }
            }
            return (
                <>
                    <ABR type={file.releaseType}/>
                    <a href={file.downloadUrl}>{file.fileName}</a>
                    {dependencies.length > 0 && <>&ensp;
                        <Tooltip title={
                            <>
                                需要依赖
                                {dependencies.map(dependency =>
                                    <a onClick={() => {
                                        showModFiles(dependency.addonId)
                                    }}>&ensp;{alphabet[dependency.index]}</a>)}
                            </>
                        }>
                            <ExclamationCircleTwoTone twoToneColor={"#faad14"}/>
                        </Tooltip>
                    </>}
                    {addons.length > 0 && <>&ensp;
                        <Tooltip title={
                            <>
                                相关模组
                                {addons.map(addon =>
                                    <a onClick={() => {
                                        showModFiles(addon.addonId)
                                    }}>&ensp;{alphabet[addon.index]}</a>)}
                            </>
                        }>
                            <PlusCircleTwoTone twoToneColor={"#52c41a"}/>
                        </Tooltip>
                    </>}
                </>
            )
        }

        class MinecraftVersionSelector extends React.Component {
            componentDidMount() {
                getMinecraftVersionList()
            }

            render() {
                return (
                    <Select
                        allowClear={true}
                        placeholder={"不特定游戏版本"}
                        onChange={this.props.onChange}
                        style={{width: "100%"}}
                        value={state.gameVersion === "" ? undefined : state.gameVersion}
                    >
                        {state.minecraftVersionList.map(version =>
                            <Select.Option key={version.id} value={version.versionString}>
                                {version.versionString}
                            </Select.Option>
                        )}
                    </Select>
                )
            }
        }

        class MinecraftModsCategorySectionSelector extends React.Component {
            componentDidMount() {
                getMinecraftModsCategorySectionList()
            }

            render() {
                return (
                    <Select
                        allowClear={true}
                        placeholder={"不特定模组分类"}
                        onChange={this.props.onChange}
                        style={{width: "100%"}}
                    >
                        {state.minecraftModsCategorySectionList.map(section =>
                            <Select.Option key={section.id} value={section.id}>
                                {section.name}
                            </Select.Option>
                        )}
                    </Select>
                )
            }
        }

        class MinecraftModSearchBox extends React.Component {
            render() {
                return (
                    <Input.Search
                        placeholder={"搜索模组关键字"}
                        onSearch={this.props.onSearch}
                    />
                )
            }
        }

        class MinecraftModList extends React.Component {
            componentDidMount() {
                getMinecraftModList()
            }

            renderPopover(mod) {
                return (
                    <>
                        {state.gameVersion === "" ? <></> :
                            <Table
                                dataSource={mod.gameVersionLatestFiles.filter(version => version.gameVersion === state.gameVersion)}
                                showHeader={false}
                                rowKey={"projectFileId"}
                                size={"small"}
                                pagination={false}
                                onRow={version => {
                                    return {
                                        onClick: () => this.props.onMinecraftModVersionChange(mod.id, version.projectFileId)
                                    }
                                }}
                            >
                                <Table.Column
                                    dataIndex="fileType"
                                    render={fileType => <ABR type={fileType}/>}
                                />
                                <Table.Column dataIndex="projectFileName"/>
                                <Table.Column
                                    dataIndex="projectFileId"
                                    render={id =>
                                        <Switch
                                            size={"small"}
                                            checked={state.minecraftModPackModList[mod.id] === id}
                                        />
                                    }
                                />
                            </Table>
                        }
                        <div style={{textAlign: "center"}}>
                            <a href={mod.websiteUrl} target={"_blank"}>前往 CurseForge 页面</a>
                        </div>
                    </>
                )
            }

            render() {
                return (
                    <Row gutter={[16, 16]}>
                        {state.minecraftModList.map(mod =>
                            <Col span={8} key={mod.id}>
                                <Popover
                                    placement={"rightTop"}
                                    content={this.renderPopover(mod)}
                                >
                                    <Card
                                        hoverable
                                        style={state.minecraftModPackModList[mod.id] ? {background: "#F0FFF0"} : {}}
                                        onClick={() => {
                                            showModFiles(mod.id)
                                        }}
                                    >
                                        <Card.Meta
                                            title={mod.name}
                                            description={
                                                <>
                                                    <div>
                                                        <FireFilled/> {intToString(mod.popularityScore)}
                                                        &emsp;
                                                        <DownloadOutlined/> {intToString(mod.downloadCount)}
                                                    </div>
                                                    <div>{mod.summary}</div>
                                                </>
                                            }
                                        />
                                    </Card>
                                </Popover>
                            </Col>
                        )}
                        <Col span={8}>
                            <Card hoverable onClick={this.props.onMinecraftModLoadMore}>
                                <Card.Meta description={"加载更多模组"} key={0} style={{textAlign: "center"}}/>
                            </Card>
                        </Col>
                    </Row>
                )
            }
        }

        class MinecraftModPackWindow extends React.Component {
            render() {
                return (
                    <List
                        style={{
                            maxHeight: "calc(600px - 4em - 24px)",
                            overflow: "auto",
                            background: "white",
                            opacity: "0.9"
                        }}
                        size={"small"}
                        bordered
                        dataSource={Object.entries(state.minecraftModPackModList)}
                        renderItem={([projectId, version]) => {
                            let info = cache.minecraftModFileInfo[version]
                            return (
                                <List.Item>
                                    <List.Item.Meta className={"hide-trash-bin"} description={
                                        <Row justify={"space-between"}>
                                            <Col>
                                                {info ? <FileSpan file={info}/> :
                                                    <>
                                                        <SyncOutlined
                                                            spin/>&ensp;加载 {version} 的冗余信息中……
                                                    </>
                                                }
                                                &ensp;
                                                <MenuOutlined
                                                    style={{cursor: "pointer"}}
                                                    className={"trash-bin"}
                                                    onClick={() => showModFiles(projectId)}
                                                />
                                            </Col>
                                            <Col>
                                                <DeleteFilled
                                                    style={{cursor: "pointer"}}
                                                    className={"trash-bin"}
                                                    onClick={() => this.props.onMinecraftModVersionChange(projectId, version)}
                                                />
                                            </Col>
                                        </Row>
                                    }/>
                                </List.Item>
                            )
                        }}
                    />
                );
            }
        }

        class MinecraftModInfoWindow extends React.Component {
            render() {
                let info = cache.modFiles[state.modFilesModalModId]
                return (
                    <Modal
                        footer={null}
                        visible={state.modFilesModalModId}
                        onCancel={e => {
                            if (2 * e.clientX < window.innerWidth) hideModFiles()
                            else closeModFiles()
                        }}
                        closable={false}
                        width={800}
                    >

                        {info ?
                            <Table
                                dataSource={state.gameVersion === "" ? info : info.filter(file => file.gameVersion.indexOf(state.gameVersion) >= 0)}
                                pagination={false}
                                showHeader={false}
                                rowKey={"id"}
                                size={"small"}
                            >
                                <Table.Column
                                    render={file =>
                                        <Row justify={"space-between"}>
                                            <Col>
                                                <FileSpan file={file}/>
                                            </Col>
                                            <Col>
                                                {file.gameVersion.map(version =>
                                                    <Tag key={version} color={"magenta"}>
                                                        {version}
                                                    </Tag>
                                                )}
                                                {state.gameVersion === "" ? <></> :
                                                    <Switch
                                                        size={"small"}
                                                        checked={
                                                            state.minecraftModPackModList[state.modFilesModalModId] === file.id
                                                        }
                                                        onClick={() => {
                                                            cache.minecraftModFileInfo[file.id] = file
                                                            this.props.onMinecraftModVersionChange(state.modFilesModalModId, file.id)
                                                        }}
                                                    />
                                                }
                                            </Col>
                                        </Row>
                                    }
                                />
                            </Table> :
                            <Skeleton active/>
                        }
                    </Modal>
                )
            }
        }

        class MinecraftModPackInfoWindow extends React.Component {
            form = React.createRef()

            componentDidMount() {
                getMinecraftModLoaderList()
            }

            onOk() {
                this.form.current.validateFields().then(values => {
                    if (values.name && values.version && values.author && state.modLoader) {
                        const blob = new Blob([JSON.stringify(
                            {
                                minecraft: {
                                    version: state.gameVersion,
                                    modLoaders: [{
                                        id: state.modLoader,
                                        primary: true
                                    }]
                                },
                                manifestType: "minecraftModpack",
                                manifestVersion: 1,
                                name: values.name,
                                version: values.version,
                                author: values.author,
                                files: Object.entries(state.minecraftModPackModList).map(([id, mod]) => {
                                    return {
                                        projectID: parseInt(id),
                                        fileID: mod,
                                        required: true
                                    }
                                })
                            }
                        )], {type: 'application/json'})
                        download(URL.createObjectURL(blob))
                    }
                })
            }

            onCancel() {
                state.openMinecraftModPackInfoWindow = false
                this.setState({})
            }

            render() {
                return (
                    <Modal
                        visible={state.openMinecraftModPackInfoWindow}
                        title={"导出整合包"}
                        onOk={() => this.onOk()}
                        onCancel={() => this.onCancel()}
                        cancelText={"取消"}
                        okText={"导出"}
                        closable={false}
                    >
                        <Form ref={this.form} colon={false}>
                            <Form.Item name={"name"} label={"整合包名称"}>
                                <Input placeholder={"请输入整合包名称"}/>
                            </Form.Item>
                            <Form.Item name={"version"} label={"整合包版本"}>
                                <Input placeholder={"请输入整合包版本"}/>
                            </Form.Item>
                            <Form.Item name={"author"} label={"整合包作者"}>
                                <Input placeholder={"请输入整合包作者"}/>
                            </Form.Item>
                            <Form.Item label={"模组加载器"} style={{marginBottom: "0"}}>
                                <Select
                                    placeholder={"请选择模组加载器"}
                                    onChange={value => {
                                        state.modLoader = value
                                        this.setState({})
                                    }}
                                    value={state.modLoader}
                                >
                                    {state.minecraftModLoaderList.filter(modLoader => modLoader.gameVersion === state.gameVersion).map(modLoader =>
                                        <Select.Option key={modLoader.name} value={modLoader.name}>
                                            {modLoader.name}{modLoader.recommended && "（推荐）"}
                                        </Select.Option>
                                    )}
                                </Select>
                            </Form.Item>
                        </Form>
                    </Modal>
                )
            }
        }

        class App extends React.Component {
            onMinecraftVersionChange(value) {
                clearModList()
                loadMinecraftModPackModList(value)
                state.gameVersion = value ? value : ""
                state.modLoader = undefined
                getMinecraftModList()
            }

            onMinecraftModsCategorySectionChange(value) {
                clearModList()
                state.categoryId = value ? value : ""
                getMinecraftModList()
            }

            onMinecraftModSearchBoxSearch(value) {
                clearModList()
                state.searchFilter = value
                getMinecraftModList()
            }

            onMinecraftModVersionChange(modId, fileId) {
                if (state.minecraftModPackModList[modId] === fileId)
                    delete state.minecraftModPackModList[modId]
                else {
                    state.minecraftModPackModList[modId] = fileId
                    getMinecraftModFileInfo(modId, fileId)
                }
                this.setState({})
            }

            onMinecraftModLoadMore() {
                getMinecraftModList()
            }

            render() {
                return (
                    <Spin
                        spinning={state.loading}
                        indicator={
                            <span className="ant-spin-dot ant-spin-dot-spin" style={{position: "fixed"}}>
                                <i className="ant-spin-dot-item"></i>
                                <i className="ant-spin-dot-item"></i>
                                <i className="ant-spin-dot-item"></i>
                                <i className="ant-spin-dot-item"></i>
                                
                            </span>
                        }
                    >
                        <MinecraftModPackInfoWindow/>
                        <MinecraftModInfoWindow
                            onMinecraftModVersionChange={this.onMinecraftModVersionChange.bind(this)}
                        />

                        <div style={{padding: "16px"}}>
                            <Row gutter={[16, 16]}>
                                <Col span={16}>
                                    <MinecraftModList
                                        onMinecraftModVersionChange={this.onMinecraftModVersionChange.bind(this)}
                                        onMinecraftModLoadMore={this.onMinecraftModLoadMore}
                                    />
                                </Col>
                                <Col span={8}>
                                    <Affix offsetTop={16}>
                                        <Row gutter={[8, 8]}>
                                            <Col span={10}>
                                                <MinecraftVersionSelector
                                                    onChange={this.onMinecraftVersionChange}
                                                />
                                            </Col>
                                            <Col span={14}>
                                                <MinecraftModsCategorySectionSelector
                                                    onChange={this.onMinecraftModsCategorySectionChange}
                                                />
                                            </Col>
                                        </Row>
                                        <Row style={{marginTop: 8}}>
                                            <Col span={24}>
                                                <MinecraftModSearchBox onSearch={this.onMinecraftModSearchBoxSearch}/>
                                            </Col>
                                        </Row>
                                        <Row style={{marginTop: 24}}>
                                            <Col span={24}>
                                            <font color="LightGrey">
                                            <div>选择特定版本后将鼠标移至mod上即可选择mod并添加到此处，</div>
                                            <div>选择完毕后点击导出整合包即可导出manifest.json(整合包的mod列表)</div>
                                            </font>
                                                <MinecraftModPackWindow
                                                    onMinecraftModVersionChange={this.onMinecraftModVersionChange.bind(this)}
                                                />
                                            </Col>
                                        </Row>
                                        <Row style={{marginTop: 8}} justify={"space-between"}>
                                            <Col>
                                                <Button
                                                    type={"primary"}
                                                    onClick={() => {
                                                        for (let [modId, fileId] of Object.entries(state.minecraftModPackModList))
                                                            getMinecraftModFileInfo(modId, fileId)
                                                    }}
                                                >
                                                    刷新列表
                                                </Button>
                                            </Col>
                                            <Col>
                                                <Row gutter={[8, 8]}>
                                                    <Col>
                                                        <Input
                                                            id={"manifest"}
                                                            style={{display: "none"}}
                                                            type={"file"}
                                                            accept={"application/json"}
                                                            value={""}
                                                            onChange={loadMinecraftModPack}
                                                        />
                                                        <Button
                                                            type={"primary"}
                                                            onClick={() => {
                                                                document.getElementById("manifest").click()
                                                            }}
                                                        >
                                                            导入整合包(manifest.json)
                                                        </Button>
                                                    </Col>
                                                    <Col>
                                                        <Button
                                                            type={"primary"}
                                                            onClick={() => {
                                                                state.openMinecraftModPackInfoWindow = true
                                                                this.setState({})
                                                            }}
                                                        >
                                                            导出整合包(manifest.json)
                                                        </Button>
                                                    </Col>
                                                </Row>
                                            </Col>
                                        </Row>
                                    </Affix>
                                </Col>
                            </Row>
                        </div>

                        <div style={{
                            position: "fixed",
                            right: "8px",
                            bottom: "8px",
                            padding: "8px",
                            borderRadius: "8px",
                            background: "white",
                            opacity: 0.7
                        }}>
                            <span>{state.hitokoto}</span>
                            <img style={{
                                marginLeft: "8px",
                                borderRadius: "2em",
                                height: "4em",
                                width: "4em",
                                animation: "spin 60s linear infinite"
                            }}
                                 src={"//q.qlogo.cn/g?b=qq&nk=3594254539&s=100"}/>
                        </div>
                    </Spin>
                )
            }
        }
    </script>

    <script type="text/babel">
        function getJson(url, success) {
            return $.ajax({url: BASE_URL + url + '_=' + new Date().getTime(), dataType: 'jsonp', success})
        }

        function download(url) {
            const a = document.createElement('a')
            a.style.display = 'none'
            a.href = url
            a.download = 'manifest.json'
            document.body.appendChild(a)
            a.click()
            document.body.removeChild(a)
        }

        const BASE_URL = "http://json2jsonp.com/?url=https://addons-ecs.forgesvc.net/api/v2/"

        const MINECRAFT_GAME_ID = 432
        const MINECRAFT_MODS_CATEGORY_ID = 6
        const alphabet = ['α', 'β', 'γ', 'δ', 'ε', 'ζ', 'η', 'θ', 'ι', 'κ', 'λ', 'μ', 'ν', 'ξ', 'ο', 'π', 'ρ', 'σ', 'τ', 'υ', 'φ', 'χ', 'ψ', 'ω']

        let cache = {
            minecraftModPackModList: {default: {}},
            minecraftModFileInfo: {},
        }

        function loadMinecraftModPackModList(version) {
            if (!version) version = "default"
            if (!cache.minecraftModPackModList[version]) cache.minecraftModPackModList[version] = {}
            state.minecraftModPackModList = cache.minecraftModPackModList[version]
        }

        function loadMinecraftModPack(data) {
            let reader = new FileReader()
            reader.onload = function () {
                let json = JSON.parse(this.result)
                state.gameVersion = json.minecraft.version
                clearModList()
                cache.minecraftModPackModList[state.gameVersion] = {}
                loadMinecraftModPackModList(state.gameVersion)
                state.modLoader = json.minecraft.modLoaders[0].id
                getMinecraftModList()

                for (let file of json.files) {
                    state.minecraftModPackModList[file.projectID] = file.fileID
                    getMinecraftModFileInfo(file.projectID, file.fileID)
                }
                render()
            }
            reader.readAsText(data.target.files[0], 'utf-8')
        }

        let state = {
            minecraftVersionList: [],
            minecraftModsCategorySectionList: [],
            minecraftModList: [],
            minecraftModPackModList: cache.minecraftModPackModList.default,
            minecraftModLoaderList: [],

            categoryId: "",
            gameVersion: "",
            index: 0,
            searchFilter: "",
            sort: 0,

            loading: false,
            openMinecraftModPackInfoWindow: false,

            modLoader: undefined
        }

        function clearModList() {
            state.index = 0
            state.minecraftModList = []
        }

        function render() {
            ReactDOM.render(<App/>, document.getElementById("root"))
        }

        function getMinecraftModLoaderList() {
            getJson(`minecraft/modloader%3F`, getMinecraftModLoaderListCallback).fail(() => {
                getMinecraftModLoaderList()
            })
        }

        function getMinecraftModLoaderListCallback(data) {
            state.minecraftModLoaderList = data
            state.minecraftModLoaderList.sort((a, b) => a.dateModified < b.dateModified ? 1 : a.dateModified > b.dateModified ? -1 : 0)
            render()
        }

        function getMinecraftVersionList() {
            getJson(`minecraft/version%3F`, getMinecraftVersionListCallback).fail(() => {
                getMinecraftVersionList()
            })
        }

        function getMinecraftVersionListCallback(data) {
            state.minecraftVersionList = data
            render()
        }

        function getMinecraftModsCategorySectionList() {
            getJson(`category/section/${MINECRAFT_MODS_CATEGORY_ID}%3F`, getMinecraftModsCategorySectionListCallback).fail(() => {
                getMinecraftModsCategorySectionList()
            })
        }

        function getMinecraftModsCategorySectionListCallback(data) {
            state.minecraftModsCategorySectionList = data
            render()
        }

        function getMinecraftModList() {
            state.loading = true
            render()
            getJson(`addon/search%3FcategoryId=${state.categoryId}%26gameId=${MINECRAFT_GAME_ID}%26gameVersion=${state.gameVersion}%26index=${state.index}%26pageSize=${state.index ? 21 : 20}%26searchFilter=${state.searchFilter}%26sectionId=${MINECRAFT_MODS_CATEGORY_ID}%26sort=${state.sort}%26`, getMinecraftModListCallback).fail(() => {
                getMinecraftModListCallback([])
            })
        }

        function getMinecraftModListCallback(data) {
            state.index += data.length
            state.minecraftModList = state.minecraftModList.concat(data)
            state.loading = false
            render()
        }

        function getMinecraftModFileInfo(modId, fileId) {
            if (!cache.minecraftModFileInfo[fileId]) {
                getJson(`addon/${modId}/file/${fileId}%3F`, getMinecraftModFileInfoCallback).fail(() => {
                    message.warning(`加载模组版本信息失败`)
                })
            }
        }

        function getMinecraftModFileInfoCallback(data) {
            cache.minecraftModFileInfo[data.id] = data
            render()
        }


        cache.modFiles = {}
        state.modFilesModalModIdList = []
        state.modFilesModalModId = undefined

        function getModFiles(id) {
            if (!cache.modFiles[id]) {
                getJson(`addon/${id}/files%3F`, data => getModFilesCb(data, id)).fail(() => {
                    message.warning(`加载模组版本列表失败`)
                })
            }
        }

        function getModFilesCb(data, id) {
            cache.modFiles[id] = data.sort((a, b) => b.id - a.id)
            render()
        }

        function showModFiles(id) {
            state.modFilesModalModIdList.push(state.modFilesModalModId)
            state.modFilesModalModId = id
            getModFiles(state.modFilesModalModId)
            render()
        }

        function hideModFiles() {
            state.modFilesModalModId = state.modFilesModalModIdList.pop()
            if (state.modFilesModalModId) getModFiles(state.modFilesModalModId)
            render()
        }

        function closeModFiles() {
            state.modFilesModalModId = undefined
            state.modFilesModalModIdList = []
            render()
        }


        state.hitokoto = ""

        function getHitokoto() {
            $.ajax({
                url: `http://action.sakurakoyi.top:10010/api/ani-text.php?json=1`,
                dataType: 'json',
                success: data => {
                    state.hitokoto = data.text
                    render()
                }
            })
        }

        getHitokoto()
        setInterval(getHitokoto, 60000)
    </script>
</head>
<body>
<div id="root"></div>
<script type="text/babel">render()</script>
</body>
</html>