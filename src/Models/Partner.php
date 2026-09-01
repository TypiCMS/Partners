<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Partners\Models;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Uri;
use Override;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Models\History;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Observers\TipTapHTMLObserver;
use TypiCMS\Modules\Core\Support\ModuleUrl;
use TypiCMS\Modules\Core\Traits\HasAdminUrls;
use TypiCMS\Modules\Core\Traits\HasBodyPresenter;
use TypiCMS\Modules\Core\Traits\HasConfigurableOrder;
use TypiCMS\Modules\Core\Traits\HasContentPresenter;
use TypiCMS\Modules\Core\Traits\HasOgImage;
use TypiCMS\Modules\Core\Traits\HasSelectableFields;
use TypiCMS\Modules\Core\Traits\HasSlugScope;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Core\Traits\Navigable;
use TypiCMS\Modules\Core\Traits\Publishable;
use TypiCMS\Translatable\HasTranslations;

/**
 * @property int $id
 * @property bool $homepage
 * @property int $position
 * @property int|null $image_id
 * @property int|null $og_image_id
 * @property string $status
 * @property string $title
 * @property string $slug
 * @property string $website
 * @property string $summary
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, History> $history
 * @property-read int|null $history_count
 * @property-read File|null $image
 * @property-read File|null $ogImage
 * @property-read mixed $thumb
 * @property-read mixed $translations
 */
#[ObservedBy([SlugObserver::class, TipTapHTMLObserver::class])]
#[Unguarded]
#[Appends(['thumb'])]
class Partner extends Model implements Sortable
{
    use HasAdminUrls;
    use HasBodyPresenter;
    use HasConfigurableOrder;
    use HasContentPresenter;
    use HasOgImage;
    use HasSelectableFields;
    use HasSlugScope;
    use HasTranslations;
    use Historable;
    use Navigable;
    use Publishable;
    use SortableTrait;

    /** @return array<string, string> */
    #[Override]
    protected function casts(): array
    {
        return [
            'homepage' => 'boolean',
        ];
    }

    /** @var array<string> */
    public array $translatable = [
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    ];

    /** @var array<string> */
    public array $tipTapContent = [
        'body',
    ];

    /** @var array<string> */
    public array $sortable = [
        'order_column_name' => 'position',
    ];

    public function url(?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        return ModuleUrl::item('partners', $this->translate('slug', $locale), $locale);
    }

    public function previewUrl(?string $locale = null): ?string
    {
        $url = $this->url($locale);

        if (! $url) {
            return null;
        }

        return (string) Uri::of($url)->withQuery(['preview' => 'true']);
    }

    /** @return Attribute<string, null> */
    protected function thumb(): Attribute
    {
        return Attribute::make(get: fn (): string => imageOrDefault($this->image, null, 54));
    }

    /** @return BelongsTo<File, $this> */
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    /** @return BelongsTo<File, $this> */
    public function ogImage(): BelongsTo
    {
        return $this->belongsTo(File::class, 'og_image_id');
    }
}
