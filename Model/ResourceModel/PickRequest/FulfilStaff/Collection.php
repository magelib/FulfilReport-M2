<?php

namespace Magestore\FulfilReport\Model\ResourceModel\PickRequest\FulfilStaff;

use Magestore\FulfilSuccess\Api\Data\PickRequestInterface;

class Collection extends \Magestore\FulfilSuccess\Model\ResourceModel\PickRequest\PickRequest\Collection
{
    protected function _initSelect()
    {
        $this->getSelect()->from(['main_table' => $this->getMainTable()]);
        $this->getSelect()->joinLeft(
            ['admin_user' => $this->getTable('admin_user')],
            'main_table.user_id = admin_user.user_id',
            [
                'username' => 'admin_user.username'
            ]
        );

        $this->getSelect()->columns([
            'total_requests' => new \Zend_Db_Expr("COUNT('pick_request_id')"),
        ]);
        $this->getSelect()->group('main_table.user_id');

        $this->addCondition();

        return $this;
    }

    /**
     * add condition.
     */
    public function addCondition()
    {
        $this->addFieldToFilter('main_table.user_id', ['notnull' => true]);

        $this->addFieldToFilter('main_table.status', PickRequestInterface::STATUS_PICKED);
    }
}