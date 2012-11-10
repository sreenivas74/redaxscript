<?php

/* get parameter */

function get_parameter($input = '')
{
	static $parameter;

	/* get parameter */

	if ($parameter == '')
	{
		$parameter = explode('/', $_GET['p']);

		/* clean parameter */

		$parameter = array_map('clean_alias', $parameter);
		$parameter = array_map('clean_mysql', $parameter);
	}

	/* if admin parameter */

	if ($parameter[0] == 'admin')
	{
		$admin = 1;
	}

	/* switch parameter */

	switch (true)
	{
		case $input == 'first' && is_numeric($parameter[0]) == '':
			$output = $parameter[0];
			break;
		case $input == 'first_sub' && is_numeric($parameter[1]):
		case $input == 'second' && is_numeric($parameter[1]) == '':
		case $input == 'admin' && $admin == 1:
			$output = $parameter[1];
			break;
		case $input == 'second_sub' && is_numeric($parameter[2]):
		case $input == 'third' && is_numeric($parameter[2]) == '':
		case $input == 'table' && $admin == 1:
			$output = $parameter[2];
			break;
		case $input == 'third_sub' && is_numeric($parameter[3]):
		case $input == 'id' && $admin == 1 && is_numeric($parameter[3]):
		case $input == 'alias' && $admin == 1 && is_numeric($parameter[3]) == '':
			$output = $parameter[3];
			break;
		case $input == 'last' && is_numeric(end($parameter)):
			$output = prev($parameter);
			break;
		case $input == 'last' && is_numeric(end($parameter)) == '':
		case $input == 'last_sub' && is_numeric(end($parameter)):
		case $input == 'token' && end($parameter) == TOKEN:
			$output = end($parameter);
			break;
		default:
			$output = '';
			break;
	}
	return $output;
}

/* get route */

function get_route($mode = '')
{
	/* switch admin parameter */

	switch (ADMIN_PARAMETER)
	{
		case 'up':
		case 'down':
		case 'publish':
		case 'unpublish':
		case 'enable':
		case 'disable':
		case 'install':
		case 'uninstall':
		case 'delete':
		case 'process':
			$output = 'admin/view/' . TABLE_PARAMETER;
			break;
		case 'update':
			$output = 'admin/edit/' . TABLE_PARAMETER;
			break;
		default:
			$parameter = explode('/', $_GET['p']);

			/* clean parameter */

			$parameter = array_map('clean_alias', $parameter);
			$parameter = array_map('clean_mysql', $parameter);

			/* mode one */

			if ($mode == 1)
			{
				$last_value = end($parameter);
				if (is_numeric($last_value))
				{
					$last = end(array_keys($parameter));
					unset($parameter[$last]);
				}
			}
			$last = end(array_keys($parameter));
			foreach ($parameter as $key => $value)
			{
				$output .= $value;
				if ($last != $key)
				{
					$output .= '/';
				}
			}
	}
	return $output;
}

/* get file */

function get_file()
{
	$output = basename($_SERVER['SCRIPT_NAME']);
	return $output;
}

/* get root */

function get_root()
{
	$host = 'http://' . $_SERVER['HTTP_HOST'];
	$directory = dirname($_SERVER['SCRIPT_NAME']);
	$output = $directory == '/' || $directory == '\\' ? $host : $host . $directory;
	return $output;
}

/* get user ip */

function get_user_ip()
{
	$output = $_SERVER['REMOTE_ADDR'];
	return $output;
}

/* get user agent */

function get_user_agent($mode = '')
{
	/* switch mode */

	switch ($mode)
	{
		case 2:
			$type = 'agent_engines';
			break;
		case 3:
			$type = 'agent_systems';
			break;
		case 4:
			$type = 'agent_mobiles';
			break;
		default:
			$type = 'agent_browsers';
			break;
	}
	$list = explode(', ', b($type));
	$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

	/* collect output */

	foreach ($list as $value)
	{
		if (stristr($user_agent, $value))
		{
			/* get browser version */

			if ($mode == 1)
			{
				$output = floor(substr($user_agent, strpos($user_agent, $value) + strlen($value) + 1, 3));

				/* opera fallback */

				if ($output > 100)
				{
					$output = substr($output, 0, 1);
				}
			}
			else
			{
				$output = $value;
			}
		}
	}
	if ($output)
	{
		return $output;
	}
}

/* get token */

function get_token()
{
	$a = session_id();
	$b = $_SERVER['REMOTE_ADDR'];
	$c = $_SERVER['HTTP_USER_AGENT'];
	$d = $_SERVER['HTTP_HOST'];
	$output = sha1($a . $b . $c . $d);
	return $output;
}
?>