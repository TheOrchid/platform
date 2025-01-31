<?php

declare(strict_types=1);

namespace Orchid\Support;

/**
 * This class represents a list of colors.
 */
enum Color
{
    // All available colors
    case INFO;
    case SUCCESS;
    case WARNING;
    case BASIC;
    case DEFAULT;
    case DANGER;
    case PRIMARY;
    case SECONDARY;
    case LIGHT;
    case DARK;
    case LINK;
    case ERROR;

    /**
     * This method returns the name of the given color.
     *
     * @return string
     */
    public function name(): string
    {
        return match ($this) {
            Color::INFO    => 'info',
            Color::SUCCESS => 'success',
            Color::WARNING => 'warning',
            Color::BASIC, Color::DEFAULT => 'default',
            Color::DANGER, Color::ERROR => 'danger',
            Color::PRIMARY   => 'primary',
            Color::SECONDARY => 'secondary',
            Color::LIGHT     => 'light',
            Color::DARK      => 'dark',
            Color::LINK      => 'link',
        };
    }

    /**
     * This method returns the bootstrap table color class.
     *
     * @return string
     */
    public function contextualClass(): string
    {
        return match ($this) {
            Color::INFO    => 'table-info',
            Color::SUCCESS => 'table-success',
            Color::WARNING => 'table-warning',
            Color::BASIC, Color::DEFAULT => '',
            Color::DANGER, Color::ERROR => 'table-danger',
            Color::PRIMARY, Color::LINK => 'table-primary',
            Color::SECONDARY => 'table-secondary',
            Color::LIGHT     => 'table-light',
            Color::DARK      => 'table-dark',
        };
    }

    /**
     * This method returns the color based on the given name.
     * It is used to maintain backwards compatibility to 13.0.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return \Closure|\Orchid\Support\Color
     */
    public static function __callStatic($name, $arguments)
    {
        return collect(Color::cases())
            ->filter(fn (Color $color) => $color->name === $name)
            ->first() ?? Color::BASIC;
    }
}
