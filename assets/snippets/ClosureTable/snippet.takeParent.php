<?php
/**
 * takeParent
 *
 * Getting the parent of any nesting level with just one SQL query
 *
 * @version 	1.0.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @category 	snippet
 * @author  	Agel Nash <modx@agel-nash.ru>
 * @internal    @legacy_names takeParent
 * @internal    @modx_category API
 * @internal	@dependency_plugin ClosureTable
 */

if (!defined('MODX_BASE_PATH')) { die('HACK???'); }

$topLevel = isset($topLevel) ? (int)$topLevel : 0;
$id = isset($id) ? (int)$id : (int)$modx->documentObject['id'];

$q = $modx->db->query('SELECT c.id, t.depth, t.ancestor,t.descendant FROM '.$modx->getFullTableName('site_content').' as c
JOIN '.$modx->getFullTableName('site_content_tree').' as t ON c.id = t.ancestor
WHERE t.descendant = '.$id.' ORDER BY t.depth ASC');
$data = $modx->db->makeArray($q);

$out = isset($data[$topLevel]['id']) ? $data[$topLevel]['id'] : 0;
if(empty($out)){
	$out = end($data);
	$out = isset($out['id']) ? $out['id'] : 0;
}

return $out;