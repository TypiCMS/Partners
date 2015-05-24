<?php
namespace TypiCMS\Modules\Partners\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('partners::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.partners.sidebar.icon', 'icon fa fa-fw fa-cubes');
                $item->weight = config('typicms.partners.sidebar.weight');
                $item->route('admin.partners.index');
                $item->append('admin.partners.create');
                $item->authorize(
                    $this->auth->hasAccess('partners.index')
                );
            });
        });
    }
}
