(function($){
	"use strict";
	
	// TODO descriptors not used yet
	var KatanaFormInputDescriptor = function(){
		
		var templates;
		
		var label;
		
		this.setTemplates = function(templatesList){
			templates = templatesList;
		}
		
		this.setDefaultLabel = function(label){
			
		}
		
	}
	
	var KatanaFormInputDescriptorHolder = function(){
		this.add = function(inputType, properties){
			this[inputType] = properties;				
		}
		this.get = function(inputType){
			return this[inputType]
		}			
		
	}
	
	
	var Pages = function(){
		var pagesNum = 1;
		var currentPage = 1;
		
		this.add = function(){
			pagesNum++;
		}
		this.remove = function(){
			pagesNum--;
		}
		
		this.getPagesNum = function(){
			return pagesNum;
		}
		
		this.setCurrentPage = function(pageId){
			currentPage = pageId;
		}
		
		this.getCurrentPage = function(){
			return currentPage;
		}
	}
	
	var inputElementPosition = 1;
	
	var InputEditorElements = {
		name : {
			label: 'Mező neve',
			type: 'text',
			position:inputElementPosition++
		},
		label : {
			label: 'Mező címkéje',
			type: 'text',
			position:inputElementPosition++
		},
		placeholder : {
			label: 'Placeholder',
			type: 'text',
			position:inputElementPosition++
		},			
		readOnly : {
			label: 'Csak olvasható',
			type: 'checkbox',
			position:inputElementPosition++
		},
		maxLength : {
			label: 'Bevihető szöveg hossza',
			type: 'text',
			position:inputElementPosition++
		},
		value : {
			label: 'Érték',
			type: 'text',
			position:inputElementPosition++
		},					
	};
	
	var InputElements = function(){														
		this.add = function(name, properties){
			this[name] = properties;				
		}			
		this.remove = function(name){
			this[name] = null;
		}
	};
	
	var Selectors = {
		formEditor : "#formEditor",
		
		inputDescriptionButtonSelector : "div.sampleInputElement div.descriptionBoxButton",
		
		sampleInputList : "#sampleInputsList",
		
		formPage : ".formPage",
		
		activeFormPage :".formPage.active",
		
		prevPage : "#prevPage",
		
		nextPage : "#nextPage",
		
		newPageButton : "#addPage",
		
		currentPage : "#currentPage",
		
		formInputElements : "#formInputElements",
		
		formPager : ".formPager",		
	}	
		

	var FormEditor = function(){
		var self = this;

		// TODO translate texts
						
		var pages = new Pages();
		
		var inputElements = new InputElements();
				
		this.init = function() {
			setSampleInputsDescriptionButtonEvents();
			bindFormAddEvent();
			setPagerButtonsClickEvent();
			addNewPageButtonEvent();
		}

		var setSampleInputsDescriptionButtonEvents = function() {
			var buttons = $(Selectors.inputDescriptionButtonSelector);
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
		var bindFormAddEvent = function(){
			$(Selectors.sampleInputList).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).remove();
				}
			});
			// TODO create sample window instead of embed that into the button
			$(Selectors.sampleInputList).disableSelection();
			
			setFormpageToSortable($(Selectors.formPage));			
		}
		
		var setFormpageToSortable = function(inputLists){
			$(inputLists).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(Selectors.activeFormPage).removeClass('sortingInProgress');					
					$(ui.item).after('<li class="inputWrapper"></li>');					
					var newInput = $(ui.item).next();
					var generatorInput = ui.item;
					generateInput(generatorInput, newInput);
					$(Selectors.sampleInputList).sortable("cancel");
				},
				over : function(event, ui){					
					$(Selectors.activeFormPage).addClass('sortingInProgress');
				},
				deactivate : function(event, ui){
					$(Selectors.activeFormPage).removeClass('sortingInProgress')
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
		}
		
		var toggleFormEditorProgressBar = function(state){
			if(state){
				createFormEditorProgressBar();
			}else{
				removeFormEditorProgressBar();
			}
		}
		
		var createFormEditorProgressBar = function(){
			var leftPanel = $(Selectors.formEditor).parent();
			var progressBarWrapper = $('<div/>');
			progressBarWrapper.prop("id", "progressBarWrapper");
			progressBarWrapper.css("position", "absolute");			
			var position = leftPanel.position();
			progressBarWrapper.width(leftPanel.width());
			progressBarWrapper.height(leftPanel.height());
			progressBarWrapper.css("top", position.top + "px");
			progressBarWrapper.css("left", position.left + "px");
			progressBarWrapper.addClass("progressBarWrapper");
			
			var progressBar = $('<div/>');
			progressBar.addClass('generatingInProgress');
			progressBarWrapper.append(progressBar);
			
			leftPanel.append(progressBarWrapper);
		}
		
		var removeFormEditorProgressBar = function(){
			$("#progressBarWrapper").remove();
		}
						
		var generateInput = function(inputElement, newInput){			
			var inputElementType = inputElement.attr("input-type");
			var inputElementSimpleName = inputElement.attr("simple-name");
			var inputName = generateInputName(inputElementType);
			// TODO template handling
			var inputElementProperties = {
				name : inputElementSimpleName,
				className : inputElementType,
				template : 'default',
				label : inputElementSimpleName
			}
			toggleFormEditorProgressBar(true);
			sendInputElement(inputElementProperties, function(result){
				attachNewInput(newInput, result, result.properties);
				toggleFormEditorProgressBar(false);
			});
		}
				
		
		var sendInputElement = function(inputElementProperties, successCallback){
			// FIXME hardcoded url			
			$.ajax({
			  type: 'POST',
			  url: '/wp-admin/admin-ajax.php?action=Katana_generateInput',
			  dataType : 'json',
			  data : {
			  	inputElementProperties : inputElementProperties
			  },
			  success: successCallback
			});			
		}
		
		var generateInputName = function(inputElementType){
			if(inputElements[inputElementType] == null){
				return inputElementType;
			}else{
				// TODO generate name
				return "name";	
			}			
		}
		
		var attachNewInput = function(newInput, result, inputElementProperties){
			  	newInput.html(result.content);

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
		
		var bindInputEditorHandler = function(optionsButton, inputName, inputWindowWrapper){
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
							changeInputProperties($(this));
						}
						
					}
				});
			});
		}
		
		var generateInputWindowForm = function(inputName, wrapper, properties){
			var propertyForm = $('<form/>',{			
			})
			var attributePropertyInputs = new Array();
			for(var propertyIndex in properties){
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
		
		var createHiddenInputField = function(name, value){
			var input = $('<input/>');
			input.prop('name', name);
			input.prop('type', 'hidden');
			input.val(value);
			return input;
		}
		
		var generateInputWindowInput = function(attributePropertyInputs, inputId, attributes){
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
					input.prop('value', attributes.value);
					
				break;
				case 'checkbox' :
					input = $('<input/>', {});
					input.prop('name', inputId);
					input.prop('id', inputId);
					input.prop('type', 'checkbox');
					input.prop('value', 1);
					if(attributes.value == 1){
						input.prop('checked', true);	
					}
				break;				
			}
			var wrapper = $('<div/>',{});
			wrapper.addClass('inputPropertyWrapper');
			wrapper.append(label);
			wrapper.append(input)
			attributePropertyInputs[attributes.position] = wrapper;
		}
		
		var changeInputProperties = function(propertyWindow){
			var form = $(propertyWindow).find('form');
			var inputOldName = $(form).find('input[name=old-name]');			
			var oldName = inputOldName.val();			
			var inputs = $(form).find('input, select, textarea').not('input[name=old-name]');
			
			var inputProperties = $.extend(true, {}, inputElements[oldName]);			
			$.each(inputs, function(index, input){
				var inputName = $(input).prop('name');
				var inputNamePrefix = oldName + '_';
				var propertyName = inputName.replace(inputNamePrefix, '');
				var inputValue = $(input).val();
				switch($(input).prop("type")){
					case 'checkbox':
						if($(input).prop("checked")){
							inputProperties[propertyName] = 1;	
						}else{
							inputProperties[propertyName] = 0;
						}
					break;
					case 'select-one':
						// TODO
					break;
					default:
						inputProperties[propertyName] = inputValue;
					break;
				}
				
			});
			sendInputElement(inputProperties, function(result){
				propertyWindowSaveEvent(oldName, result, propertyWindow);
				toggleFormEditorProgressBar(false);				
			});			

		}
		
		var propertyWindowSaveEvent = function(inputOldName, result, propertyWindow){
			if(result.valid){
				var generatedInput = $('input[name='+inputOldName+'], button[name='+inputOldName+']');
				var inputWrapper = generatedInput.closest('li.inputWrapper');				
				attachNewInput(inputWrapper, result, result.properties);
				inputElements[inputOldName] = null;
				var inputName = result.properties.name;				
				inputElements[inputName] = result.properties;
				propertyWindow.dialog('destroy');
			}else{
				propertyWindowErrorEvent(result);
			}
		}
		
		var propertyWindowErrorEvent = function(result){
			// TODO develop
			alert('input property error');	
		}
		
		var unbindInputEditorHandler = function(){
			// TODO when input delete
			// TODO delete inputwindowwrapper
		}
		
		var setPagerButtonsClickEvent = function(){
			$(Selectors.formPager).click(
				function(event){
					var buttonId = event.target.id;
					var button = $(this);					 
					if(!button.hasClass('activePager')){
						return;
					}
					var currentPage = pages.getCurrentPage();
					var targetPage;
					if(buttonId == 'prevPage'){						
						targetPage = currentPage-1;	
					}
					if(buttonId == 'nextPage'){
						targetPage = currentPage + 1;
					}
					scrollFormPages(currentPage, targetPage);

				}
			);			
		}
		
		var addNewPageButtonEvent = function(){
			$(Selectors.newPageButton).click(function(){
				addNewPage();				
			});
		}
		
		var addNewPage = function(){
			pages.add();					
			var newFormPage = createNewFormPage(pages.getPagesNum());
			$(Selectors.formInputElements).append(newFormPage);
			setFormpageToSortable(newFormPage);
			increaseFormEditorSize(newFormPage.width());
			var newPageId = pages.getPagesNum();
						
			var activePageId = getActivePageId();						
			scrollFormPages(activePageId, newPageId);						
		}
				
		var increaseFormEditorSize = function(size){
			var originalWidth = $(Selectors.formEditor).width(); 
			$(Selectors.formEditor).width(originalWidth + size)
		}
		
		var getActivePageId = function(){
			var activePage = $(Selectors.activeFormPage);
			return activePage.attr("page-id");
		}
		
		var createNewFormPage = function(pageId){
			var formPage = $('<ul/>');
			formPage.addClass('formPage droptrue');
			formPage.attr("page-id", pageId);	
			return formPage;
		}
								
		var scrollFormPages = function(currentFormPageId, targetFormPageId){
			if(currentFormPageId > targetFormPageId){
				scrollFormPagesLeft(currentFormPageId, targetFormPageId);	
			}
			if(currentFormPageId < targetFormPageId){				
				scrollFormPagesRight(currentFormPageId, targetFormPageId);
			}			
			setFormPageToActive(targetFormPageId);			
			pages.setCurrentPage(targetFormPageId);
			displayFormId();
			changePagerButtonsActiveStatus();
		}

		var scrollFormPagesLeft = function(from, to){
			var delta = (from - to) * 400;
			var actualLeftPosition = getFormEditorLeftPosition();
			var distance = delta + actualLeftPosition;
			$(Selectors.formEditor).animate({
					left: "" + distance + "px"
				},
				"slow"
			);
		}

		var scrollFormPagesRight = function(from, to){;
			var delta = (from - to) * 400;
			var actualLeftPosition = getFormEditorLeftPosition();
			var distance = delta + actualLeftPosition;
			$(Selectors.formEditor).animate({
					left: "" + distance + "px"
				},
				"slow"
			);
		}
						
		var getFormEditorLeftPosition = function(){
			var position = $(Selectors.formEditor).position();
			return position.left;
		}
		
		var getFormPage = function(pageId){
			return $(Selectors.formEditor + ' ' + Selectors.formInputElements + ' ul[page-id="'+pageId+'"]');
		}
		
		var changePagerButtonsActiveStatus = function(){
			if(pages.getPagesNum < 2){
				$(Selectors.formPager).removeClass('activePager');
				return;
			}
			if(pages.getCurrentPage() > 1){
				$(Selectors.prevPage).addClass('activePager');				
			}else{
				$(Selectors.prevPage).removeClass('activePager');
			}
			if(pages.getCurrentPage() < pages.getPagesNum()){
				$(Selectors.nextPage).addClass('activePager');
			}else{
				$(Selectors.nextPage).removeClass('activePager');
			}
		}
		
		var setFormPageToActive = function(formPageId){
			var activePage = $(Selectors.activeFormPage);
			activePage.removeClass("active");
			getFormPage(formPageId).addClass("active");
		}
		
		var displayFormId = function(){
			$(Selectors.currentPage).html(pages.getCurrentPage());
		}
	};

	var formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
