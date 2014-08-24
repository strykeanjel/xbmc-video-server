<?php

/**
 * Base class for rendering a filter form on index pages. It provides an 
 * abstract method (renderControls()) which should render the filter controls, 
 * as well as an overridable renderButtons() method in case the default setup 
 * is not enough.
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2013-
 * @license https://www.gnu.org/licenses/gpl.html The GNU General Public License v3.0
 */
abstract class VideoFilter extends CWidget
{

	/**
	 * @var VideoFilterForm the form model
	 */
	public $model;

	/**
	 * @var FilterActiveForm the form
	 */
	protected $form;

	/**
	 * Renders the filter controls
	 */
	abstract protected function renderControls();

	/**
	 * Initializes the widget
	 */
	public function init()
	{
		$this->form = $this->beginWidget('FilterActiveForm', array(
			'layout'=>TbHtml::FORM_LAYOUT_INLINE,
			'method'=>'get'));
	}

	/**
	 * Renders the widget
	 */
	public function run()
	{
		?>
		<div class="movie-filter-form well">
			<div class="row-fluid">
				<div class="span9">
					<div class="row-fluid">
						<div class="span12">
							<?php $this->renderControls(); ?>
						</div>
					</div>
				</div>

				<div class="span3">
					<div class="buttons">
						<?php $this->renderButtons(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		
		$this->endWidget();
	}

	/**
	 * Renders the form buttons
	 */
	protected function renderButtons()
	{
		echo TbHtml::submitButton(Yii::t('FilterForm', 'Apply filter'), array(
			'color'=>TbHtml::BUTTON_COLOR_PRIMARY));

		$controller = Yii::app()->controller;
		
		// Disable when no filter is defined
		echo TbHtml::linkButton(Yii::t('FilterForm', 'Clear filter'), array(
			'color'=>TbHtml::BUTTON_COLOR_INFO,
			'disabled'=>$this->model->isEmpty(),
			'url'=>$controller->createUrl($controller->route)));
	}
	
	/**
	 * Converts the specified array of objects to an array of data that can 
	 * be serialized to JSON
	 * @param ITypeaheadData[] $sourceData the source data
	 * @return array the typeahead data
	 */
	protected function getTypeaheadData($sourceData)
	{
		$typeaheadData = array();

		foreach ($sourceData as $media)
			$typeaheadData[] = $media->getName();

		return $typeaheadData;
	}

}
