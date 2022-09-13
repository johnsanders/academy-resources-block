<?php
defined('MOODLE_INTERNAL') || die();
require_once('/bitnami/moodle/config.php');

class block_myspecialcourse extends block_base
{
	function init()
	{
		$this->title = get_string('myresources', 'block_myspecialcourse');
	}
	function has_config()
	{
		return true;
	}
	public function instance_allow_multiple()
	{
		return true;
	}
	public function hide_header()
	{
		return false;
	}
	public function select_random($num, $arr)
	{
		$randoms = [];
		for ($i = 0; $i < $num; $i++) {
			$rand = rand(0, count($arr) - 1);
			array_push($randoms, $arr[$rand]);
			array_splice($arr, $rand, 1);
		}
		return $randoms;
	}
	function create_item($rowItem)
	{
		$title = $rowItem->title;
		$linkUrl = $rowItem->linkUrl;
		$imageUrl = $rowItem->imageUrl;
		return "
			<div class='card dashboard-card'>
				<a href='$linkUrl'>
					<div
						class='card-img dashboard-card-img'
						style='background-image: url(\"$imageUrl\");'
					>
					</div>
				</a>
				<div class='card-body course-info-container'>
					<div class='d-flex align-items-start'>
						<div class='w-100'>
							<a class='aalink coursename mr-2 href='$linkUrl' style='font-size: 1.2em'>
								<span class='multiline'>
									$title
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		";
	}
	function create_row($rowTitle, $rowItems)
	{
		$itemsContent = '';
		foreach ($rowItems as $item) {
			$itemsContent .= $this->create_item($item);
		}
		$content = "
			<section class='block' style='margin: 0 -5px 3em -5px; padding: 0;'>
				<div class='header'>
					<div class='title'>
						<h2 class='d-inline'>
							$rowTitle
						</h2>
					</div>
				</div>
				<div class='content'>
					<div class='container-fluid p-0'>
						<div class='card-deck dashboard-card-deck'>
							$itemsContent
						</div>
					</div>
				</div>
			</section>
		";
		return $content;
	}
	function get_content()
	{
		global $CFG, $DB;
		require_once($CFG->dirroot.'/course/lib.php');
		if ($this->content !== NULL) return $this->content;
		$courseId = get_config('block_myspecialcourse', 'courseid');
		$course = $DB->get_record('course', array('id' => $courseId));
		$modinfo = get_fast_modinfo($course);
		foreach ($modinfo->sections[1] as $cmid) {
			$cm = $modinfo->cms[$cmid];
			// $cminfo = \cm_info::create($cm);
			print_r($cm->get_formatted_name().'fdsaaaa');
		}
		$content = 'woo212jj-' . $courseId . '-§oo' . $course->fullname . '-----';
		$this->content = new stdClass;
		$this->content->text = $content;
		return $this->content;

		/*
		$content .= $this->create_row("CNN Newsource Industry Insights", $randomItems);
		$this->content = new stdClass;
		$this->content->text = $content;
		return $this->content;
		*/
	}
}