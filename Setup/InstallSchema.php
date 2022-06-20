<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://www.fcamara.com.br/ for more information.
 *
 * @category  FCamara
 * @package   FCamara_
 * @copyright Copyright (c) 2020 FCamara Formação e Consultoria
 * @Agency    FCamara Formação e Consultoria, Inc. (http://www.fcamara.com.br)
 * @author    Danilo Cavalcanti de Moura <danilo.moura@fcamara.com.br>
 */

namespace FCamara\Getnet\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('fcamara_getnet_seller')) {
            $table = $installer->getConnection()->newTable($installer->getTable('fcamara_getnet_seller'))
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'merchant_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Merchant ID'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Type'
                )
                ->addColumn(
                    'legal_document_number',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'legal_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'birth_date',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                    null
                )
                ->addColumn(
                    'mothers_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'occupation',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'business_address',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'mailing_address',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'working_hours',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'phone_area_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'phone_number',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'cellphone_area_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'cellphone_number',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'email',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'acquirer_merchant_category_code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'bank',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'agency',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'account',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'account_type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'account_digit',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'accepted_contract',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'liability_chargeback',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'marketplace_store',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255
                )
                ->addColumn(
                    'payment_plan',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Getnet Seller Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
