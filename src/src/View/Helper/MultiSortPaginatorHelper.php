<?php

namespace App\View\Helper;

use Cake\Utility\Inflector;
use Cake\View\Helper\PaginatorHelper;

class MultiSortPaginatorHelper extends PaginatorHelper
{
    public function sort($key, $title = null, array $options = [])
    {
        $options += ['url' => [], 'model' => null, 'escape' => true, 'order' => []];
        $url = $options['url'];
        unset($options['url']);

        if (empty($title)) {
            $title = $key;

            if (strpos($title, '.') !== false) {
                $title = str_replace('.', ' ', $title);
            }

            $title = __(Inflector::humanize(preg_replace('/_id$/', '', $title)));
        }

        $defaultDir = isset($options['direction']) ? strtolower($options['direction']) : 'asc';
        unset($options['direction']);

        $locked = isset($options['lock']) ? $options['lock'] : false;
        unset($options['lock']);

        $sortKey = $this->sortKey($options['model']);
        $defaultModel = $this->defaultModel();
        $model = $options['model'] ?: $defaultModel;
        list($table, $field) = explode('.', $key . '.');
        if (!$field) {
            $field = $table;
            $table = $model;
        }
        $isSorted = (
            $sortKey === $table . '.' . $field ||
            $sortKey === $model . '.' . $key ||
            $table . '.' . $field === $model . '.' . $sortKey
        );

        $template = 'sort';
        $dir = $defaultDir;

        if ($isSorted) {
            if ($locked) {
                $template = $dir === 'asc' ? 'sortDescLocked' : 'sortAscLocked';
            } else {
                $dir = $this->sortDir($options['model']) === 'asc' ? 'desc' : 'asc';
                $template = $dir === 'asc' ? 'sortDesc' : 'sortAsc';
            }
        } elseif (!empty($options['order'][$key])) {
            if ($locked) {
                $template = $dir === 'asc' ? 'sortDescLocked' : 'sortAscLocked';
            } else {
                $dir = $options['order'][$key] === 'asc' ? 'desc' : 'asc';
                $template = $dir === 'asc' ? 'sortDesc' : 'sortAsc';
            }
        }

        $options['order'] = [$key => $dir] + $options['order'];

        if (is_array($title) && array_key_exists($dir, $title)) {
            $title = $title[$dir];
        }

        $url = array_merge(
            ['sort' => $key, 'direction' => $dir, 'page' => 1],
            $url,
            ['order' => $options['order']]
        );
        $vars = [
            'text' => $options['escape'] ? h($title) : $title,
            'url' => $this->generateUrl($url, $options['model']),
        ];

        return $this->templater()->format($template, $vars);
    }
}
