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
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('partners::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.partners.sidebar.icon', 'icon fa fa-fw fa-cubes');
                $item->weight = config('typicms.partners.sidebar.weight');
                $item->route('admin::index-partners');
                $item->append('admin::create-partner');
                $item->authorize(
                    Gate::allows('index-partners')
                );
            });
        });
    }
}
