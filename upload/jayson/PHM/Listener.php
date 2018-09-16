<?php
class jayson_PHM_Listener {
	public static function Listen($class, array &$extend) {
		$extend[] = 'jayson_PHM_Extend_'.$class;
	}
}
