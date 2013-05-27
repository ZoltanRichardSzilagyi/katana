<?php 
use classes\utils\LanguageUtils;
?>
<div id="katanaForms">
	<h4><?php echo LanguageUtils::translate("Form editor") ?></h4>
	<div id="formEditorBody">
		<div id="formEditorLeftPanel">
			<div id="formEditor">
				<div id="formInputElements">
					<form>
						<ul class="formPage droptrue active" page-id="1">
						</ul>
					</form>	
				</div>
			</div>
		</div>
		<div id="formEditorRightPanel">
			<div id="formPagesBox">
				<div><h4>Pages</h4></div>
				<div id="formPager">
					<div id="prevPage" class="formPager" title="<?php echo LanguageUtils::translate("Previous page") ?>"></div>
					<div id="currentPage" title="<?php echo LanguageUtils::translate("Current page") ?>">1</div>
					<div id="nextPage" class="formPager" title="<?php echo LanguageUtils::translate("Next page") ?>"></div>
				</div>
				<div  id="formPageOptions">
					<div id="addPage" title="<?php echo LanguageUtils::translate("Add new page") ?>"></div>
					<div id="editPage" title="<?php echo LanguageUtils::translate("Edit current page") ?>"></div>
					<div id="deletePage" title="<?php echo LanguageUtils::translate("Delete current page") ?>"></div>
				</div>	
			</div>			
			<div id="formEditorToolbox">			
				<div class="boxTitle"><?php echo LanguageUtils::translate("Fields"); ?></div>
					<ul id="sampleInputsList" class="droptrue ui-sortable">
						<?php $sampleInputsIterator = $sampleInputs -> getIterator(); ?>									
						<?php while($sampleInputsIterator->valid()){?>							
							<?php $input = $sampleInputsIterator->current(); ?>											
						<li input-type="<?php echo $input::className()?>" template="<?php echo $input->getTemplate()?>">							
							<?php $input->render() ?> 
						</li>
						<?php $sampleInputsIterator->next(); ?>						
						<?php } ?>
					</ul>
			</div>
		</div>
		<div id="windowWrapper">
		</div>
	</div>	
</div>