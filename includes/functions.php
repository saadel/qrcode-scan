<?php 
function escape($var)
{
	return htmlEntities($var, ENT_QUOTES);
}