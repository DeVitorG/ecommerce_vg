(function($){
	var isIphone = (window.orientation!=undefined);
	$.extend({
		mask : {
			rules : {
				'z': /[a-z]/,
				'Z': /[A-Z]/,
				'a': /[a-zA-Z]/,
				'n': /[0-9a-z]/,
				'*': /[0-9a-zA-Z]/,
				'@': /[0-9a-zA-ZçÇáàãéèíìóòõúùü]/
			},
			keyRepresentation : {
				8	: 'backspace',
				9	: 'tab',
				13	: 'enter',
				16	: 'shift',
				17	: 'control',
				18	: 'alt',
				27	: 'esc',
				33	: 'page up',
				34	: 'page down',
				35	: 'end',
				36	: 'home',
				37	: 'left',
				38	: 'up',
				39	: 'right',
				40	: 'down',
				45	: 'insert',
				46	: 'delete',
				116	: 'f5',
				224	: 'command'
			},
			iphoneKeyRepresentation : {
				8	: 'backspace',
				10	: 'go',
				127	: 'delete'
			},
			signals : {
				'+' : '',
				'-' : '-'
			},
			options : {
				attr: 'alt', 
				mask: null, 
				type: 'fixed', 
				maxLength: -1, 
				defaultValue: '', 
				signal: false, 
				textAlign: true,
				selectCharsOnFocus: false,
				autoTab: true,
				fixedChars : '[(),.:/ -]',
				onInvalid : function(){},
				onValid : function(){},
				onOverflow : function(){}
			},
			masks : {
				'dias'				: { mask : '999' },
				'ano'				: { mask : '9999' },
				'usuario'			: { mask : '*************************************************************************************' }, 
				'placa'				: { mask : 'aaa-9*99' }, 
				'num'				: { mask : '99999999999999999' },
				'num_doc'			: { mask : '9999999' },
				'ean'				: { mask : '999999999999999' },
				'phone'				: { mask : '(99) 9999-99999' },
				'cel'				: { mask : '(99) 99999-9999' },
				'cpf'				: { mask : '999.999.999-99' },
				'cnpj'				: { mask : '99.999.999/9999-99' },
				'cpfcnpj'			: { mask : '999.999.999-999999' },
				'date'				: { mask : '39/19/9999' },
				'duracao'			: { mask : '99:99:99' },
				'horario'			: { mask : '29:59', defaultValue : '0000', autoTab: false },
				'cep'				: { mask : '99999-999' },
				'parcela'			: { mask : '999/999' },
				'cc'				: { mask : '9999 9999 9999 9999' },
				'integer'			: { mask : '999.999.999.999' },
				'peso'				: { mask : '999,999999999999', type : 'reverse', defaultValue : '0000' },
				'porc'				: { mask : '99,991', type : 'reverse', defaultValue : '000' },
				'preco'				: { mask : '999.99', type : 'reverse' },
				'decimal'			: { mask : '99,999.9', type : 'reverse' },
				'decimal-us'		: { mask : '99.999,999,999,999', type : 'reverse', defaultValue : '000' },
				'signed-decimal'	: { mask : '99,999.999.999.999', type : 'reverse', defaultValue : '000' },
				'decimal-nfe'		: { mask : '9999,999.999.999.999', type : 'reverse', defaultValue : '00000' },
				'signed-decimal-us'	: { mask : '99,999.999.999.999', type : 'reverse', defaultValue : '+000' },
				'quant'				: { mask : '999999999', type : 'reverse', defaultValue : '+0' }
			},
			init : function(){
				if( !this.hasInit ){
					var self = this, i,
						keyRep = (isIphone)? this.iphoneKeyRepresentation: this.keyRepresentation;
					this.ignore = false;
					for(i=0; i<=9; i++) this.rules[i] = new RegExp('[0-'+i+']');
					this.keyRep = keyRep;
					this.ignoreKeys = [];
					$.each(keyRep,function(key){
						self.ignoreKeys.push( parseInt(key) );
					});
					this.hasInit = true;
				}
			},
			set: function(el,options){
				var maskObj = this,
					$el = $(el),
					mlStr = 'maxLength';
				options = options || {};
				this.init();
				return $el.each(function(){
					if(options.attr) maskObj.options.attr = options.attr;
					var $this = $(this),
						o = $.extend({}, maskObj.options),
						attrValue = $this.attr(o.attr),
						tmpMask = '',
						pasteEvent = maskObj.__getPasteEvent();
					tmpMask = (typeof options == 'string')? options: (attrValue != '')? attrValue: null;
					if(tmpMask) o.mask = tmpMask;
					if(maskObj.masks[tmpMask]) o = $.extend(o, maskObj.masks[tmpMask]);
					if(typeof options == 'object' && options.constructor != Array) o = $.extend(o, options);
					if($.metadata) o = $.extend(o, $this.metadata());
					if(o.mask != null){
						if($this.data('mask')) maskObj.unset($this);
						var defaultValue = o.defaultValue,
							reverse = (o.type=='reverse'),
							fixedCharsRegG = new RegExp(o.fixedChars, 'g');
						if(o.maxLength == -1) o.maxLength = $this.attr(mlStr);
						o = $.extend({}, o,{
							fixedCharsReg: new RegExp(o.fixedChars),
							fixedCharsRegG: fixedCharsRegG,
							maskArray: o.mask.split(''),
							maskNonFixedCharsArray: o.mask.replace(fixedCharsRegG, '').split('')
						});
						if(reverse && o.textAlign) $this.css('text-align', 'left');
						if($this.val()!='') $this.val( maskObj.string($this.val(), o) );
						else if(defaultValue!='') $this.val( maskObj.string(defaultValue, o) );
						if(o.type=='infinite') o.type = 'repeat';
						$this.data('mask', o);
						$this.removeAttr(mlStr);
						$this.bind('keydown', {func:maskObj._keyDown, thisObj:maskObj}, maskObj._onMask)
							.bind('keypress', {func:maskObj._keyPress, thisObj:maskObj}, maskObj._onMask)
							.bind('keyup', {func:maskObj._keyUp, thisObj:maskObj}, maskObj._onMask)
							.bind('focus', maskObj._onFocus)
							.bind('blur', maskObj._onBlur)
							.bind('change', maskObj._onChange)
							.bind(pasteEvent, {func:maskObj._paste, thisObj:maskObj}, maskObj._delayedOnMask);
					}
				});
			},
			unset : function(el){
				var $el = $(el),
					_this = this;
				return $el.each(function(){
					var $this = $(this);
					if( $this.data('mask') ){
						var maxLength = $this.data('mask').maxLength,
							pasteEvent = _this.__getPasteEvent();
						if(maxLength != -1) $this.attr('maxLength', maxLength);
						$this.unbind('keydown', _this._onMask)
							.unbind('keypress', _this._onMask)
							.unbind('keyup', _this._onMask)
							.unbind('focus', _this._onFocus)
							.unbind('blur', _this._onBlur)
							.unbind('change', _this._onChange)
							.unbind(pasteEvent, _this._delayedOnMask)
							.removeData('mask');
					}
				});
			},
			string : function(str, options){
				this.init();
				var o={};
				if(typeof str != 'string') str = String(str);
				switch(typeof options){
					case 'string':
						if(this.masks[options]) o = $.extend(o, this.masks[options]);
						else o.mask = options;
						break;
					case 'object':
						o = options;
				}
				if(!o.fixedChars) o.fixedChars = this.options.fixedChars;
				var fixedCharsReg = new RegExp(o.fixedChars),
					fixedCharsRegG = new RegExp(o.fixedChars, 'g');
				if( (o.type=='reverse') && o.defaultValue ){
					if( typeof this.signals[o.defaultValue.charAt(0)] != 'undefined' ){
						var maybeASignal = str.charAt(0);
						o.signal = (typeof this.signals[maybeASignal] != 'undefined') ? this.signals[maybeASignal] : this.signals[o.defaultValue.charAt(0)];
						o.defaultValue = o.defaultValue.substring(1);
					}
				}
				return this.__maskArray(str.split(''),
							o.mask.replace(fixedCharsRegG, '').split(''),
							o.mask.split(''),
							o.type,
							o.maxLength,
							o.defaultValue,
							fixedCharsReg,
							o.signal);
			},
			_onFocus: function(e){
				var $this = $(this), dataObj = $this.data('mask');
				dataObj.inputFocusValue = $this.val();
				dataObj.changed = false;
				if(dataObj.selectCharsOnFocus) $this.select();
			},
			_onBlur: function(e){
				var $this = $(this), dataObj = $this.data('mask');
				if(dataObj.inputFocusValue != $this.val() && dataObj.type=='reverse' && !dataObj.changed)
					$this.trigger('change');
			},
			_onChange: function(e){
				$(this).data('mask').changed = true;
			},
			_onMask : function(e){
				var thisObj = e.data.thisObj,
					o = {};
				o._this = e.target;
				o.$this = $(o._this);
				if(o.$this.attr('readonly')) return true;
				o.data = o.$this.data('mask');
				o[o.data.type] = true;
				o.value = o.$this.val();
				o.nKey = thisObj.__getKeyNumber(e);
				o.range = thisObj.__getRange(o._this);
				o.valueArray = o.value.split('');
				return e.data.func.call(thisObj, e, o);
			},
			_delayedOnMask : function(e){
				e.type='paste';
				setTimeout(function(){ e.data.thisObj._onMask(e); }, 1);
			},
			_keyDown : function(e,o){
				this.ignore = $.inArray(o.nKey, this.ignoreKeys) > -1 || e.ctrlKey || e.metaKey || e.altKey;
				if(this.ignore){
					var rep = this.keyRep[o.nKey];
					o.data.onValid.call(o._this, rep? rep: '', o.nKey);
				}
				return isIphone ? this._keyPress(e, o) : true;
			},
			_keyUp : function(e, o){
				if(o.nKey==9 || o.nKey==16) return true;
				
				if(o.data.type=='repeat'){
					this.__autoTab(o);
					return true;
				}

				return this._paste(e, o);
			},
			_paste : function(e,o){
				if(o.reverse) this.__changeSignal(e.type, o);
				
				var $thisVal = this.__maskArray(
					o.valueArray,
					o.data.maskNonFixedCharsArray,
					o.data.maskArray,
					o.data.type,
					o.data.maxLength,
					o.data.defaultValue,
					o.data.fixedCharsReg,
					o.data.signal
				);
				o.$this.val( $thisVal );
				if( !o.reverse && o.data.defaultValue.length && (o.range.start==o.range.end) )
					this.__setRange(o._this, o.range.start, o.range.end);
				if( ($.browser.msie || $.browser.safari) && !o.reverse) this.__setRange(o._this,o.range.start,o.range.end);
				if(this.ignore) return true;
				this.__autoTab(o);
				return true;
			},
			_keyPress: function(e, o){
				if(this.ignore) return true;
				if(o.reverse) this.__changeSignal(e.type, o);
				var c = String.fromCharCode(o.nKey),
					rangeStart = o.range.start,
					rawValue = o.value,
					maskArray = o.data.maskArray;
				if(o.reverse){
					var valueStart = rawValue.substr(0, rangeStart),
						valueEnd = rawValue.substr(o.range.end, rawValue.length);
					rawValue = valueStart+c+valueEnd;
					if(o.data.signal && (rangeStart-o.data.signal.length > 0)) rangeStart-=o.data.signal.length;
				}
				var valueArray = rawValue.replace(o.data.fixedCharsRegG, '').split(''),
					extraPos = this.__extraPositionsTill(rangeStart, maskArray, o.data.fixedCharsReg);
				o.rsEp = rangeStart+extraPos;
				if(o.repeat) o.rsEp = 0;
				if( !this.rules[maskArray[o.rsEp]] || (o.data.maxLength != -1 && valueArray.length >= o.data.maxLength && o.repeat)){
					o.data.onOverflow.call(o._this, c, o.nKey);
					return false;
				}
				else if( !this.rules[maskArray[o.rsEp]].test( c ) ){
					o.data.onInvalid.call(o._this, c, o.nKey);
					return false;
				}
				else o.data.onValid.call(o._this, c, o.nKey);
				var $thisVal = this.__maskArray(
					valueArray,
					o.data.maskNonFixedCharsArray,
					maskArray,
					o.data.type,
					o.data.maxLength,
					o.data.defaultValue,
					o.data.fixedCharsReg,
					o.data.signal,
					extraPos
				);
				o.$this.val( $thisVal );
				return (o.reverse)? this._keyPressReverse(e, o): (o.fixed)? this._keyPressFixed(e, o): true;
			},
			_keyPressFixed: function(e, o){
				if(o.range.start==o.range.end){
					if((o.rsEp==0 && o.value.length==0) || o.rsEp < o.value.length)
						this.__setRange(o._this, o.rsEp, o.rsEp+1);	
				}
				else
					this.__setRange(o._this, o.range.start, o.range.end);
				return true;
			},
			_keyPressReverse: function(e, o){
				if($.browser.msie && ((o.rangeStart==0 && o.range.end==0) || o.rangeStart != o.range.end ))
					this.__setRange(o._this, o.value.length);
				return false;
			},
			__autoTab: function(o){
				if(o.data.autoTab
					&& (
						(
							o.$this.val().length >= o.data.maskArray.length 
							&& !o.repeat 
						) || (
							o.data.maxLength != -1
							&& o.valueArray.length >= o.data.maxLength
							&& o.repeat
						)
					)
				){
					var nextEl = this.__getNextInput(o._this, o.data.autoTab);
					if(nextEl){
						o.$this.trigger('blur');
						nextEl.focus().select();
					}
				}
			},
			__changeSignal : function(eventType,o){
				if(o.data.signal!==false){
					var inputChar = (eventType=='paste')? o.value.charAt(0): String.fromCharCode(o.nKey);
					if( this.signals && (typeof this.signals[inputChar] != 'undefined') ){
						o.data.signal = this.signals[inputChar];
					}
				}
			},
			__getPasteEvent : function(){
				return ($.browser.opera || ($.browser.mozilla && parseFloat($.browser.version.substr(0,3)) < 1.9 ))?'input':'paste';
			},
			__getKeyNumber : function(e){
				return (e.charCode||e.keyCode||e.which);
			},
			__maskArray : function(valueArray, maskNonFixedCharsArray, maskArray, type, maxlength, defaultValue, fixedCharsReg, signal, extraPos){
				if(type == 'reverse') valueArray.reverse();
				valueArray = this.__removeInvalidChars(valueArray, maskNonFixedCharsArray, type=='repeat'||type=='infinite');
				if(defaultValue) valueArray = this.__applyDefaultValue.call(valueArray, defaultValue);
				valueArray = this.__applyMask(valueArray, maskArray, extraPos, fixedCharsReg);
				switch(type){
					case 'reverse':
						valueArray.reverse();
						return (signal || '')+valueArray.join('').substring(valueArray.length-maskArray.length);
					case 'infinite': case 'repeat':
						var joinedValue = valueArray.join('');
						return (maxlength != -1 && valueArray.length >= maxlength)? joinedValue.substring(0, maxlength): joinedValue;
					default:
						return valueArray.join('').substring(0, maskArray.length);
				}
				return '';
			},
			__applyDefaultValue : function(defaultValue){
				var defLen = defaultValue.length,thisLen = this.length,i;
				for(i=thisLen-1;i>=0;i--){
					if(this[i]==defaultValue.charAt(0)) this.pop();
					else break;
				}
				for(i=0;i<defLen;i++) if(!this[i])
					this[i] = defaultValue.charAt(i);
				return this;
			},
			__removeInvalidChars : function(valueArray, maskNonFixedCharsArray, repeatType){
				for(var i=0, y=0; i<valueArray.length; i++ ){
					if( maskNonFixedCharsArray[y] &&
						this.rules[maskNonFixedCharsArray[y]] &&
						!this.rules[maskNonFixedCharsArray[y]].test(valueArray[i]) ){
							valueArray.splice(i,1);
							if(!repeatType) y--;
							i--;
					}
					if(!repeatType) y++;
				}
				return valueArray;
			},
			__applyMask : function(valueArray, maskArray, plus, fixedCharsReg){
				if( typeof plus == 'undefined' ) plus = 0;
				for(var i=0; i<valueArray.length+plus; i++ ){
					if( maskArray[i] && fixedCharsReg.test(maskArray[i]) )
						valueArray.splice(i, 0, maskArray[i]);
				}
				return valueArray;
			},
			__extraPositionsTill : function(rangeStart, maskArray, fixedCharsReg){
				var extraPos = 0;
				while( fixedCharsReg.test(maskArray[rangeStart]) ){
					rangeStart++;
					extraPos++;
				}
				return extraPos;
			},
			__getNextInput: function(input, selector){
				var formEls = input.form.elements,
					initialInputIndex = $.inArray(input, formEls) + 1,
					jInput = null,
					i;
				for(i = initialInputIndex; i < formEls.length; i++){
					jInput = $(formEls[i]);
					if(this.__isNextInput(jInput, selector))
						return jInput;
				}
				var forms = document.forms,
					initialFormIndex = $.inArray(input.form, forms) + 1,
					y, tmpFormEls = null;
				for(y = initialFormIndex; y < forms.length; y++){
					tmpFormEls = forms[y].elements;
					for(i = 0; i < tmpFormEls.length; i++){
						jInput = $(tmpFormEls[i]);
						if(this.__isNextInput(jInput, selector))
							return jInput;
					}
				}
				return null;
			},
			__isNextInput: function(formEl, selector){
				return formEl
					&& formEl.attr('type') != 'hidden'
					&& formEl.get(0).tagName.toLowerCase() != 'fieldset'
					&& (selector === true || (typeof selector == 'string' && formEl.is(selector)));
			},
			__setRange : function(input, start, end) {
				if(typeof end == 'undefined') end = start;
				if (input.setSelectionRange){
					input.setSelectionRange(start, end);
				}
				else{
					var range = input.createTextRange();
					range.collapse();
					range.moveStart('character', start);
					range.moveEnd('character', end - start);
					range.select();
				}
			},
			__getRange : function(input){
				if (!$.browser.msie) return {start: input.selectionStart, end: input.selectionEnd};
				var pos = {start: 0, end: 0},
					range = document.selection.createRange();
				pos.start = 0 - range.duplicate().moveStart('character', -100000);
				pos.end = pos.start + range.text.length;
				return pos;
			},
			unmaskedVal : function(el){
				return $(el).val().replace($.mask.fixedCharsRegG, '');
			}
		}
	});
	$.fn.extend({
		setMask : function(options){
			return $.mask.set(this, options);
		},
		unsetMask : function(){
			return $.mask.unset(this);
		},
		//deprecated
		unmaskedVal : function(){
			return $.mask.unmaskedVal(this[0]);
		}
	});
})(jQuery);