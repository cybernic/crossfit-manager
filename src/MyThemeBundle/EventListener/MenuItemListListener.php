<?php
namespace MyThemeBundle\EventListener;

use \Avanzu\AdminThemeBundle\Model\MenuItemModel;
use \Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use \Symfony\Component\HttpFoundation\Request;

class MenuItemListListener {
    public function onSetupMenu(SidebarMenuEvent $event) {

        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request) {
        $menuItems = [
            new MenuItemModel('right-menu', 'MENU', false),
            new MenuItemModel('right-menu-profile', 'Mi Perfil', 'fos_user_profile_show', [], 'fa fa-edit'),
            $programMenu = new MenuItemModel('right-menu-program', 'Programas', 'schedule_program_index', [], 'fa fa-calendar'),
            new MenuItemModel('right-menu-schedule', 'Horarios', 'schedule_default_index', [], 'fa fa-calendar'),
        ];

        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    /**
     * @param string $route
     * @param MenuItemModel[] $items
     * @return mixed
     */
    protected function activateByRoute($route, $items) {
        foreach($items as $item) {
            if($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }

}