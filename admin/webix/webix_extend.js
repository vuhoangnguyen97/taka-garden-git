webix.debug = false;

//////////////////////// remove ->
function setupPage() { }
// <- remove //////////////////////

if (!window.mtos) {
    mtos = {};
};

//--- User Storage (in Browser Session) ---//
mtos.user = {
    _storage: webix.storage.session,

    //////////////////////// remove ->
    _temp_user_info: {
        "signedOnCharacterEncoding": "null",
        "signedOnRemoteAddress": "null",
        "pageRows": "",
        "cntCd": "",
        "creUsrId": "MIGUSER",
        "creDt": "2016-11-16",
        "updUsrId": "OPUSADM",
        "updDt": "2017-11-01",
        "ofcEngNm": "Laem Chabang",
        "ofcKrnNm": "NYK Auto Logistics (Thailand) Co., Ltd.",
        "userAuth": [
            "CARDEV"
        ],
        "mnScrnOptId": "",
        "rhqOfcCd": "LCHA1",
        "mphnNo": "82010222205",
        "faxNo": "8225799999",
        "srepCd": "",
        "accessSystem": "ALP",
        "ofcOrgCd": "LCHA1",
        "usrPwdCreDt": "20171103093546",
        "usrLckDt": "",
        "orgOfcId": "LCHA1",
        "rhqOfcId": "LCHA1",
        "srepId": "",
        "usrLginFaldKnt": "0",
        "langTpCd": "EN",
        "ofcId": "LCHA1",
        "ofcCd": "LCHA1",
        "usrId": "OPUSADM",
        "usrTheme": "",
        "usrPwd": "AA51C478DBD99EC5",
        "usrAuthTpCd": "A",
        "xtnPhnNo": "8221022229999",
        "usrLoclNm": "OPUS ADMIN",
        "usrNm": "OPUS ADMIN",
        "usrEml": "opusadm@cyberlogitec.com",
        "useFlg": "Y"
    },
    // <- remove //////////////////////

    _init: webix.once(function () {
        if (webix.storage.session.get("usrId") === null) {
            mtos.ajax.post_sync("MTOSApp", "UserInfoService", "getUserInfo",
                { "EmptyUserInfo": { "info": "true" } },
                function (text, data, XmlHttpRequest) {
                    var userInfo = data.json().header.dataContainer['clt.web.signon.SIGN_ON_USER_ACCOUNT'];

                    if (webix.isUndefined(userInfo)) {
                        userInfo = mtos.user._temp_user_info;   // will remove
                    }
                    // console.log('USER:\n%o', userInfo);
                    for (var key in userInfo) {
                        webix.storage.session.put(key, userInfo[key]);
                    }
                });
        }
    }),

    clear: function () {
        this._storage.clear();
    },

    get: function (name) {
        this._init();
        return this._storage.get(name);
    },

    put: function (name, value) {
        this._storage.put(name, value);
    },

    remove: function (name) {
        this._storage.remove(name);
    }
};

//--- Server Interaction (AJAX) ---//
mtos.ajax = {
    _getJsonData: function (application, service, operation, data) {
        var requestData = {};
        requestData["header"] = { "application": application, "service": service, "operation": operation };

        if (!webix.isUndefined(data) && data != null) {
            for (var key in data) {
                requestData[key] = data[key];
            }
        }
        return requestData;
    },

    post_sync: function (application, service, operation, data, call) {
        var requestData = this._getJsonData(application, service, operation, data);
        webix.ajax().sync().headers({ "Content-type": "application/json" }).post("/serviceEndpoint/json", requestData, function (text, data, XmlHttpRequest) {
            var result = data.json().header;
            if (result.errorMessageProcessed) {
                console.error('error: %o', result);
                // return false;
            }
            call(text, data, XmlHttpRequest);
        });
    },

    post_async: function (application, service, operation, data, call) {
        var requestData = this._getJsonData(application, service, operation, data);
        webix.ajax().headers({ "Content-type": "application/json" }).post("/serviceEndpoint/json", requestData, function (text, data, XmlHttpRequest) {
            var result = data.json().header;
            if (result.errorMessageProcessed) {
                console.error('error: %o', result);
                // return false;
            }
            call(text, data, XmlHttpRequest);
        });
    }
};

//--- Util Script : TODO seperate Utils JS ---//
if (!window.mtos.utils) {
    mtos.utils = {};
};
mtos.utils.char = {
    inputCodeCheck: function (inValue, config) {
        if (webix.isUndefined(config)) {
            return true;
        }

        var accpKeyAll = config.acceptKeys;

        if (accpKeyAll == null || accpKeyAll == "") {
            return true;
        }

        var accpKeys = "";
        var lngKeys = "";	//E:ENGLISH, N:NUMBER
        var keysIdx = accpKeyAll.indexOf("[");
        var match = false;
        var regExpRes = null;

        if (keysIdx >= 0) {
            accpKeys = accpKeyAll.substring(keysIdx, accpKeyAll.length);
        }

        if (keysIdx > 0) {
            lngKeys = accpKeyAll.substring(0, keysIdx);
        } else {
            lngKeys = accpKeyAll;
        }

        acpEng = lngKeys.indexOf("E") > -1 ? true : false;
        acpNum = lngKeys.indexOf("N") > -1 ? true : false;

        accpKeys = accpKeys.substring(1, accpKeys.length - 1);
        accpKeys = mtos.utils.char.specialCharReplace(accpKeys);

        if (acpEng && acpNum) {
            regExpRes = new RegExp("^[a-zA-Z0-9" + accpKeys + "]*$", "g");
            // console.log("^[a-zA-Z0-9" + accpKeys + "]*$");
        } else if (acpEng) {
            regExpRes = new RegExp("^[a-zA-Z" + accpKeys + "]*$", "g");
        } else if (acpNum) {
            regExpRes = new RegExp("^[0-9" + accpKeys + "]*$", "g");
        }

        var checkResult = regExpRes.exec(inValue);
        if (checkResult == null) {
            return false;
        }

        return true;
    },
    specialCharReplace: function (accpKeys) {
        accpKeys = accpKeys.replace(/\\/g, "\\\\");
        accpKeys = accpKeys.replace("]", "\\]");
        accpKeys = accpKeys.replace("-", "\\-");
        return accpKeys;
    }
};

//--- Webix Extend ---//
mtos.hsheet = {
    findIndexById: function (map, id) {
        if (map != undefined && map != null) {
            for (var index = 0; index < map.length; index++) {
                if (map[index].id === id) {
                    return index;
                }
            }
        }
        return -1;
    },

    getColumn: function (columns, id) {
        var _column = null;
        columns.each(function (column) {
            if (column.id === id) {
                _column = column;
                return false;
            }
        });

        return _column;
    },

    getColumnArray: function (columns) {
        var _columns = [];
        columns.each(function (column) {
            _columns.push(column.id);
        });

        return _columns;
    },

    getDefaultColumnArray: function (columns) {
        var _columns = [];

        columns.each(function (column) {
            if (!webix.isUndefined(column.defaultValue)) {
                _columns.push(column);
            }
        });

        return _columns;
    },

    removeFilterContent: function (columns) {
        var hasFilter = false;
        $.each(columns, function (index, value) {

            if (Array.isArray(value.header)) {
                var headArr = value.header;

                $.each(value.header, function (index, value) {
                    if (value.hasOwnProperty('content')) {
                        hasFilter = true;
                        headArr.splice($.inArray(value.content, headArr), 1);
                    }
                });
            }
        });

        return hasFilter;
    }
};

// mtos - validate
// example : MESSAGE_MINLENGTH({'minlength':'10'});
var MESSAGE_ACCEPTKEY = _.template("Invaild character contained.");
var MESSAGE_MINLENGTH = _.template("This field length must be at least ${minlength} length.");    // minlength
// from webix.rules
var MESSAGE_IS_CHECKED = _.template("Checkbox must be checked.");
var MESSAGE_IS_EMAIL = _.template("Email address is not valid.");
var MESSAGE_IS_NOT_EMPTY = _.template("This field should not be empty.")
var MESSAGE_IS_NUMBER = _.template("Only numbers are available.")

mtos.validate = {
    acceptKeys: function (value, column) {
        if (!webix.isUndefined(value) && value != "") {
            if (!(mtos.utils.char.inputCodeCheck(value, column))) {
                return MESSAGE_ACCEPTKEY();
            }
        }
    },
    minlength: function (value, column) {
        if (!webix.isUndefined(value)) {
            if (value.length < column.minlength) {
                return MESSAGE_MINLENGTH({ 'minlength': column.minlength });;
            }
        }
    },
    // from webix.rules
    isChecked: function (value, column) {
        if (!webix.rules.isChecked(value)) {
            return MESSAGE_IS_CHECKED();
        }
    },
    isEmail: function (value, column) {
        if (!webix.rules.isEmail(value)) {
            return MESSAGE_IS_EMAIL();
        }
    },
    isNotEmpty: function (value, column) {
        if (!webix.rules.isNotEmpty(value)) {
            return MESSAGE_IS_NOT_EMPTY();
        }
    },
    isNumber: function (value, column) {
        if (!webix.rules.isNumber(value) && webix.rules.isNotEmpty(value)) {
            return MESSAGE_IS_NUMBER();
        }
    }
};


webix.protoUI({
    name: "hsheet",

    status: false,

    _load_data: null,       // Array

    _changed_data: null,    // PowerArray
    _delete_data: null,     // PowerArray

    _defaultColumnArray: [],

    // when a row is deleted, the delete row data is stored in the temporary storage(_changed_data)
    $option_buffer_delete: false,

    afterMoveFunction: undefined,

    _dumpColums: null,
    _orgColums: null,
    _filterId: null,
    _absoluteColumns:null,
    _contextMenuId:null,

    $init: function (config) {
        // add default ibflag value
        if (webix.isUndefined(config.scheme)) {
            config.scheme = { ibflag: "I" };
        } else {
            config.scheme.ibflag = "I";
        }

        //auto resize
        config.resizeColumn = true;
        config.resizeRow = true;

        config.dragColumn = true;
        
        // keyboard navigation
        config.navigation = true;

        // 1. Add Columns ( DEL:check, ibflag:hidden)
        var LOCAL_SAVE_COLUMN = webix.storage.local.get(curPgmName+"_"+config.id);
        if (LOCAL_SAVE_COLUMN) {
            if (this._orgColums) {
                config.columns = getSavedColumns(this._orgColums, LOCAL_SAVE_COLUMN);
            } else {
            	config.columns = getSavedColumns(config.columns, LOCAL_SAVE_COLUMN);
            }
        }
        
        this._absoluteColumns = webix.copy(config.columns);
        var contextColList = JSON.stringify(getColumnListForContextmenu(config.columns));
        var _columns = webix.toArray(config.columns);
        var _columnArray = mtos.hsheet.getColumnArray(_columns);

        this._defaultColumnArray = mtos.hsheet.getDefaultColumnArray(_columns);

        // DEL Columns
        if (!_.includes(_columnArray, 'DEL')) {
            _columns.insertAt({
                // id: "DEL", header: { content: "masterCheckbox", css: "center", contentId: "DEL" }, css: "center", template: "{common.checkbox()}", width: 40, hidden: true,
                id: "DEL", header: { content: "delCheckbox", css: "center", contentId: "DEL" }, css: "center", template: "{common.checkbox()}", width: 40, hidden: true,
            }, 0);
        }

        // id Columns
        if (!_.includes(_columnArray, 'id')) {
            _columns.insertAt({
                id: "id", header: "ID", hidden: true, width: 200
            }, _columns.length);
        }

        // ROWNUM Columns
        if (!_.includes(_columnArray, 'ROWNUM')) {
            _columns.insertAt({
                id: "ROWNUM", header: "ROW", hidden: true,
            }, _columns.length);
        }

        // ibflag Columns
        if (!_.includes(_columnArray, 'ibflag')) {
            _columns.insertAt({
                id: "ibflag", header: "status", hidden: true,
            }, _columns.length);
        }

        // column Array Rebuild
        _columnArray = mtos.hsheet.getColumnArray(_columns);

        if (config.status) {
            mtos.hsheet.getColumn(_columns, 'DEL').hidden = false;
        }

        if (webix.debug) {
            mtos.hsheet.getColumn(_columns, 'id').hidden = false;
            mtos.hsheet.getColumn(_columns, 'ROWNUM').hidden = false;
            mtos.hsheet.getColumn(_columns, 'ibflag').hidden = false;
        }

        // column Rule Add
        if (webix.isUndefined(config.rules)) {
            config.rules = {};
        }

        _columns.each(function (_column) {
            // message init
            var _vaildFns = [];

            if (!webix.isUndefined(config.rules[_column.id])) {
                _vaildFns.push(config.rules[_column.id]);
            }

            // RULE : acceptKeys 
            if (!webix.isUndefined(_column.acceptKeys)) {
                _vaildFns.push(mtos.validate.acceptKeys);
            }

            // RULE : minlength
            if (!webix.isUndefined(_column.minlength)) {
                _vaildFns.push(mtos.validate.minlength);
            }

            // RULE : required
            if (!webix.isUndefined(_column.required) && _column.required) {
                _vaildFns.push(mtos.validate.isNotEmpty);
            }

            // Setting Rule
            if (_vaildFns.length > 0) {
                config.rules[_column.id] = function (value, obj, key) {
                    var message = null;
                    var result = true;

                    for (var i = 0; i < _vaildFns.length; i++) {
                        var _message = _vaildFns[i](value, _column);
                        if (!webix.isUndefined(_message)) {
                            message = _message;
                            result = false;
                            break;
                        }
                    }

                    var _css = obj.id + '-' + key;

                    if (message != null) {
                        this.data.$violate_messages[_css] = message;
                        this.addCellCss(obj.id, key, _css);

                        // console.log("Validate Result -> %o, %o", value, result);
                        return result;
                    } else {
                        if (this.data.$violate_messages[_css] !== undefined) {
                            this.data.$violate_messages[_css] = undefined;
                        }
                        return true;
                    }
                }
            }
        });

        // Set ibflag='R' after Loading
        this.data.attachEvent("onStoreLoad", function (driver, data) {
            var owner = $$(this.owner);
            owner._load_data = [];
            owner._changed_data = webix.toArray();
            owner._delete_data = webix.toArray();

            // check view column
            owner._defaultColumnArray.forEach(function (column) {
                data.forEach(function (_obj, index) {
                    if (!_obj.hasOwnProperty(column.id)) {
                        _obj[column.id] = column.defaultValue;
                    }
                });
            })

            // check loading column
            this.each(function (_obj, i) {
                _obj.DEL = 0;
                _obj.ibflag = "R";
                _obj.ROWNUM = i + 1;    // create ROWNUM

                for (var key in _obj) {
                    if (!_.includes(_columnArray, key)) {
                        delete _obj[key];
                    }
                }

                owner._load_data.push(webix.copy(_obj));
            });

            // violate message init
            this.$violate_messages = {};
            this.$violate_tooltips = {};
        });

        this.data.attachEvent("onStoreUpdated", function (id, obj, operation) {
            if (operation === null || operation === 'paint') {
                return true;
            }

            var owner = $$(this.owner);
            var $selectedId = owner.getSelectedId();

            // ROWNUM
            if (_.includes(['add', 'update', 'delete', 'save', 'move'], operation)) {
                this.each(function (_obj, i) {
                    _obj.ROWNUM = i + 1;
                });
            }

            if (!webix.isUndefined(config.afterMoveFunction)) {
                config.afterMoveFunction(id, obj, owner.data);
            }

            var changed_index = mtos.hsheet.findIndexById(owner._changed_data, obj.id);
            var loaded_index = mtos.hsheet.findIndexById(owner._load_data, obj.id);

            if (operation === 'add') {
                if (changed_index !== -1) {
                    owner._changed_data[changed_index] = obj;
                } else {
                    owner._changed_data.push(obj);
                }
            } else if (operation === 'update' || operation === 'save') {
                if (obj.ibflag !== 'I') {
                    obj.ibflag = 'U';
                }
                if (changed_index !== -1) {
                    owner._changed_data[changed_index] = obj;
                } else {
                    owner._changed_data.push(obj);
                }
            } else if (operation === 'delete') {
                if (obj.ibflag === 'I' || !owner.$option_buffer_delete) {
                    owner._changed_data.removeAt(changed_index);
                } else {
                    if (loaded_index !== -1) {
                        var org_obj = owner._load_data[loaded_index];
                        var delete_obj = webix.copy(org_obj);
                        delete_obj.ibflag = 'D';

                        if (changed_index === -1) {
                            owner._changed_data.push(delete_obj);
                        } else {
                            owner._changed_data[changed_index] = delete_obj;
                        }
                    }
                }
            } else if (operation === 'move') {
                if (!webix.isUndefined(config.afterMoveFunction)) {
                    config.afterMoveFunction(id, obj, owner.data);
                }
            }

            // Changed Data Setting (Compare _load_data)
            if (operation !== 'delete') {
                var changed_index = mtos.hsheet.findIndexById(owner._changed_data, obj.id);
                if (changed_index !== -1) {         // except delete Case
                    var _changed = {};

                    var loaded_index = mtos.hsheet.findIndexById(owner._load_data, obj.id);
                    // add obj case (ibflag : 'I')
                    if (loaded_index === -1) {
                        for (var key in obj) {
                            if (obj[key].length != 0) {
                                _changed[key] = obj[key];
                            }
                        }
                    } else {    // Modify obj case (ibflag : 'U', 'R')
                        var org_obj = owner._load_data[loaded_index];
                        for (var key in obj) {
                            if (!_.includes(['ibflag'], key)) {
                                var _old = org_obj[key];
                                var _new = obj[key];

                                if (_old != _new && !(_new instanceof Array) && !(_new instanceof Object)) {
                                    _changed[key] = _new;
                                    // console.log("%s: %s -> %s", key, _old, _new);
                                }
                            }
                        }

                        if (Object.keys(_changed).length === 0) {
                            obj.ibflag = 'R';
                            owner._changed_data.removeAt(changed_index);
                        }
                    }

                    // Change CSS - changed Data
                    for (var key in obj) {
                        // if( !_.includes(['R', 'D'], obj.ibflag)) {
                        if (!_.includes(['ROWNUM', 'DEL', 'ibflag', 'id'], key)) {
                            if (_changed.hasOwnProperty(key)) {
                                owner.addCellCss(id, key, 'hsheet-changed');
                            } else {
                                owner.removeCellCss(id, key, 'hsheet-changed');
                            }
                        }
                    }

                    // Change CSS - default Value
                    owner._defaultColumnArray.forEach(function (column) {
                        if (obj[column.id] === column.defaultValue) {
                            owner.removeCellCss(id, column.id, 'hsheet-changed');
                        }
                    });
                }
            }

            // filter (include unselect) patch
            if (!webix.isUndefined($selectedId)) {
                var $selectedItem = owner.getItem($selectedId);
                if (!webix.isUndefined($selectedItem) && webix.isUndefined($selectedItem.hidden)) {
                    owner.select($selectedId);
                } else {
                    var firstId = owner.getFirstId();
                    if (!webix.isUndefined(firstId)) {
                        owner.select(owner.getFirstId());
                    }
                }
            }

            // console.log("onStoreUpdated -> id: %s, obj : %o, operation : %s, changed_data : %o", id, obj, operation, owner._changed_data);
            return true;
        });

        this.attachEvent("onAfterLoad", function () {
            // validate
            this.validate();
        });

        this.attachEvent("onKeyPress", function (code, e) {
            e = (e || event);
            var allowedKey = [8];	//backspace
            if (allowedKey.indexOf(code) > -1) {
                return true;
            }
            return mtos.utils.char.inputCodeCheck(e.key, this.getColumnConfig(this.$editCol));
        });

        // Event Process
        // 0. onItemClick
        // 1. onBeforeEditStart
        // 2. onAfterEditStart
        // 3. onBeforeEditStop
        // >>>> onStoreUpdated -> validation
        // 4. onAfterEditStop

        // 0. onItemClick
        this.attachEvent("onItemClick", function (id, e, trg) {
            // console.log("onItemClick-> %o, %o, %o", id, e, trg);
        });

        // 1. onBeforeEditStart
        this.attachEvent("onBeforeEditStart", function (id) {
            // console.log("onBeforeEditStart-> %o", id);
        });

        // 2. onAfterEditStart
        this.attachEvent("onAfterEditStart", function (id) {
            var colConfig = this.getColumnConfig(id.column);

            //maxlength
            if (colConfig.maxlength != null) {
                this.getEditor().getInputNode().setAttribute("maxlength", colConfig.maxlength);
            }

            //minlength
            if (colConfig.maxlength != null) {
                this.getEditor().getInputNode().setAttribute("minlength", colConfig.minlength);
            }

            // toCase
            if (colConfig.toCase != null) {
                var _charCase = colConfig.toCase;
                if ("UPPER" === _charCase.toUpperCase()) {
                    this.getEditor().getInputNode().setAttribute("oninput", "javascript: this.value = this.value.toUpperCase();");
                } else {
                    this.getEditor().getInputNode().setAttribute("oninput", "javascript: this.value = this.value.toLowerCase();");
                }
            }

            //edit column : for 'onKeyPress' Event
            this.$editCol = id.column;

            // console.log("onAfterEditStart-> %o", id);
        });

        // 3. onBeforeEditStop
        this.attachEvent("onBeforeEditStop", function (state, editor) {
            // console.log("onBeforeEditStop-> %o, %o", state, editor);
        });

        // 4. onAfterEditStop
        this.attachEvent("onAfterEditStop", function (state, editor) {
            // console.log("onAfterEditStop-> %o, %o", state, editor);
        });

        // onValidationError
        this.attachEvent("onValidationError", function (id, obj, details) {
            // console.log("onValidationError-> %o, %o, %o", id, obj, details);
        });

        // onValidationSuccess
        this.attachEvent("onValidationSuccess", function (id, obj) {
            // console.log("onValidationSuccess-> %o, %o ", id, obj);
        });

        this.attachEvent("onAfterColumnDrop", function (id, obj) {
        	saveColumns(this.config.id, this.config.columns);
        });
                
        this.attachEvent("onAfterRender", function (data) {
            for (var _css in data.$violate_messages) {
                var _target = $('.' + _css);

                if (_target.length > 0) {
                    var _message = data.$violate_messages[_css];
                    if (_message !== undefined) {
                        var _tooltip = new Tooltip(_target, { placement: 'bottom', title: _message });
                        data.$violate_tooltips[_css] = _tooltip;
                    } else {
                        data.$violate_tooltips[_css] = undefined;
                    }
                }
            }
            // console.log("onAfterRender %o > tooltips: %o, messages : %o", data.owner, data.$violate_tooltips, data.$violate_messages);
        });

        this.attachEvent("onAfterValidation", function (result, value) {
            // console.log("onAfterValidation-> %o, %o", result, value);
        });

        this.attachEvent("onCheck", function(row, column, state){
            if( column === 'DEL') {
                var _obj = this.getItem(row);
                if (_obj.DEL === 1 && _obj.ibflag === 'I') {
                    this.remove(row);
                    // this.filterByAll();
                }
            }
        });

        // Head filter setting
        this._orgColums = webix.copy(config.columns);
        this._dumpColums = webix.copy(config.columns);
        this._absoluteColumns = webix.copy(config.columns);

        //clear filter & dump columns
        var hasFilter = mtos.hsheet.removeFilterContent(this._dumpColums);
        var _contextMenuId = config.id + "_contextMenu";
        this._contextMenuId = _contextMenuId;
        var contextMenu = $$(this._contextMenuId);
        
        if(!contextMenu) {
        	this.setContextMenu(this.$view, config, _contextMenuId, contextColList, hasFilter);
        }
    },
    setContextMenu: function (view, config, contextMenu, contextColList, hasFilter) {
       var isFiltered = false;
       webix.ui({
           view: "contextmenu",
           id: contextMenu,
           width: 200,
           template: function(obj){
               return "<input  type='checkbox' "+(obj.checked?"checked":"")+" class='mycheckbox'>&nbsp;" + obj.value;
           },
           onClick: {
                mycheckbox: function(e,id,node){
                    var ctxList = JSON.parse(contextColList);
                    var selid = this.getItem(id).checked = node.checked;
                            
                    if (this.getItem(id).value == 'Filter') {
                        if (this.getItem(id).checked) {
                            $$(config.id).showFilter();
                            isFiltered = true;
                        } else {
                            $$(config.id).hideFilter();
                            isFiltered = false;
                        }	
                    } else {
                        if (this.getItem(id).checked) {
                            $$(config.id).showColumn(id);
                        } else {
                            $$(config.id).hideColumn(id);
                        }
                        
                        $$(config.id).refineColumnDatas(!isFiltered);
                        $.each(ctxList.data, function(i, col){
                            if (col.id == id ) {
                                col.checked = selid;
                            }		
                        });
                            
                        contextColList = JSON.stringify(ctxList);
                        $$(contextMenu).parse(contextColList);
                        saveColumns(config.id, config.columns);
                    }
                }
           },
           on:{ 
               onBeforeShow: function(){
                   $$(contextMenu).clearAll();
                   if (hasFilter) {
                        $$(contextMenu).add({id: 'filter',value: "Filter", checked: isFiltered}, -1);
                        $$(contextMenu).add({ $template:"Separator" }, -1);
                   } 
                   
                   if(contextColList.length > 0) {
                        $$(contextMenu).parse(contextColList);
                   }
               }
           }
       });
       
       webix.event(view, "contextmenu", function (e) {
           var pos = $$(config.id).locate(e);
           if (pos && !pos.row) {
               $$(contextMenu).show(e);
           }
       })

       view.oncontextmenu = function () { return false };
           if (!config.filterInit) {
           config.columns = this._dumpColums;
       }
    },
    // clear hidden row
    $clear_hidden_row: function () {
        var owner = this;
        this.editStop();

        if (this.config.status) {
            this.find(function (obj) {
                if (obj.DEL === 1 && obj.ibflag === 'I') {
                    owner.remove(obj.id);
                }
            });
        }
    },

    // clear all
    clearRow: function () {
        this.clearAll();
        // Data Clear (_load_data, _changed_data)
        this._load_data = [];
        this._changed_data = webix.toArray();
    },

    // reload data
    reload: function (data, type) {
        this.clearRow();
        this.parse(data, type);
    },

    // add row
    addRow: function (obj, index, call) {
        this.$clear_hidden_row();        // clear hidden data
        var selectId = this.getSelectedId();
        var id;

        // set column default value
        this._defaultColumnArray.forEach(function (column) {
            obj[column.id] = column.defaultValue;
        });

        if (webix.isUndefined(selectId) || index === -1) {
            id = this.add(obj);
        } else {
            var index = this.getIndexById(selectId);
            id = this.add(obj, index + 1);
        }

        if (!webix.isUndefined(call)) {
            call(id, this.getItem(id), this.data);
        }
    },

    // move down row
    moveDownRow: function (step, call) {
        this.$clear_hidden_row();        // clear hidden data

        var id = this.getSelectedId();
        if (webix.isUndefined(id)) {
            return false;
        }

        var obj = this.getItem(id);
        if (obj.ROWNUM === this.count()) {
            return false;
        }

        this.moveDown(id, step);
        if (!webix.isUndefined(call)) {
            call(id, obj, this.data);
            // this.refresh();
        }

        this.select(id);
    },

    // move up row
    moveUpRow: function (step, call) {
        this.$clear_hidden_row();        // clear hidden data

        var id = this.getSelectedId();
        if (webix.isUndefined(id)) {
            return false;
        }

        var obj = this.getItem(id);
        if (obj.ROWNUM === 1) {
            return false;
        }

        this.moveUp(id, step);
        if (!webix.isUndefined(call)) {
            call(id, obj, this.data);
        }

        this.select(id);
    },

    // delete Row
    deleteRow: function (data) {
        var owner = this;
        data = data || [];
        if (this.config.status) {
            if (data.length === 0) {
                data = getDeletData();
            }

            data.forEach(function (obj) {
                owner.remove(obj.id);
            });
            this.getHeaderContent("DEL").uncheck();
        }
    },

    // return delete data
    getDeleteData: function () {
        this.$clear_hidden_row();        // clear hidden data

        var owner = this;
        var result = [];
        if (this.config.status) {
            this.find(function (obj) {
                if (obj.DEL === 1) {
                    var loaded_index = mtos.hsheet.findIndexById(owner._load_data, obj.id);
                    result.push(owner._load_data[loaded_index]);
                }
            })
        }
        return result;
    },

    // return save data
    getSaveData: function () {
        this.$clear_hidden_row();        // clear hidden data
        var result = [];

        this._changed_data.each(function (obj) {
            if (webix.isUndefined(obj.DEL) || obj.DEL === 0) {
                result.push(obj);
            }
        });

        return result;
    },

    hideFilter: function () {
    	this.refineColumnDatas(false);
    	this.refreshColumns(this._dumpColums);
    	this.resetColumnDatas(this._orgColums);
    },
    showFilter: function () {
    	this.refineColumnDatas(true);
    	this.refreshColumns(this._orgColums);
    	this.resetColumnDatas(this._dumpColums);
    },
    addFirstIndexMenuItem: function (args) {
        var objId = this._filterId;
        $.each(args, function () {
            $$(objId).add(this, 0);
        });
        $$(objId).add({ $template: "Separator" }, args.length);

    },
    addLastIndexMenuItem: function (args) {
        var objId = this._filterId;
        $$(objId).add({ $template: "Separator" }, $$(objId).count());
        $.each(args, function () {
            $$(objId).add(this);
        });
    },
    refineColumnDatas: function (isFiltered) {
    	var refineColumns = [];
    	var absoluteColumns = _.cloneDeep(this._absoluteColumns);
    	
    	if (isFiltered) {
    		columns= this._dumpColums
    	} else {
    		columns = this._orgColums
    	}
    	
    	$.each(columns, function(i, acol){
    		$.each(absoluteColumns, function(j, col){
                if (col.id == acol.id) {
                    if (!isFiltered && Array.isArray(col.header)) {
                        var headArr = col.header;
                        var hasTitle = false;
                        var title;
                        $.each(headArr, function (index, value) {
                            if (value == null) {
                                headArr.splice(-1, 1);
                            } else if (value.hasOwnProperty('content')) {
                              	headArr.splice($.inArray(value.content, headArr), 1);
                            } else if (value.hasOwnProperty('rowspan')) {
                               	title = value.text;
                               	hasTitle = true;
                            }
                        });
                        
                        if (hasTitle) {
                        	col.header = title;
                        }
                    }
                    refineColumns.push(col);
    	        }
            });
    	});
    	
    	if (isFiltered) {
    		this._orgColums = refineColumns;
    	} else {
    		this._dumpColums = refineColumns;
    	}
    },
    resetColumnDatas: function (columns) {
    	var hiddenColumns = new Object;
    	$.each(this._absoluteColumns, function(i, acol){
    		var isHasValue = false;
    		$.each(columns, function(j, col){
                if (col.id == acol.id) {
                    isHasValue = true;
    	        }
            });
    		
    		if (!acol.footer) {
                acol.footer = [{text:""}];
            }
    		                
    		if (!isHasValue) {
                hiddenColumns[acol.id] = acol;
    		}
    	});
    	this._hidden_column_hash = hiddenColumns;
    	
    	
    	var hiddenColumnOrders = [];
    	$.each(this._absoluteColumns, function(i, acol){
            hiddenColumnOrders.push(acol.id);
    	});
    	this._hidden_column_order = hiddenColumnOrders;
    }
}, webix.ui.datatable);

// Image Toggle
webix.protoUI({
    name: "mtos-image-toggle",
    type: "image",
    onImage: null,
    offImage: null,
    value: "0",
    $init: function (obj) {
        obj.image = obj.offImage;
    },
    toggle: function (obj) {
        if (obj.value == "0") {
            obj.config.image = obj.config.onImage;
            obj.data.image = obj.config.onImage;
            obj.value = "1";
        } else {
            obj.config.image = obj.config.offImage;
            obj.data.image = obj.config.offImage;
            obj.value = "0";
        }
        this.render();
    },
    getOnOff: function () {
        return this.value;
    }
}, webix.ui.button);

webix.ui.datafilter.delCheckbox = webix.extend({
    refresh: function (master, node, config) {
        node.onclick = function () {
            this.getElementsByTagName("input")[0].checked = config.checked = !config.checked;
            var column = master.getColumnConfig(config.columnId);
            var checked = config.checked ? column.checkValue : column.uncheckValue;

            var _data = jQuery.extend(true, [], master.data.order);
            // var _data = jQuery.extend(true, [], Object.values(master.data.pull));
            _data.forEach(function(value) {
                var obj = master.getItem(value);
                // var obj = master.getItem(value.id);
                if (obj) { //dyn loading
                    obj[config.columnId] = checked;
                    master.callEvent("onCheck", [obj.id, config.columnId, checked]);
                    master.data.callEvent("onStoreUpdated", [obj.id, obj, "save"]);
                }
            });
            master.refresh();
        };

        config.compare = config.compare || function (value, filter, obj) {
            // DEL Check && ibflag === 'I'
            if (obj.DEL === 1 && obj.ibflag === 'I') {
                obj.hidden = true;
                return false;
            }
            return true;
        };

        master.registerFilter(node, config, this);
    },
}, webix.ui.datafilter.masterCheckbox);

// Checkbox filter
webix.ui.datafilter.checkboxFilter = webix.extend({
    getInputNode: function (node) {
        return node.firstChild ? node.firstChild.firstChild : {
            indeterminate: true
        };
    },
    getValue: function (node) {
        var value = this.getInputNode(node).checked;
        var three = this.getInputNode(node).indeterminate;
        return three ? "thirdState" : value;
    },
    refresh: function (master, node, value) {
        value.compare = value.compare || function (value, filter) {
            if (value == undefined || value === "N") {
                value = false;
            } else if (value === 1 || value === "Y") {
                value = true;
            }
            //console.log(""node compare : "+ value+ filter, (value == filter));
            if (filter == "thirdState") {
                return true;
            }
            return value == filter;
        };
        master.registerFilter(node, value, this);
        node.querySelector("input").onclick = function (e) {
            if (this.stu == "indeterminate") {
                this.checked = true;
                this.stu = "check";
            } else if (this.stu == "check") {
                this.stu = "unCheck";
            } else if (this.stu == "unCheck") {
                this.stu = "indeterminate";
                this.indeterminate = true;
            }
            master.filterByAll();
        }

        node.querySelector("input").stu = "indeterminate";
        node.querySelector("input").indeterminate = true;
        //  node.querySelector("input").onchange = function () {
        //      master.filterByAll();
        // }
    },
    render: function (master, config) {
        var html = "<input type='checkbox' id='" + config.columnId + "_master'>";
        return html;
    }
}, webix.ui.datafilter.masterCheckbox);

// Text acceptKeys
webix.protoUI({
    name: "acceptKey",
    $cssName: "text",

    $init: function(config) {
        this.attachEvent("onKeyPress", function (code, e) {
            var acceptKeys = config.acceptKeys;
            if(!acceptKeys) { return true; }

            var allowedKey = [8];   //backspace
            if (allowedKey.indexOf(code) > -1) {
                return true;
            }
            
            return mtos.utils.char.inputCodeCheck(e.key, {
                acceptKeys: acceptKeys,
            });
        });
    }
}, webix.ui.text);

mtos.form = {};
mtos.form.validate = {
    acceptKeys:function (value, all_values, name) {
        if (webix.isUndefined(value) || value === "") {
           return true;
        }

        var elementConfig = this.elements[name].config;
        var acceptKeys = elementConfig.acceptKeys;

        if(!acceptKeys) {
            return true;
        }

        var isValid = mtos.utils.char.inputCodeCheck(value, {
            acceptKeys: acceptKeys,
        });


        this.markInvalid(name, MESSAGE_ACCEPTKEY());

        return isValid;
    },
    minlength: function (minlength) {
       return function (value, all_values, name) {
            if(webix.isUndefined(value)) { return; }

            if (value.length < minlength) {
                this.markInvalid(name, MESSAGE_MINLENGTH({ 'minlength': minlength }));
                return false;
            }

            return true;
        };
    },
    isEmail: function (value, all_values, name) {
        if (!webix.rules.isEmail(value)) {
            this.markInvalid(name, MESSAGE_IS_EMAIL());
            return false;
        }

        return true;
    },
    isNumber: function (value, all_values, name) {
        if (!webix.rules.isNumber(value) && webix.rules.isNotEmpty(value)) {
            this.markInvalid(name, MESSAGE_IS_NUMBER());
            return false;
        }

        return true;
    }
};

webix.protoUI({
   name:"iconCombo",
   $cssName:"combo custom",
   $init:function(){
     this.attachEvent("onChange", function(){ this.refresh()})
   },
   
   $render:function(){
   },
   $renderIcon:function(){
     var config = this.config;
     var height = config.aheight - 2*config.inputPadding;
     var padding = (height - 15)/2 -1;
     var html = "";
     
     var iconStyle = "";
     
     if(config.iconType == "commodity"){
    	 iconStyle = "cont_cmdt_";
     }else if(config.iconType == "containerType"){
    	 iconStyle = "cont_type_";
     }
     
     if (config.value){
   	  
    	 var icon = eval("$$(config.suggest).getList().getItem(config.value)."+config.codeId)
    	 iconStyle = iconStyle + icon;
        
    	 html+="<span style='left:"+((config.label?config.labelWidth:0)+2)+"px;height:"
         +(height-padding)+"px;padding-top:"+padding+"px;"
         +" background:none; color:#666' class='webix_input_icon icn "+iconStyle+"'></span>";
       
     };
     
     html+=webix.ui.combo.prototype.$renderIcon.call(this);
     return html;
   }
 }, webix.ui.combo);

/*
var getContCommodityIcon =  function(title, code){
	var style = "webix_icon icn cont_cmdt_#"+code+"#";
	return "<span class='"+style+"'></span>#"+title+"#";
};

var getContTypeIcon = function(title, code){
	var style = "webix_icon icn cont_type_#"+code+"#";
	return "<span class='"+style+"'></span>#"+title+"#";
};
*/
var getContTypeIcon = function(code){
	if (webix.isUndefined(code)) {
		code = "";
	}
	var style = "webix_icon icn cont_type_"+code;
	return "<span class='"+style+"'></span>"+code;
};

var getContCommodityIcon =  function(code){
	if (webix.isUndefined(code)) {
		code = "";
	}
	var style = "webix_icon icn cont_cmdt_"+code;
	return "<span class='"+style+"'></span>"+code;
};

var saveColumns = function(configId, columns) {
    var EDIT_COL_LIST = [];
    $.each(columns, function(i, ele){
        EDIT_COL_LIST.push(ele.id);
    });
        	
    webix.storage.local.put(curPgmName + "_" + configId, EDIT_COL_LIST);
}

var getSavedColumns = function(columns, saves){
	
	var orderedColList = [];
    var hiddenColList = [];
    
    for (var i=0; i < saves.length; i++) {
        $.each(columns, function(j, col){
            if (saves[i] == col.id) {
                orderedColList.push(col);		
            }
        })
    }
            
    $.each(columns, function(i, col){
        if (!orderedColList.includes(col) && !hiddenColList.includes(col)) {
        	if (col.hidden) {
        		col.concealed = false;
        	} else {
        	    col.hidden = true;
        	    col.concealed = true;
        	}
            hiddenColList.push(col);
        }
    });
	
	return orderedColList.concat(hiddenColList);
};

var getColumnListForContextmenu = function(columns) {
	var data = new Object();
	var colList = [];
    
	$.each(columns, function(i, col){
    	var obj = new Object();
    	var colHeaderTitle;
    	obj.id = col.id;
    	if ($.isArray(col.header)) {
    		if (col.header.length > 0) {
    		    if (col.header[0].text) {
    			    colHeaderTitle = col.header[0].text;
    		    } else {
    		        colHeaderTitle = col.header[0];
    		    }
    		} else {
    			colHeaderTitle = null;
    		}
    	} else {
    		colHeaderTitle = col.header;
    	}
    	
    	if (colHeaderTitle && colHeaderTitle.indexOf('key-field') == -1) {
    		obj.value = removeTag(colHeaderTitle);
            if (col.hidden) {
        	    if (col.concealed) {
        	        obj.checked = false;
        	        colList.push(obj);
        	    } 
            } else {
        	    obj.checked = true;
        	    colList.push(obj);
            }
    	}
    });
    data.data=colList

    return data;
}

function removeTag(str) {
    return str.replace(/(<([^>]+)>)/gi, "");
}

function getDateTxt(formatTxt, dateTxt){
	var fmParse = webix.Date.strToDate(_WEBIX_DATE_DEFAULT);
	var dateObj = fmParse(dateTxt);
	var dtformat = webix.Date.dateToStr(formatTxt);
	var dateStr = dtformat(dateObj);
	return dateStr;
}

function getSysDateFormat(obj, dateTxt){
	
	var formatTxt = obj.config.format;
	var sysFormat = "";
	
	if(formatTxt == _WEBIX_DATE_YMDHMS){
		sysFormat = "%Y%m%d%H%i%s";
	}else if(formatTxt == _WEBIX_DATE_YMDHM){
		sysFormat = "%Y%m%d%H%i";
	}else if(formatTxt == _WEBIX_DATE_YMDH){
		sysFormat = "%Y%m%d%H";
	}else if(formatTxt == _WEBIX_DATE_YMD){
		sysFormat = "%Y%m%d";
	}else if(formatTxt == _WEBIX_DATE_YM){
		sysFormat = "%Y%m";
	}
	
	var fmParse = webix.Date.strToDate(formatTxt);
	var dateObj = fmParse(dateTxt);
	var dtformat = webix.Date.dateToStr(sysFormat);
	var dateStr = dtformat(dateObj);
	return dateStr;
	
}

mtos.loader = {
    start: function () {
	    $('body').oLoader({
            wholeWindow: true,
            lockOverflow: true,
            backgroundColor: '#000',
            image: context + '/img/loader1.gif',  
        });
    },
    stop: function () {
        $('body').oLoader('hide');
    }
};

