/*
@license
Webix Pivot v.5.2.3
This software is covered by Webix Commercial License.
Usage without proper license is prohibited.
(c) XB Software Ltd.
*/
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/codebase/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	var _core = __webpack_require__(34);
	
	var pivot;
	
	onmessage = function onmessage(e) {
		if (!pivot) {
			pivot = new _core.WebixPivot(e.data.structure);
		}
		if (e.type === "error") throw e;
	
		pivot.config.format = e.data.format;
		pivot.config.footer = e.data.footer;
		pivot.config.structure = e.data.structure;
		if (e.data.ping) {
			pivot.config.ping = function (watch) {
				postMessage({ type: "ping", watch: watch });
			};
		}
	
		pivot._pivotOperations.parse(e.data.operations);
	
		var result = pivot.getData(e.data.data);
	
		postMessage({ type: "data", data: result.data, id: e.data.id });
	};

/***/ }),

/***/ 34:
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	exports.WebixPivot = exports._Pivot = undefined;
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };
	
	var _data = __webpack_require__(35);
	
	var _operations = __webpack_require__(42);
	
	var _helpers = __webpack_require__(36);
	
	var hlp = _interopRequireWildcard(_helpers);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj["default"] = obj; return newObj; } }
	
	function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }
	
	function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }
	
	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
	
	var divider = "_'_";
	
	var _Pivot = exports._Pivot = function () {
		function _Pivot(config, master) {
			_classCallCheck(this, _Pivot);
	
			this.$divider = divider;
			this._initOperations();
			this.config = config;
			this.view = master;
	
			if (config.webWorker && !(typeof Worker === "undefined" ? "undefined" : _typeof(Worker)) !== "undefined" && master) {
				this._initWorker(config, master);
			} else this._pivotData = new _data.Data(this, this.config);
	
			if (!this.config.structure) this.config.structure = {};
			hlp.extend(this.config.structure, { rows: [], columns: [], values: [], filters: [] });
		}
	
		_Pivot.prototype._initWorker = function _initWorker(config, master) {
			this._result = null;
			this._pivotWorker = new Worker(config.webWorker);
			this._pivotWorker.onmessage = function (e) {
				if (e.data.type === "ping") {
					master._runPing(e.data.watch, master);
				} else if (master._result && !master.$destructed) {
					master.callEvent("onWebWorkerEnd", []);
					if (!e.data.id || e.data.id === master._result_id) {
						master._result(e.data.data);
						master._result = null;
					}
				}
			};
		};
	
		_Pivot.prototype._runPing = function _runPing(watch, master) {
			try {
				this.config.ping(watch);
			} catch (e) {
				this._pivotWorker.terminate();
				this._initWorker(this.config, master);
				master.callEvent("onWebWorkerEnd", []);
			}
		};
	
		_Pivot.prototype._getPivotData = function _getPivotData(pull, order, next) {
			if (this._pivotWorker) {
				var id = this._result_id = webix.uid();
				this._result = next;
	
				var data = [];
				var structure = this.config.structure;
				var footer = this.config.footer;
				var operations = this._pivotOperations.serialize();
				if (structure && (structure.rows.length || structure.columns.length)) for (var i = order.length - 1; i >= 0; i--) {
					data[i] = pull[order[i]];
				}this.callEvent("onWebWorkerStart", []);
	
				var format = this.config.format;
				if (typeof format === "function") {
					var t = "x" + webix.uid();
					webix.i18n[t] = format;
					format = t;
				}
	
				var ping = !!this.config.ping;
				this._pivotWorker.postMessage({
					footer: footer, structure: structure, data: data, id: id, operations: operations, ping: ping, format: format
				});
			} else {
				var result = this._pivotData.process(pull, order);
				if (next) next(result);
				return result;
			}
		};
	
		_Pivot.prototype._initOperations = function _initOperations() {
			var operations = this._pivotOperations = new _operations.Operations();
			this.operations = operations.pull;
		};
	
		_Pivot.prototype.addOperation = function addOperation(name, method, options) {
			this._pivotOperations.add(name, method, options);
		};
	
		_Pivot.prototype.addTotalOperation = function addTotalOperation(name, method, options) {
			this._pivotOperations.addTotal(name, method, options);
		};
	
		return _Pivot;
	}();
	
	var WebixPivot = exports.WebixPivot = function (_Pivot2) {
		_inherits(WebixPivot, _Pivot2);
	
		function WebixPivot() {
			_classCallCheck(this, WebixPivot);
	
			return _possibleConstructorReturn(this, _Pivot2.apply(this, arguments));
		}
	
		WebixPivot.prototype.getData = function getData(data) {
			var i,
			    id,
			    option,
			    field,
			    fields = [],
			    fieldsHash = {},
			    filters = this.config.structure.filters,
			    pull = {},
			    options = {},
			    optionsHash = {},
			    operations = this.operations,
			    order = [],
			    result = {};
	
			for (i = 0; i < filters.length; i++) {
				if (filters[i].type.indexOf("select") != -1) {
					options[filters[i].name] = [];
					optionsHash[filters[i].name] = {};
				}
			}
	
			for (i = 0; i < data.length; i++) {
				id = data[i].id = data[i].id || hlp.uid();
				pull[id] = data[i];
				order.push(id);
	
				if (i < 5) for (field in data[i]) {
					if (!fieldsHash[field]) {
						fields.push(field);
						fieldsHash[field] = hlp.uid();
					}
				}for (option in options) {
					var value = data[i][option];
					if (!hlp.isUndefined(value)) {
						if (!optionsHash[option][value]) {
							optionsHash[option][value] = 1;
							options[option].push(value);
						}
					}
				}
			}
	
			result.options = options;
			result.fields = fields;
			result.data = this._getPivotData(pull, order);
	
			result.operations = [];
			for (id in operations) {
				result.operations.push(id);
			}return result;
		};
	
		return WebixPivot;
	}(_Pivot);

/***/ }),

/***/ 35:
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	exports.Data = undefined;
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };
	
	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();
	
	var _helpers = __webpack_require__(36);
	
	var hlp = _interopRequireWildcard(_helpers);
	
	var _header = __webpack_require__(37);
	
	var _total_columns = __webpack_require__(38);
	
	var _footer = __webpack_require__(39);
	
	var _item_values = __webpack_require__(40);
	
	var itm = _interopRequireWildcard(_item_values);
	
	var _filters = __webpack_require__(41);
	
	var flt = _interopRequireWildcard(_filters);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj["default"] = obj; return newObj; } }
	
	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
	
	var Data = exports.Data = function () {
		function Data(master, config) {
			_classCallCheck(this, Data);
	
			this.master = master;
			this.config = config;
			this.count = 0;
		}
	
		Data.prototype.process = function process(data, order) {
			this.watch = new Date();
			var columns, fields, header, i, items;
	
			var structure = this.structure;
			structure._header = [];
			structure._header_hash = {};
	
			flt.formatFilterValues(structure.filters);
			flt.setFilterValues(structure.filters);
	
			for (i = 0; i < structure.values.length; i++) {
				structure.values[i].operation = structure.values[i].operation || ["sum"];
				if (!hlp.isArray(structure.values[i].operation)) structure.values[i].operation = [structure.values[i].operation];
			}
	
			columns = [];
			for (i = 0; i < structure.columns.length; i++) {
				columns[i] = _typeof(structure.columns[i]) == "object" ? structure.columns[i].id || i : structure.columns[i];
			}
	
			fields = structure.rows.concat(columns);
			items = this.group(data, order, fields);
	
			header = {};
			if (structure.rows.length > 0) items = this.processRows(items, structure.rows, structure, header, "");else {
				// there are no rows in structure, only columns and values
				this.processColumns(items, columns, structure, header);
				items = [];
			}
	
			header = (0, _header.processHeader)(this.master, header);
	
			items = (0, _total_columns.addTotalData)(this.master, items);
	
			if (this.config.footer) (0, _footer.addFooter)(this.master, header, items);
	
			delete structure._header;
			delete structure._header_hash;
	
			return { header: header, data: items };
		};
	
		Data.prototype.processColumns = function processColumns(data, columns, structure, header, item, name) {
			var vname;
	
			item = item || { $source: [] };
			if (columns.length > 0) {
				name = name || "";
				for (var i in data) {
					if (!header[i]) header[i] = {};
					data[i] = this.processColumns(data[i], columns.slice(1), structure, header[i], item, (name.length > 0 ? name + this.divider : "") + i);
				}
			} else {
				var values = structure.values;
				for (var id in data) {
					item.$source.push(id);
					for (var _i = 0; _i < values.length; _i++) {
						for (var j = 0; j < values[_i].operation.length; j++) {
							if (typeof name !== "undefined") vname = name + this.divider + values[_i].operation[j] + this.divider + values[_i].name;else // if no columns
								vname = values[_i].operation[j] + this.divider + values[_i].name;
							if (!structure._header_hash[vname]) {
								structure._header.push(vname);
								structure._header_hash[vname] = true;
							}
							if (hlp.isUndefined(item[vname])) {
								item[vname] = [];
								header[values[_i].operation[j] + this.divider + values[_i].name] = {};
							}
							item[vname].push({ value: data[id][values[_i].name], id: id });
						}
					}
				}
			}
			return item;
		};
	
		Data.prototype.processRows = function processRows(data, rows, structure, header, prefix) {
			var i,
			    item,
			    j,
			    k,
			    value,
			    items = [];
			if (rows.length > 1) {
				for (i in data) {
					data[i] = this.processRows(data[i], rows.slice(1), structure, header, prefix + "_" + i);
				}var values = structure._header;
	
				for (i in data) {
					item = { data: data[i] };
					for (j = 0; j < item.data.length; j++) {
						for (k = 0; k < values.length; k++) {
							value = values[k];
							if (hlp.isUndefined(item[value])) item[value] = [];
							item[value].push(item.data[j][value]);
						}
					}
					this.setItemValues(item);
					if (this.master.config.stableRowId) item.id = prefix + "_" + i;
	
					item.name = i;
					item.open = true;
					items.push(item);
				}
			} else {
				for (i in data) {
					item = this.processColumns(data[i], structure.columns, structure, header);
					item.name = i;
	
					if (this.master.config.stableRowId) item.id = prefix + "_" + i;
	
					this.setItemValues(item);
					items.push(item);
				}
			}
			return items;
		};
	
		Data.prototype.setItemValues = function setItemValues(item) {
			item = itm.calculateItem(item, {
				header: this.structure._header,
				divider: this.divider,
				operations: this.operations
			}, this);
			item = itm.setMinMax(item, {
				header: this.structure._header,
				max: this.config.max,
				min: this.config.min,
				values: this.structure.values
			});
	
			//watchdog
			if (this.count > 50000) {
				this.count = 0;
				if (this.config.ping) this.config.ping.call(this, this.watch);
			}
	
			return item;
		};
	
		Data.prototype.group = function group(data, order, fields) {
			var i,
			    id,
			    item,
			    hash = {};
	
			for (i = 0; i < order.length; i++) {
				id = order[i];
				item = data[id];
				if (item && flt.filterItem(this.structure.filters, item, this.config.filterMap)) {
					this.groupItem(hash, item, fields);
				}
			}
			return hash;
		};
	
		Data.prototype.groupItem = function groupItem(hash, item, fields) {
			if (fields.length) {
				var value = item[fields[0]];
				if (typeof value === "undefined") return null;
	
				if (hlp.isUndefined(hash[value])) hash[value] = {};
				this.groupItem(hash[value], item, fields.slice(1));
			} else hash[item.id] = item;
		};
	
		Data.prototype.filterItem = function filterItem(item) {
			var filters = this.structure.filters || [];
			for (var i = 0; i < filters.length; i++) {
				var f = filters[i];
				if (f.fvalue) {
					if (hlp.isUndefined(item[f.name])) return false;
	
					var value = item[f.name].toString().toLowerCase();
					var result = f.func(f.fvalue, value);
	
					if (!result) return false;
				}
			}
			return true;
		};
	
		_createClass(Data, [{
			key: "operations",
			get: function get() {
				return this.master._pivotOperations;
			}
		}, {
			key: "divider",
			get: function get() {
				return this.master.$divider;
			}
		}, {
			key: "structure",
			get: function get() {
				return this.config.structure;
			}
		}]);

		return Data;
	}();

/***/ }),

/***/ 36:
/***/ (function(module, exports) {

	"use strict";
	
	exports.__esModule = true;
	exports.isArray = isArray;
	exports.isUndefined = isUndefined;
	exports.extend = extend;
	exports.uid = uid;
	function isArray(obj) {
		return Array.isArray ? Array.isArray(obj) : Object.prototype.toString.call(obj) === "[object Array]";
	}
	
	function isUndefined(a) {
		return typeof a == "undefined";
	}
	
	function extend(base, source, force) {
		//copy methods, overwrite existing ones in case of conflict
		for (var method in source) {
			if (!base[method] || force) base[method] = source[method];
		}return base;
	}
	
	var seed;
	
	function uid() {
		if (!seed) seed = new Date().valueOf();
		seed++;
		return seed;
	}

/***/ }),

/***/ 37:
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	exports.processHeader = processHeader;
	
	var _helpers = __webpack_require__(36);
	
	var hlp = _interopRequireWildcard(_helpers);
	
	var _total_columns = __webpack_require__(38);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj["default"] = obj; return newObj; } }
	
	// default sorting properties
	var sortConfig = {
		dir: 1,
		as: function as(a, b) {
			if (isNum(a) && isNum(b)) return sorting.int(a, b);
			return sorting.string(a, b);
		}
	};
	
	var sorting = {
		"date": function date(a, b) {
			a = a - 0;b = b - 0;
			return a > b ? 1 : a < b ? -1 : 0;
		},
		"int": function int(a, b) {
			a = a * 1;b = b * 1;
			return a > b ? 1 : a < b ? -1 : 0;
		},
		"string": function string(a, b) {
			if (!b) return 1;
			if (!a) return -1;
			a = a.toString().toLowerCase();b = b.toString().toLowerCase();
			return a > b ? 1 : a < b ? -1 : 0;
		}
	};
	
	function processHeader(master, header) {
		var i,
		    j,
		    p,
		    text0,
		    vConfig,
		    valuesConfig = master.config.structure.values;
	
		header = sortHeader(master.config.structure, header);
	
		header = getHeader(master, header);
	
		for (i = 0; i < header.length; i++) {
			var parts = [];
			for (j = 0; j < header[i].length; j++) {
				parts.push(header[i][j].name);
			} // find value configuration
			vConfig = null;
			var tmp = parts[parts.length - 1].split(master.$divider);
			for (j = 0; j < valuesConfig.length && !vConfig; j++) {
				if (valuesConfig[j].operation) for (p = 0; p < valuesConfig[j].operation.length; p++) {
					if (valuesConfig[j].name == tmp[1] && valuesConfig[j].operation[p] == tmp[0]) {
						vConfig = valuesConfig[j];
					}
				}
			}
	
			header[i] = { id: parts.join(master.$divider), header: header[i] };
			header[i].format = vConfig && vConfig.format ? vConfig.format : tmp[0] != "count" ? master.config.format : null;
		}
	
		if (header.length && master.view && master.view.callEvent) master.view.callEvent("onHeaderInit", [header]);
	
		if (master.config.totalColumn && header.length) header = (0, _total_columns.addTotalColumns)(master, header);
	
		header.splice(0, 0, { id: "name", template: "{common.treetable()} #name#", header: { text: text0 } });
	
		return header;
	}
	
	function isNum(value) {
		return !isNaN(value * 1);
	}
	
	/*
	* get sort properties for a column
	* */
	function setSortConfig(config, column) {
		var sorting = sortConfig;
		if (config) {
			// for a specific columns
			if (config[column]) sorting = config[column];
			// for any other column
			else if (config.$default) sorting = config.$default;
	
			if (sorting.dir) sorting._dir = sorting.dir == "desc" ? -1 : 1;
			hlp.extend(sorting, sortConfig);
		}
		return sorting;
	}
	
	function sortHeader(config, header, cIndex) {
		var column,
		    i,
		    key,
		    keys,
		    sorting,
		    sorted = [];
	
		if (Object.keys && config.columnSort !== false) {
			cIndex = cIndex || 0;
	
			column = config.columns[cIndex];
			sorting = setSortConfig(config.columnSort, column);
			keys = Object.keys(header);
			if (cIndex < config.columns.length) keys = keys.sort(function (a, b) {
				return sorting.as(a, b) * sorting._dir;
			});
			cIndex++;
	
			for (i = 0; i < keys.length; i++) {
				key = keys[i];
				sorted.push({
					key: key,
					data: sortHeader(config, header[key], cIndex)
				});
			}
		} else {
			for (key in header) {
				sorted.push({
					key: key,
					data: sortHeader(config, header[key])
				});
			}
		}
	
		return sorted;
	}
	
	function getHeader(view, data) {
	
		var first,
		    i,
		    item,
		    j,
		    h,
		    header = [];
	
		for (i = 0; i < data.length; i++) {
			item = data[i];
	
			if (item.data.length) {
				var result = getHeader(view, item.data);
				first = false;
				for (j = 0; j < result.length; j++) {
					h = result[j];
					h.splice(0, 0, { name: item.key });
					if (!first) {
						h[0].colspan = result.length;
						first = true;
					}
					header.push(h);
				}
			} else {
				var keys = data[i].key.split(view.$divider);
				header.push([{ name: data[i].key, operation: keys[0], text: keys[1] }]);
			}
		}
		return header;
	}

/***/ }),

/***/ 38:
/***/ (function(module, exports) {

	"use strict";
	
	exports.__esModule = true;
	exports.addTotalColumns = addTotalColumns;
	exports.addTotalData = addTotalData;
	function getTotalColumnId(master, name) {
		return "$webixtotal" + master.$divider + name;
	}
	
	function getValues(item, ids) {
		var i,
		    value,
		    values = [];
		for (i = 0; i < ids.length; i++) {
			value = item[ids[i]];
			if (!isNaN(parseFloat(value))) values.push(value);
		}
		return values;
	}
	
	function addTotalColumns(master, header) {
		var groups,
		    groupData,
		    groupName,
		    h,
		    i,
		    hRowCount,
		    parts,
		    totalCols = [];
	
		hRowCount = header[0].header.length;
		// if no selected columns
		if (hRowCount < 2) return header;
	
		groupData = getTotalGroups(master, header);
		groups = groupData.groups;
		master._pivotColumnGroups = groups;
		for (groupName in groups) {
			// column config
			h = {
				id: getTotalColumnId(master, groupName),
				header: [],
				sort: "int",
				width: master.config.columnWidth,
				format: master.config.format
			};
	
			// set top headers
			for (i = 0; i < hRowCount - 1; i++) {
				if (!i && !totalCols.length) {
					h.header.push({
						name: "total",
						rowspan: hRowCount - 1,
						colspan: groupData.count
					});
				} else h.header.push("");
			}
	
			// set bottom header
			parts = groupName.split(master.$divider);
			h.header.push({
				name: groupName,
				operation: parts[0],
				text: parts[1]
			});
	
			totalCols.push(h);
		}
	
		return header.concat(totalCols);
	}
	
	function getTotalGroups(master, header) {
		var groupName,
		    i,
		    name,
		    operation,
		    parts,
		    groups = {},
		    groupCount = 0;
	
		for (i = 0; i < header.length; i++) {
			parts = header[i].id.split(master.$divider);
			name = parts.pop();
			operation = parts.pop();
			if (operation == "sum" || master.config.totalColumn != "sumOnly") {
				groupName = operation + master.$divider + name;
				if (!groups[groupName]) {
					groupCount++;
					groups[groupName] = {
						operation: operation,
						ids: [],
						format: header.format
					};
				}
				groups[groupName].ids.push(header[i].id);
			}
		}
		return { groups: groups, count: groupCount };
	}
	
	function addTotalData(master, items) {
		var groups = master._pivotColumnGroups;
		if (groups) {
			var group = void 0,
			    i = void 0,
			    ids = void 0,
			    name = void 0;
			for (name in groups) {
				group = groups[name];
				ids = group.ids;
	
				for (i = 0; i < items.length; i++) {
					var operation = void 0,
					    columnId = getTotalColumnId(master, name),
					    result = "",
					    values = getValues(items[i], ids);
					if (values.length) {
						if (operation = master._pivotOperations.getTotal(name.split(master.$divider)[0])) result = operation.call(master, values, columnId, items[i]);
					}
	
					items[i][columnId] = result;
					if (items[i].data) items[i].data = addTotalData(master, items[i].data);
				}
			}
		}
		return items;
	}

/***/ }),

/***/ 39:
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };
	
	exports.addFooter = addFooter;
	
	var _helpers = __webpack_require__(36);
	
	var hlp = _interopRequireWildcard(_helpers);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj["default"] = obj; return newObj; } }
	
	function addFooter(master, columns, items) {
		var config, i, names, operation;
	
		for (i = 1; i < columns.length; i++) {
			config = null;
			names = columns[i].id.split(master.$divider);
			operation = names[names.length - 2];
			if (master.config.footer == "sumOnly") {
				if (operation != "sum") config = " ";
			}
			var totalMethod = master._pivotOperations.getTotal(operation);
			if (!config && totalMethod) {
				var options = master._pivotOperations.getTotalOptions(operation);
				var result = calculateColumn(items, columns[i].id, totalMethod, options && options.leavesOnly);
				config = {
					$pivotValue: result,
					$pivotOperation: operation
				};
			} else config = " ";
			columns[i].footer = config;
	
			if (_typeof(master.config.footer) == "object") {
				hlp.extend(columns[i].footer, master.config.footer, true);
			}
		}
	}
	
	function calculateColumn(items, columnId, totalMethod, leaves) {
		var i,
		    fItems = [],
		    value,
		    values = [];
		// filter items
		items = filterItems(items, leaves);
		// get column values
		for (i = 0; i < items.length; i++) {
			value = items[i][columnId];
			if (!isNaN(parseFloat(value))) {
				values.push(value * 1);
				fItems.push(items[i]);
			}
		}
		return totalMethod(values, columnId, fItems);
	}
	
	function filterItems(items, leaves, selectedItems) {
		if (!selectedItems) selectedItems = [];
		for (var i = 0; i < items.length; i++) {
			if (leaves && items[i].data) filterItems(items[i].data, leaves, selectedItems);else selectedItems.push(items[i]);
		}
		return selectedItems;
	}

/***/ }),

/***/ 40:
/***/ (function(module, exports) {

	"use strict";
	
	exports.__esModule = true;
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };
	
	exports.calculateItem = calculateItem;
	exports.setMinMax = setMinMax;
	function calculateItem(item, config, master) {
		var i,
		    isIds,
		    key,
		    leaves,
		    operation,
		    tmp,
		    values,
		    header = config.header;
	
		for (i = 0; i < header.length; i++) {
			key = header[i];
			tmp = key.split(config.divider);
			operation = tmp[tmp.length - 2];
	
			values = item[key];
	
			leaves = config.operations.getOption(operation, "leavesOnly");
			isIds = config.operations.getOption(operation, "ids");
			if (leaves && item.data) {
				values = [];
				getKeyLeaves(item.data, key, values);
			}
			if (values) {
				var data = [];
				var ids = [];
				for (var j = 0; j < values.length; j++) {
					var value = values[j];
					var id = null;
					if ((typeof value === "undefined" ? "undefined" : _typeof(value)) == "object") {
						value = value.value;
						id = values[j].id;
					}
					if (value || value == "0") {
						data.push(value);
						if (id) ids.push(id);
					}
				}
				if (data.length) item[key] = config.operations.get(operation)(data, key, item, isIds ? ids : null);else item[key] = "";
			} else item[key] = "";
	
			//watchdog
			master.count++;
		}
		return item;
	}
	
	function getKeyLeaves(data, key, result) {
		var i;
	
		for (i = 0; i < data.length; i++) {
			if (data[i].data) getKeyLeaves(data[i].data, key, result);else result.push(data[i][key]);
		}
	}
	
	function setMinMax(item, config) {
		var i,
		    j,
		    key,
		    maxArr,
		    maxValue,
		    minArr,
		    minValue,
		    value,
		    header = config.header,
		    max = config.max,
		    min = config.min,
		    values = config.values;
	
		// nothing to do
		if (!min && !max) return item;
	
		//values = structure.values;
		if (!item.$cellCss) item.$cellCss = {};
	
		// calculating for each value
		for (i = 0; i < values.length; i++) {
			value = values[i];
			maxArr = [];
			maxValue = -99999999;
			minArr = [];
			minValue = 99999999;
	
			for (j = 0; j < header.length; j++) {
				key = header[j];
				if (isNaN(item[key])) continue;
				// it's a another value
				if (key.indexOf(value.name) === -1) continue;
	
				if (max && item[key] > maxValue) {
					maxArr = [key];
					maxValue = item[key];
				} else if (item[key] == maxValue) {
					maxArr.push(key);
				}
				if (min && item[key] < minValue) {
					minArr = [key];
					minValue = item[key];
				} else if (item[key] == minValue) {
					minArr.push(key);
				}
			}
	
			for (j = 0; j < minArr.length; j++) {
				item.$cellCss[minArr[j]] = "webix_min";
			}
			for (j = 0; j < maxArr.length; j++) {
				item.$cellCss[maxArr[j]] = "webix_max";
			}
		}
		return item;
	}

/***/ }),

/***/ 41:
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	exports.rules = undefined;
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };
	
	exports.setFilterValues = setFilterValues;
	exports.formatFilterValues = formatFilterValues;
	exports.filterItem = filterItem;
	
	var _helpers = __webpack_require__(36);
	
	var hlp = _interopRequireWildcard(_helpers);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj["default"] = obj; return newObj; } }
	
	function numHelper(fvalue, value, func) {
		if ((typeof fvalue === "undefined" ? "undefined" : _typeof(fvalue)) == "object") {
			for (var i = 0; i < fvalue.length; i++) {
				fvalue[i] = parseFloat(fvalue[i]);
				if (isNaN(fvalue[i])) return true;
			}
		} else {
			fvalue = parseFloat(fvalue);
			// if filter value is not a number then ignore such filter
			if (isNaN(fvalue)) return true;
		}
		// if row value is not a number then don't show this row
		if (isNaN(value)) return false;
		return func(fvalue, value);
	}
	
	var rules = exports.rules = {
		contains: function contains(fvalue, value) {
			return value.toLowerCase().indexOf(fvalue.toString().toLowerCase()) >= 0;
		},
		equal: function equal(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return fvalue == value;
			});
		},
		not_equal: function not_equal(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return fvalue != value;
			});
		},
		less: function less(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return value < fvalue;
			});
		},
		less_equal: function less_equal(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return value <= fvalue;
			});
		},
		more: function more(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return value > fvalue;
			});
		},
		more_equal: function more_equal(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return value >= fvalue;
			});
		},
		multi: function multi(fvalues, value) {
			if (typeof fvalues === "string") fvalues = fvalues.split(",");
	
			for (var i = 0; i < fvalues.length; i++) {
				if (value == fvalues[i]) return true;
			}
			return false;
		},
		range: function range(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return value < fvalue[1] && value >= fvalue[0];
			});
		},
		range_inc: function range_inc(fvalue, value) {
			return numHelper(fvalue, value, function (fvalue, value) {
				return value <= fvalue[1] && value >= fvalue[0];
			});
		}
	};
	
	function setFilterValues(filters) {
		filters = filters || [];
	
		for (var i = 0; i < filters.length; i++) {
			var f = filters[i],
			    fvalue = f.fvalue;
			if (typeof fvalue == "function") {
				f.func = fvalue;
			} else if (f.type == "select" || f.type == "richselect") {
				f.func = function (fvalue, value) {
					return fvalue == value;
				};
				fvalue = fvalue || "";
			} else if (f.type.indexOf("multi") > -1) {
				f.func = rules.multi;
			} else if ((typeof fvalue === "undefined" ? "undefined" : _typeof(fvalue)) === "object") {
				f.func = rules.range;
			} else if (fvalue.substr(0, 1) == "=") {
				f.func = rules.equal;
				fvalue = fvalue.substr(1);
			} else if (fvalue.substr(0, 2) == "<>") {
				f.func = rules.not_equal;
				fvalue = fvalue.substr(2);
			} else if (fvalue.substr(0, 2) == ">=") {
				f.func = rules.more_equal;
				fvalue = fvalue.substr(2);
			} else if (fvalue.substr(0, 1) == ">") {
				f.func = rules.more;
				fvalue = fvalue.substr(1);
			} else if (fvalue.substr(0, 2) == "<=") {
				f.func = rules.less_equal;
				fvalue = fvalue.substr(2);
			} else if (fvalue.substr(0, 1) == "<") {
				f.func = rules.less;
				fvalue = fvalue.substr(1);
			} else if (fvalue.indexOf("...") > 0) {
				f.func = rules.range;
				fvalue = fvalue.split("...");
			} else if (fvalue.indexOf("..") > 0) {
				f.func = rules.range_inc;
				fvalue = fvalue.split("..");
			} else if (f.type == "datepicker") {
				f.func = function (fvalue, value) {
					return fvalue == value;
				};
			} else f.func = rules.contains;
	
			f.fvalue = fvalue;
		}
	}
	
	function formatFilterValues(filters) {
		var i, fvalue;
		filters = filters || [];
		for (i = 0; i < filters.length; i++) {
			fvalue = filters[i].fvalue || filters[i].value || "";
			if (typeof fvalue == "string") {
				if (fvalue.trim) fvalue = fvalue.trim();
			}
			filters[i].fvalue = fvalue;
		}
	}
	
	function filterItem(filters, item, map) {
		if (filters) {
			var i = void 0,
			    f = void 0;
			for (i = 0; i < filters.length; i++) {
				f = filters[i];
				if (f.fvalue) {
					var field = map && map[f.name] ? map[f.name] : f.name;
					if (hlp.isUndefined(item[field])) return false;
	
					var raw = item[field];
					if (!raw !== 0 && !raw) return false;
	
					var value = raw.toString();
					var result = f.func(f.fvalue, value);
	
					if (!result) return false;
				}
			}
		}
		return true;
	}

/***/ }),

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

	"use strict";
	
	exports.__esModule = true;
	exports.Operations = undefined;
	
	var _helpers = __webpack_require__(36);
	
	var hlp = _interopRequireWildcard(_helpers);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj["default"] = obj; return newObj; } }
	
	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
	
	var operations = {
		sum: function sum(values) {
			var sum = 0;
			for (var i = 0; i < values.length; i++) {
				var value = values[i];
				value = parseFloat(value, 10);
				if (!isNaN(value)) sum += value;
			}
			return sum;
		},
		count: function count(data, key, item) {
			var count = 0;
			if (!item.data) count = data.length;else {
				for (var i = 0; i < item.data.length; i++) {
					count += item.data[i][key] || 0;
				}
			}
			return count;
		},
		max: function max(args) {
			if (args.length == 1) return args[0];
			return Math.max.apply(this, args);
		},
		min: function min(args) {
			if (args.length == 1) return args[0];
			return Math.min.apply(this, args);
		}
	};
	
	var totalOperations = {
		"sum": function sum(values) {
			var i,
			    sum = 0;
			for (i = 0; i < values.length; i++) {
				sum += values[i];
			}return sum;
		},
		"min": function min(values) {
			if (values.length == 1) return values[0];
			return Math.min.apply(null, values);
		},
		"max": function max(values) {
			if (values.length == 1) return values[0];
			return Math.max.apply(null, values);
		},
		"count": function count(values) {
			var value = totalOperations.sum.call(this, values);
			return value ? parseInt(value, 10) : "";
		}
	};
	
	var Operations = exports.Operations = function () {
		function Operations() {
			_classCallCheck(this, Operations);
	
			this.pull = hlp.extend({}, operations);
			this.options = {};
			this.pullTotal = hlp.extend({}, totalOperations);
			this.totalOptions = {};
		}
	
		Operations.prototype.serialize = function serialize() {
			var str = {};
			for (var key in this.pull) {
				str[key] = this.pull[key].toString();
			}return str;
		};
	
		Operations.prototype.parse = function parse(str) {
			for (var key in str) {
				eval("this.temp = " + str[key]);
				this.pull[key] = this.temp;
			}
		};
	
		Operations.prototype.add = function add(name, method, options) {
			this.pull[name] = method;
			if (options) this.options[name] = options;
		};
	
		Operations.prototype.addTotal = function addTotal(name, method, options) {
			this.pullTotal[name] = method;
			if (options) this.totalOptions[name] = options;
		};
	
		Operations.prototype.get = function get(name) {
			return this.pull[name] || null;
		};
	
		Operations.prototype.getOptions = function getOptions(name) {
			return this.options[name] || null;
		};
	
		Operations.prototype.getOption = function getOption(name, option) {
			return this.options[name] ? this.options[name][option] : null;
		};
	
		Operations.prototype.getTotal = function getTotal(name) {
			return this.pullTotal[name] || this.pull[name] || null;
		};
	
		Operations.prototype.getTotalOptions = function getTotalOptions(name) {
			return this.pullTotal[name] ? this.totalOptions[name] || null : this.options[name] || null;
		};
	
		Operations.prototype.getTotalOption = function getTotalOption(name, option) {
			var options = this.getTotalOptions(name);
			return options ? options[name][option] : null;
		};
	
		return Operations;
	}();

/***/ })

/******/ });