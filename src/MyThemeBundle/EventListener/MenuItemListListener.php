<?php
namespace MyThemeBundle\EventListener;

use \Avanzu\AdminThemeBundle\Model\MenuItemModel;
use \Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MenuItemListListener {

    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request)
    {
        $menuItems = [
            new MenuItemModel('right-menu', 'MENU', false),
            new MenuItemModel('right-menu-profile', 'Mi Perfil', 'fos_user_profile_show', [], 'fa fa-edit'),
            new MenuItemModel('right-menu-schedule', 'Horarios', 'schedule_default_index', [], 'fa fa-calendar'),
            new MenuItemModel('right-menu-logout', 'Salir', 'fos_user_security_logout', [], 'fa fa-sign-out'),

            new MenuItemModel('right-menu-admin', 'ADMINISTRAR', false),
            new MenuItemModel('right-menu-easyadmin-users', 'Usuarios', 'easyadmin', ['entity' => 'User', 'action' => 'list', 'menuIndex' => 0], 'fa fa-users'),
            new MenuItemModel('right-menu-easyadmin-news', 'Noticias', 'easyadmin', ['entity' => 'Notification', 'action' => 'list', 'menuIndex' => 1], 'fa fa-newspaper-o'),
            $programMenu = new MenuItemModel('right-menu-program', 'Programas', 'schedule_program_index', [], 'fa fa-calendar'),
        ];

        if (!$this->tokenStorage->getToken()->getUser()->hasRole('ROLE_ADMIN')) {
            unset($menuItems[count($menuItems) - 1]);
            unset($menuItems[count($menuItems) - 1]);
            unset($menuItems[count($menuItems) - 1]);
        }

        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    /**
     * @param string $route
     * @param MenuItemModel[] $items
     * @return mixed
     */
    protected function activateByRoute($route, $items)
    {
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