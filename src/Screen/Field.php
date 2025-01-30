<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;
use Orchid\Screen\Concerns\Makeable;
use Orchid\Screen\Contracts\Fieldable;
use Orchid\Screen\Exceptions\FieldRequiredAttributeException;
use Throwable;

/**
 * Class Field.
 *
 * @method self accesskey($value = true)
 * @method self class($value = true)
 * @method self dir($value = true)
 * @method self hidden($value = true)
 * @method self id($value = true)
 * @method self lang($value = true)
 * @method self spellcheck($value = true)
 * @method self style($value = true)
 * @method self tabindex($value = true)
 * @method self autocomplete($value = true)
 */
class Field implements Fieldable, Htmlable
{
    use CanSee, Conditionable, Macroable, Makeable {
        Macroable::__call as macroCall;
    }

    /**
     * A set of closure functions
     * that must be executed before data is displayed.
     *
     * @var Closure[]
     */
    private $beforeRender = [];

    /**
     * View template show.
     *
     * @var string
     */
    protected $view;

    /**
     * An array containing all attributes available to the field.
     * Attributes are used to configure the HTML form element.
     *
     * @var array
     */
    protected $attributes = [
        'value' => null,
    ];

    /**
     * Required Attributes.
     *
     * @var array
     */
    protected $required = [
        'name',
    ];

    /**
     * Vertical or Horizontal
     * bootstrap forms.
     *
     * @var Closure|string|null
     */
    protected $typeForm;

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    protected $translations = [
        'title',
        'placeholder',
        'help',
    ];

    /**
     * Universal attributes are applied to almost all tags,
     * so they are allocated to a separate group so that they do not repeat for all tags.
     *
     * @var array
     */
    protected $universalAttributes = [
        'accesskey',
        'class',
        'dir',
        'hidden',
        'id',
        'lang',
        'spellcheck',
        'style',
        'tabindex',
        'title',
        'xml:lang',
        'autocomplete',
        'data-*',
        'aria-*',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [];

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return $this|mixed|static|\Orchid\Screen\Field
     */
    public function __call(string $method, array $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        $arguments = collect($parameters)->map(static fn ($argument) => $argument instanceof Closure ? $argument() : $argument);

        if (method_exists($this, $method)) {
            $this->$method($arguments);
        }

        return $this->set($method, $arguments->first() ?? true);
    }

    /**
     * Sets the 'value' attribute of the field.
     *
     * @param mixed $value The value to be set for the 'value' attribute.
     */
    public function value(mixed $value): static
    {
        return $this->set('value', $value);
    }

    /**
     * Sets the value for the specified attribute of the field.
     *
     * @param string $key   The name of the attribute to set.
     * @param mixed  $value The value of the attribute. Defaults to true.
     *
     * @return static Returns the current instance for method chaining.
     */
    public function set(string $key, $value = true): static
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Validates that all required attributes are present in the field.
     *
     * @throws FieldRequiredAttributeException if any required attribute is missing.
     *
     * @return static Returns the current instance for method chaining.
     */
    protected function ensureRequiredAttributesArePresent(): static
    {
        collect($this->required)
            ->filter(fn ($attribute) => ! array_key_exists($attribute, $this->attributes))
            ->each(function ($attribute) {
                throw new FieldRequiredAttributeException($attribute);
            });

        return $this;
    }

    /**
     * Renders the field.
     *
     * @throws Throwable
     *
     * @return Factory|View|mixed
     */
    public function render()
    {
        if (! $this->isSee()) {
            return;
        }

        $this
            ->ensureRequiredAttributesArePresent()
            ->customizeFieldName()
            ->updateFieldValue()
            ->runBeforeRender()
            ->translateAttributes()
            ->markFieldWithError()
            ->generateId();

        return view($this->view, array_merge($this->getAttributes(), [
            'attributes'     => $this->getAllowAttributes(),
            'dataAttributes' => $this->getAllowDataAttributes(),
            'old'            => $this->getOldValue(),
            'oldName'        => $this->getOldName(),
            'typeForm'       => $this->typeForm ?? $this->vertical()->typeForm,
        ]))
            ->withErrors($this->getErrorsMessage());
    }

    /**
     * Translates the field's attributes if necessary.
     *
     * @return static
     */
    private function translateAttributes(): static
    {
        $lang = $this->get('lang');

        collect($this->attributes)
            ->intersectByKeys(array_flip($this->translations))
            ->each(function ($value, $key) use ($lang) {
                $translation = __($value, [], $lang);
                $this->set($key, is_string($translation) ? $translation : $value);
            });

        return $this;
    }

    /**
     * Gets the field's attributes.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Gets the allowed attributes for the field.
     *
     * @return ComponentAttributeBag
     */
    protected function getAllowAttributes(): ComponentAttributeBag
    {
        $allow = array_merge($this->universalAttributes, $this->inlineAttributes);

        $attributes = collect($this->getAttributes())
            ->filter(fn ($value, $attribute) => Str::is($allow, $attribute))
            ->toArray();

        return (new ComponentAttributeBag())
            ->merge($attributes);
    }

    /**
     * Gets the allowed data attributes for the field.
     *
     * @return ComponentAttributeBag
     */
    protected function getAllowDataAttributes(): ComponentAttributeBag
    {
        return $this->getAllowAttributes()->filter(fn ($value, $key) => Str::startsWith($key, 'data-'));
    }

    /**
     * Generates a field ID if not already set.
     *
     * @param string $defaultId The default ID to set if none is provided.
     *
     * @return static Returns the current instance for method chaining.
     */
    public function generateId(): static
    {
        if (! empty($this->get('id'))) {
            return $this;
        }

        $slug = collect([
            'field',
            $this->get('lang'),
            $this->get('name'),
            sha1(json_encode($this->getAttributes())),
        ])->implode('-');

        return $this->set('id', Str::slug($slug));
    }

    /**
     * @param mixed|null $value
     *
     * @return static|mixed|null
     */
    public function get(string $key, $value = null)
    {
        return $this->attributes[$key] ?? $value;
    }

    /**
     * Get the old value of the field.
     *
     * @return float|int|mixed|string
     */
    public function getOldValue()
    {
        return old($this->getOldName());
    }

    /**
     * Gets the old value of the field.
     *
     * @return mixed
     */
    public function getOldName(): string
    {
        return Str::of($this->get('name'))
            ->replace(['][', '['], '.')
            ->replace([']'], '')
            ->rtrim('.')
            ->toString();
    }

    /**
     * Marks the field as having an error by appending the 'is-invalid' CSS class.
     *
     * If the field has an error (determined by the hasError() method),
     * it appends the 'is-invalid' class to the existing 'class' attribute.
     *
     * @return static Returns the current instance for method chaining.
     */
    private function markFieldWithError(): static
    {
        if (! $this->hasError()) {
            return $this;
        }

        $class = $this->get('class');

        return $this->set('class', $class.' is-invalid');
    }

    /**
     * Checks if the field has an error.
     *
     * @return bool
     */
    private function hasError(): bool
    {
        return optional(session('errors'))->has($this->getOldName()) ?? false;
    }

    /**
     * Modifies the 'name' attribute of the field by adding a prefix and/or language identifier if they are set.
     *
     * If both prefix and language are set, the name will be modified as "prefix[lang]name".
     * If only the prefix is set, the name will be modified as "prefixname".
     * If only the language is set, the name will be modified as "lang[name]".
     *
     * @return static Returns the current instance for method chaining.
     */
    protected function customizeFieldName(): static
    {
        $name = $this->get('name');
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');

        if ($prefix !== null && $lang !== null) {
            return $this->set('name', $prefix.'['.$lang.']'.$name);
        }

        if ($prefix !== null) {
            return $this->set('name', $prefix.$name);
        }

        if ($lang !== null) {
            return $this->set('name', $lang.'['.$name.']');
        }

        return $this;
    }

    /**
     * Modifies the 'value' attribute of the field.
     *
     * Retrieves the old value using the getOldValue() method, falling back to the current 'value' attribute if no old value is found.
     * If the value is a Closure, it will be executed with the current attributes and its result will be used as the value.
     *
     * @return static Returns the current instance for method chaining.
     */
    protected function updateFieldValue(): static
    {
        $value = $this->getOldValue() ?? $this->get('value');

        if ($value instanceof Closure) {
            $value = $value($this->attributes);
        }

        return $this->set('value', $value);
    }

    /**
     * Use vertical layout for the field.
     *
     * @return static
     */
    public function vertical(): static
    {
        $this->typeForm = 'platform::partials.fields.vertical';

        return $this;
    }

    /**
     * Use clear layout for the field.
     *
     * @return static
     */
    public function clear(): static
    {
        $this->typeForm = 'platform::partials.fields.clear';

        return $this;
    }

    /**
     * Use horizontal layout for the field.
     *
     * @return static
     */
    public function horizontal(): static
    {
        $this->typeForm = 'platform::partials.fields.horizontal';

        return $this;
    }

    /**
     * Displaying an item without titles or additional information.
     *
     * @return $this
     */
    public function withoutFormType(): static
    {
        $this->typeForm = static fn (array $attributes) => $attributes['slot'];

        return $this;
    }

    /**
     * Create separate line after the field.
     *
     * @return static
     */
    public function hr(): static
    {
        $this->set('hr');

        return $this;
    }

    /**
     * Adds a closure to be executed before rendering the field.
     *
     * @param Closure $closure The closure to be executed before rendering.
     *
     * @return static
     */
    public function addBeforeRender(Closure $closure): static
    {
        $this->beforeRender[] = $closure;

        return $this;
    }

    /**
     * Performs all tasks added to be executed before rendering the field.
     *
     * This method iterates over each closure added via addBeforeRender() method
     * and executes them in the context of the current field instance.
     */
    public function runBeforeRender(): static
    {
        foreach ($this->beforeRender as $before) {
            $before->call($this);
        }

        return $this;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return \Closure|mixed|object|null
     */
    private function getErrorsMessage()
    {
        return session()->get('errors', new MessageBag());
    }

    /**
     * Converts the field to a string by rendering it.
     *
     * @throws Throwable
     *
     * @return string
     */
    public function __toString(): string
    {
        $view = $this->render();

        if (is_string($view)) {
            return $view;
        }

        if (is_a($view, View::class)) {
            return (string) $view->render();
        }

        return '';
    }

    /**
     * Converts the field to an HTML string.
     *
     * @throws Throwable
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render()->toHtml();
    }

    /**
     * Add a class to the field including the existing classes.
     *
     * @param string|array $classes
     *
     * @return static
     */
    public function addClass(string|array $classes): static
    {
        $currentClasses = array_filter(explode(' ', $this->get('class', '')));
        $newClasses = is_array($classes) ? $classes : explode(' ', $classes);

        $mergedClasses = array_unique(array_merge($currentClasses, $newClasses));

        return $this->set('class', implode(' ', array_filter($mergedClasses)));
    }

     /**
     * Check if a css class name  already exists in the field.
     * 
     * @param string   $name
     * 
     * @return bool
     */
    protected function hasClass(string $name): bool
    {        
        $class = $this->get('class');

        return  Str::contains($class, $name);        
    }

    /**
     * Add unique classes to the field.
     *
     * @param string|array  $classes
     *
     * @return static
     */
    public function addClass($classes): self
    {
        $class = Str::of($this->get('class'))->explode(' ');

        if (is_array($classes)) {
            $class = Arr::toCssClasses(array_filter($class->merge($classes)->unique()->toArray()));

        } elseif (is_string($classes)){
            $classes = Str::of($classes)->trim()->explode(' ')->toArray();
            $class = Arr::toCssClasses(array_filter($class->merge($classes)->unique()->toArray()));
        }

        return  $this->set('class', $class);
    }

    /**
     * Remove the given classes from the field.
     *
     * @param string|array  $classes
     *
     * @return static
     */
    public function removeClass($classes) :self
    {
        $class = $this->get('class');

        if (is_string($classes)) {
            $classes = Arr::toCssClasses(array_filter(Str::of($classes)->trim()->explode(' ')->toArray()));
        }

        $class = Str::remove($classes, $class, false);

        return $this->set('class', $class);
    }
}
