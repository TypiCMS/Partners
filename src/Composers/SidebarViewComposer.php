<?php

namespace TypiCMS\Modules\Partners\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read partners')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Partners'), function (SidebarItem $item) {
                $item->id = 'partners';
                $item->icon = config('typicms.partners.sidebar.icon');
                $item->weight = config('typicms.partners.sidebar.weight');
                $item->route('admin::index-partners');
                $item->append('admin::create-partner');
            });
        });
    }
}
