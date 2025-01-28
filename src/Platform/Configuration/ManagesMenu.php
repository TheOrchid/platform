<?php

namespace Orchid\Platform\Configuration;

use Orchid\Screen\Actions\Menu;
use Orchid\Support\Attributes\ClearsOctaneState;

trait ManagesMenu
{
    /**
     * The collection of menu items.
     *
     * @var array<Menu>
     */
    #[ClearsOctaneState]
    protected array $menuItems = [];

    /**
     * Register a menu element with the Dashboard.
     *
     * @param Menu $menu The menu element to add.
     *
     * @return $this
     */
    public function registerMenuElement(Menu $menu): static
    {
        if ($menu->get('sort', 0) === 0) {
            $menu->sort(count($this->menuItems) + 1);
        }

        $this->menuItems[] = $menu;

        return $this;
    }

    /**
     * Render the menu as a string for display.
     *
     * @throws \Throwable If rendering fails.
     *
     * @return string The rendered menu HTML.
     */
    public function renderMenu(): string
    {
        return collect($this->menuItems)
            ->sort(fn (Menu $current, Menu $next) => $current->get('sort', 0) <=> $next->get('sort', 0))
            ->map(fn (Menu $menu) => (string) $menu->render())
            ->implode('');
    }

    /**
     * Check if the menu is empty.
     *
     * @return bool True if the menu is empty, otherwise false.
     */
    public function isEmptyMenu(): bool
    {
        return empty($this->menuItems);
    }

    /**
     * Add submenu items to a menu element identified by its slug.
     *
     * @param string $slug The slug of the menu element to update.
     * @param Menu[] $list Array of submenu items to add.
     *
     * @return $this
     */
    public function addMenuSubElements(string $slug, array $list): static
    {
        $this->menuItems = collect($this->menuItems)
            ->map(fn (Menu $menu) => $slug === $menu->get('slug')
                ? $menu->list($list)
                : $menu)
            ->all();

        return $this;
    }
}
