<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Forms\Category;

use Orchid\Forms\Form;
use Illuminate\Http\Request;
use Orchid\Press\Models\Term;
use Orchid\Press\Models\Category;
use Orchid\Press\Models\Taxonomy;
use Illuminate\Contracts\View\View;

class CategoryMainForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Information';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Taxonomy::class;

    /**
     * CategoryDescForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('platform::systems/category.information');
        parent::__construct($request);
    }

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            'slug' => 'required|max:255|unique:terms,slug,'.$this->request->get('slug').',slug',
        ];
    }

    /**
     * @param Taxonomy|null $termTaxonomy
     *
     * @return View
     */
    public function get(Taxonomy $termTaxonomy = null) : View
    {
        $termTaxonomy = $termTaxonomy ?: new $this->model([
            'id' => 0,
        ]);
        $category = Category::where('id', '!=', $termTaxonomy->id)->get();

        return view('platform::container.systems.category.info', [
            'category'     => $category,
            'termTaxonomy' => $termTaxonomy,
        ]);
    }

    /**
     * @param Request|null  $request
     * @param Taxonomy|null $termTaxonomy
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, Taxonomy $termTaxonomy = null)
    {
        if (is_null($termTaxonomy)) {
            $termTaxonomy = new $this->model();
        }

        $term = ($request->get('term_id') == 0) ? Term::create($request->all()) : Term::find($request->get('term_id'));
        $termTaxonomy->fill($this->request->all());
        $termTaxonomy->term_id = $term->id;

        $termTaxonomy->save();
        $term->save();
    }

    /**
     * @param Request  $request
     * @param Taxonomy $termTaxonomy
     *
     * @throws \Exception
     */
    public function delete(Request $request, Taxonomy $termTaxonomy)
    {
        $termTaxonomy->allChildrenTerm()->get()->each(function ($item) {
            $item->update([
                'parent_id' => 0,
            ]);
        });

        $termTaxonomy->term->delete();
        $termTaxonomy->delete();
    }
}
