<?php

namespace OptimistDigital\NovaBlog\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaBlog\NovaBlog;
use OptimistDigital\NovaBlog\Nova\Fields\Slug;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use OptimistDigital\NovaLocaleField\LocaleField;

class Category extends TemplateResource
{
    use HasSortableRows;

    public static $displayInNavigation = false;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'OptimistDigital\NovaBlog\Models\Category';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $locales = NovaBlog::getLocales();
        $hasManyDifferentLocales = Category::select('locale')->distinct()->get()->count() > 1;

        $fields = [
            ID::make()->sortable(),
            Text::make('Title', 'title')->rules('required'),
            Slug::make('Slug', 'slug')->rules('required', 'alpha_dash_or_slash'),
        ];

        if (NovaBlog::hasNovaLang()) {
            $fields[] = \OptimistDigital\NovaLang\NovaLangField::make('Locale', 'locale', 'locale_parent_id')->onlyOnForms();
        } else {
           $fields[] = LocaleField::make('Locale', 'locale', 'locale_parent_id')
                ->locales($locales)
                ->onlyOnForms();
        }

        if (count($locales) > 1) {
            $fields[] = LocaleField::make('Locale', 'locale', 'locale_parent_id')
                ->locales($locales)
                ->exceptOnForms()
                ->maxLocalesOnIndex(3);
        } else if ($hasManyDifferentLocales) {
            $fields[] = Text::make('Locale', 'locale')->exceptOnForms();
        }

        return collect($fields)->filter(function ($field) {
            return $field !== null;
        })->toArray();
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
