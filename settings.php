<?php

if ($ADMIN->fulltree) {
	$settings->add(new admin_setting_configtext(
		'block_myspecialcourse/courseid',
		get_string('courseid', 'block_myspecialcourse'),
		get_string('courseiddesc', 'block_myspecialcourse'),
		0
	));
	$settings->add(new admin_setting_configtext(
		'block_myspecialcourse/',
		get_string('title', 'block_myspecialcourse'),
		get_string('courseidtitle', 'block_myspecialcourse'),
		0
	));
}
