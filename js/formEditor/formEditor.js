(function($) {

	var FormEditor = function() {				
		var self = this;
		var position = 1;
		var InputEditorElements = {
			name : {
				label: 'Mező neve',
				type: 'text',
				position:position++
			},
			label : {
				label: 'Mező címkéje',
				type: 'text',
				position:position++
			},			
			readOnly : {
				label: 'Csak olvasható',
				type: 'checkbox',
				position:position++
			},
			maxLength : {
				label: 'Bevihető szöveg hossza',
				type: 'text',
				position:position++
			},			
		};
		
		var InputElements = function(){
			
			this.actualPage = 1;
										
			this.add = function(name, properties){
				this[name] = properties;				
			}
			
			this.remove = function(name){
				this[name] = null;
			}
			
		};
		
		inputElements = new InputElements();

		var inputDescriptionButtonSelector = "div.sampleInputElement div.descriptionBoxButton";
		
		var sampleInputListSelector = "#sampleInputsList";
		
		var generatedInputListSelector = "#generatedInputList";

		this.init = function() {
			setSampleInputsDescriptionButtonEvents();
			bindFormAddEvent();
		}

		setSampleInputsDescriptionButtonEvents = function() {
			var buttons = $(inputDescriptionButtonSelector);
			$(buttons).each(function() {
				$(this).click(function() {
					var sampleBox = $(this).next();
					if (sampleBox.css('display') == 'none') {
						sampleBox.fadeIn('slow');
					} else {
						sampleBox.fadeOut('fast');
					}

				});
			});
		};		
		bindFormAddEvent = function(){
			$(sampleInputListSelector).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).remove();
				}
			});
			$(generatedInputListSelector).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).after('<li></li>');
					var newInput = $(ui.item).next();
					var generatorInput = ui.item;
					generateInput(generatorInput, newInput);
					$(sampleInputListSelector).sortable("cancel");
				},
				// TODO fixme (remove via drag out)
				remove : function(event, ui){
					type = $(ui.item).attr("input-type");
					if(type == undefined){
						if(confirm("Delete input item?")){
							$(ui.item).remove();	
						}
						
					}
				}				
			});
			$(sampleInputListSelector).disableSelection();
			
		}
				
		generateInput = function(inputElement, newInput){			
			var inputElementType = inputElement.attr("input-type");
			var inputName = generateInputName(inputElementType);
			var inputElementProperties = {
				name : inputName,
				className : inputElementType,
				template : inputElementType,
				label : inputElementType
			}
			sendInputElement(inputElementProperties, function(result){
				attachNewInput(newInput, result, inputElementProperties);
			});
		}
		
		sendInputElement = function(inputElementProperties, successCallback){
			// FIXME hardcoded url			
			$.ajax({
			  type: 'POST',
			  url: '/wp-admin/admin-ajax.php?action=FormEditorController_generateInput',
			  dataType : 'json',
			  data : {
			  	inputElementProperties : inputElementProperties
			  },
			  success: successCallback
			});			
		}
		
		generateInputName = function(inputElementType){
			if(inputElements[inputElementType] == null){
				return inputElementType;
			}else{
				return "name";	
			}			
		}
		
		attachNewInput = function(newInput, result, inputElementProperties){				
			  	newInput.html(result.content);
			  	// TODO bind editor open event
			  	newInput.append('<div class="options"></div>');
			  	var optionsButton = newInput.find('div.options');

			  	var itemPosition = newInput.index();
			  	var inputName = inputElementProperties.name;
			  	
			  	inputElements.add(inputName, inputElementProperties);

				var inputWindowWrapperId = "#window_" + inputName;					
				var inputWindowWrapper = $('<div/>', {
					id : inputWindowWrapperId,
				});
				inputWindowWrapper.addClass("inputWindowEditor");
				generateInputWindowForm(inputName, inputWindowWrapper, result.properties);	
				
				bindInputEditorHandler(optionsButton, inputElementProperties.name, inputWindowWrapper);
		}
		
		bindInputEditorHandler = function(optionsButton, inputName, inputWindowWrapper){
			optionsButton.click(function(){

				$(inputWindowWrapper).dialog({
					draggable : true,
					resizable: true,
					minWidth: 300,
					minHeight: 300,
					// TODO multilinguale
					title: inputName + " editor",
					zIndex: 85000,
					show: true,
					hide: true,
					buttons : {
						"Cancel": function(ev, ui){
							$(this).dialog("destroy");
						},
						"Save": function(){
							changeInputProperties($(this).find('form'));
						}
						
					}
				});
				// TODO generate editor content
			});
		}
		
		generateInputWindowForm = function(inputName, wrapper, properties){
			var propertyForm = $('<form/>',{			
			})
			var attributePropertyInputs = new Array();
			for(propertyIndex in properties){
				var property = propertyIndex;
				var propertyAttributes = InputEditorElements[propertyIndex];
				if(propertyAttributes != undefined){
					propertyAttributes.value = properties[propertyIndex];
					var inputId = inputName + "_" + propertyIndex;
					generateInputWindowInput(attributePropertyInputs, inputId, propertyAttributes);										
				}	
				
			};
			$.each(attributePropertyInputs, function(index, propertyInput){
				propertyForm.append(propertyInput);
			});
			var oldNameInput = createHiddenInputField('old-name', inputName);
			propertyForm.append(oldNameInput);
			wrapper.append(propertyForm);			
		}
		
		createHiddenInputField = function(name, value){
			var input = $('<input/>');
			input.prop('name', name);
			input.prop('type', 'hidden');
			input.val(value);
			return input;
		}
		
		generateInputWindowInput = function(attributePropertyInputs, inputId, attributes){
			var type = attributes.type;
			var input;
			var label = $('<label/>', {
				text: attributes.label,
			});
			label.prop('for', inputId);
			switch(type){
				case 'text' :
					input = $('<input/>', {});
					input.prop('name', inputId);
					input.prop('id', inputId);
					input.prop("type", "text");
					input.prop("value", attributes.value);
					
				break;
				case 'checkbox' :
					input = $('<input/>', {});
					input.prop('name', inputId);
					input.prop('id', inputId);
					input.prop('type', 'checkbox');
					if(attributes.value == true){
						input.prop('checked', true);	
					}
				break;				
			}
			wrapper = $('<div/>',{});
			wrapper.addClass('inputPropertyWrapper');
			wrapper.append(label);
			wrapper.append(input)
			attributePropertyInputs[attributes.position] = wrapper;
		}
		
		changeInputProperties = function(form){
			var inputOldName = $(form).find('input[name=old-name]');
			var oldName = inputOldName.val();

			var inputType = inputElements[oldName].className;

			var inputs = $(form).find('input, select');
			$.each(inputs, function(index, input){
				var inputName = $(input).prop('name');
				var inputNamePrefix = inputType + '_';
				console.log(inputNamePrefix);
				var propertyName = inputName.replace(inputNamePrefix, '');
				console.log(propertyName);

			});
			// TODO check new name is unique
			//sendInputElement(form, test);
		}
		
		test = function(result){
			console.log(result);
		}
		
		unbindInputEditorHandler = function(){
			// TODO when input delete
			// TODO delete inputwindowwrapper
		}
		
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
