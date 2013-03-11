<div id="katanaForms">
	<h4><?php echo LanguageUtils::translate("Form editor") ?></h4>
	<div id="formEditorBody">
		<div id="formEditor">
		
		</div>
		<div id="formEditorToolbox">
			<div><?php echo LanguageUtils::translate("Input types");?></div>
			<ul>
				<?php $sampleInputsIterator = $sampleInputs->getIterator(); ?>			
				<?php while($sampleInputsIterator->valid()){?>
					<?php $input = $sampleInputsIterator->current(); ?>				
				<li>
					<?php $input->render() ?> 
				</li>
				<?php $sampleInputsIterator->next(); ?>
				<?php } ?>
			</ul>	
		</div>	
	</div>	
</div>