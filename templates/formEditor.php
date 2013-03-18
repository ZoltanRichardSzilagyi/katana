<div id="katanaForms">
	<h4><?php echo LanguageUtils::translate("Form editor") ?></h4>
	<div id="formEditorBody">
		<div id="formEditor">
			<div id="formProperties">				
			Ajax form, Pages num: 1
			< >
			</div>
			<div id="formInputElements">
				<ul id="generatedInputList" class="droptrue">
				</ul>	
			</div>
		</div>
		<div id="formEditorToolbox">
			<div class="boxTitle"><?php echo LanguageUtils::translate("Fields");?></div>
			<form>
				<ul id="sampleInputsList" class="droptrue ui-sortable">
					<?php $sampleInputsIterator = $sampleInputs->getIterator(); ?>			
					<?php while($sampleInputsIterator->valid()){?>
						<?php $input = $sampleInputsIterator->current(); ?>				
					<li input-type="<?php echo $input::className()?>">
						<?php $input->render() ?> 
					</li>
					<?php $sampleInputsIterator->next(); ?>
					<?php } ?>
				</ul>
			</form>	
		</div>	
	</div>	
</div>