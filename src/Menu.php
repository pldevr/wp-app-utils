<?php

namespace Devr\Utils;

final class Menu
{
    public static function getMenu(string $location, callable $callback = null, bool $tree = false): array
    {
        $items = array_map(
            is_callable($callback) ? $callback : [Menu::class, 'format'],
            self::getItemsByLocation($location)
        );

        if ($tree) {
            $items = self::getTree($items, 0);
        }

        return $items;
    }

    private static function getTree(&$items, $parent = 0): array
    {
        $tree = [];

        foreach ($items as &$item) {
            if ((int)$item['menu_item_parent'] === $parent) {
                $children = self::getTree($items, $item['id']);
                $item['children'] = $children ? $children : null;

                $tree[] = $item;
                unset($item);
            }
        }

        return $tree;
    }

    private static function format(\WP_Post $item): array
    {
        return [
            'id' => $item->ID,
            'title' => $item->title,
            'url' => $item->url,
            'target' => $item->target,
            'object' => $item->object,
            'type' => $item->type,
            'object_id' => (int)$item->object_id,
            'post_parent' => $item->post_parent,
            'menu_item_parent' => (int)$item->menu_item_parent,
            'menu_order' => $item->menu_order,
            'children' => [],
        ];
    }

    private static function getItemsByLocation(string $location): array
    {
        $items = [];
        $locations = get_nav_menu_locations();

        if (array_key_exists($location, $locations)) {
            $items = wp_get_nav_menu_items($locations[$location]) ?: [];
        }

        return $items;
    }
}
