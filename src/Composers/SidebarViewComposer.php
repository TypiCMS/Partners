<?php

namespace TypiCMS\Modules\Partners\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use TypiCMS\Modules\Sidebar\SidebarGroup;
use TypiCMS\Modules\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view): void
    {
        if (Gate::denies('read partners')) {
            return;
        }
        $view->offsetGet('sidebar')->group(__(config('typicms.modules.partners.sidebar.group', 'Content')), function (SidebarGroup $group): void {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__(config('typicms.modules.partners.sidebar.label', 'Partners')), function (SidebarItem $item): void {
                $item->id = 'partners';
                $item->icon = config('typicms.modules.partners.sidebar.icon');
                $item->weight = config('typicms.modules.partners.sidebar.weight');
                $item->route('admin::index-partners');
            });
        });
    }
}
