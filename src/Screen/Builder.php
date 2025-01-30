<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Contracts\Fieldable;
use Orchid\Screen\Contracts\Groupable;
use Throwable;

class Builder
{
    /**
     * Fields to be reflected, in the form Field.
     *
     * @var Fieldable[]|mixed
     */
    public $fields;

    /**
     * Transmitted values for display in a form.
     *
     * @var Model|Repository
     */
    public $data;

    /**
     * The form language.
     *
     * @var string|null
     */
    public $language;

    /**
     * The form prefix.
     *
     * @var string|null
     */
    public $prefix;

    /**
     * HTML form string.
     *
     * @var string
     */
    private $form = '';

    /**
     * Builder constructor.
     *
     * @param Fieldable[] $fields
     */
    public function __construct(iterable $fields, ?Repository $data = null)
    {
        $this->fields = collect($fields)->all();
        $this->data = $data ?? new Repository;
    }

    /**
     * @return $this
     */
    public function setLanguage(?string $language = null): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return $this
     */
    public function setPrefix(?string $prefix = null): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Generate a ready-made html form for display to the user.
     *
     * @throws Throwable
     */
    public function generateForm(): string
    {
        collect($this->fields)->each(function (Fieldable $field) {
            $this->form .= is_subclass_of($field, Groupable::class)
                ? $this->renderGroup($field)
                : $this->render($field);
        });

        return $this->form;
    }

    /**
     * @throws \Throwable
     *
     * @return array|string
     */
    private function renderGroup(Groupable $group)
    {
        $prepare = collect($group->getGroup())
            ->map(fn ($field) => $this->render($field))
            ->filter()
            ->toArray();

        return $group->setGroup($prepare)->render();
    }

    /**
     * Render field for forms.
     *
     *
     * @throws Throwable
     *
     * @return mixed
     */
    private function render(Fieldable $field)
    {
        $field->set('lang', $this->language);
        $field->set('prefix', $this->buildPrefix($field));

        if(!($field instanceof Action)) {
            foreach ($this->fill($field->getAttributes()) as $key => $value) {
                $field->set($key, $value);
            }
        }

        return $field->render();
    }

    private function buildPrefix(Fieldable $field): ?string
    {
        return $field->get('prefix', $this->prefix);
    }

    private function fill(array $attributes): array
    {
        $name = $attributes['name'];

        if (! is_string($name) || empty($name)) {
            return $attributes;
        }

        $bindValueName = rtrim($name, '.');
        $attributes['value'] = $this->getValue($bindValueName, $attributes['value'] ?? null);

        // set prefix
        if ($attributes['prefix'] !== null) {
            $name = '.'.$name;
        }

        $attributes['name'] = self::convertDotToArray($name);

        return $attributes;
    }

    /**
     * Gets value of Repository.
     *
     * @param mixed|null $value
     *
     * @return mixed
     */
    private function getValue(string $key, $value = null)
    {
        if ($this->language !== null) {
            $key = $this->language.'.'.$key;
        }

        if ($this->prefix !== null) {
            $key = $this->prefix.'.'.$key;
        }

        $data = $this->data->getContent($key);

        // default value
        if ($data === null) {
            return $value;
        }

        if ($value instanceof Closure) {
            return $value($data, $this->data);
        }

        return $data;
    }

    public static function convertDotToArray(string $string): string
    {
        $name = '';
        $binding = explode('.', $string);

        foreach ($binding as $key => $bind) {
            $name .= $key === 0 ? $bind : '['.$bind.']';
        }

        return $name;
    }
}
