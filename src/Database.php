<?php
interface Database
{
	public function getConnection();
	public function query($query);
	public function transaction(array $queries);

}
?>