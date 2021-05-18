<?php

namespace Inensus\KonexaBulkRegistration\Services;


class MenuItemService
{
    public function createMenuItems()
    {
        $menuItem = [
            'name' =>'Customer Registration',
            'url_slug' =>'/konexa-bulk-registration/konexa-bulk-registration',
            'md_icon' =>'upload_file'
        ];
        return ['menuItem'=>$menuItem,'subMenuItems'=>[]];
    }
}