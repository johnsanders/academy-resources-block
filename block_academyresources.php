<?php

class block_academyresources extends block_base
{

	function init()
	{
		$this->title = get_string('pluginname', 'block_academyresources');
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
		return true;
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
							<a class='aalink coursename mr-2 href='$linkUrl'>
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
			<section class='block' style='margin: 0 -5px; padding: 0;'>
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
		if ($this->content !== NULL) return $this->content;
		$content = '';
		$showVault = get_config('block_academyresources', 'showvault');
		$showNewsource = get_config('block_academyresources', 'shownewsource');
		$dataRaw = file_get_contents('https://cnn-academy-resources.s3.eu-central-1.amazonaws.com/externalData.json');
		$data = json_decode($dataRaw);
		if ($showVault) {
			$randomItems = $this->select_random(4, $data->vault);
			$content .= $this->create_row("From the CNN Archives", $randomItems);
		}
		if ($showNewsource) {
			$randomItems = $this->select_random(4, $data->newsourceBlog);
			$content .= $this->create_row("CNN Newsource Industry Insights", $randomItems);
		}
		$this->content = new stdClass;
		$this->content->text = $content;
		return $this->content;
	}
}
