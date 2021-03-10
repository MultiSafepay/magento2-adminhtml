<?php

namespace MultiSafepay\ConnectAdminhtml\Plugin\Model\Config\Element;

use Magento\Config\Model\Config\Structure\Element\Field;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\GenericGatewayConfigProvider;

class FieldPlugin
{
    /**
     * @param Field $subject
     * @param string|null $result
     * @return string|null
     */
    public function afterGetConfigPath(Field $subject, ?string $result): ?string
    {
        if (strpos($result, GenericGatewayConfigProvider::CODE) !== false) {
            return $this->getGenericGatewayConfigPath($subject);
        }

        return $result;
    }

    /**
     * @param Field $field
     * @return string|null
     */
    private function getGenericGatewayConfigPath(Field $field): ?string
    {
        $elementPathArray = explode(DS, $field->getPath());
        $configPath = $field->getData()['config_path'] ?? null;

        foreach ($elementPathArray as $path) {
            if (strpos($path, GenericGatewayConfigProvider::CODE) !== false) {
                return $configPath ? str_replace(GenericGatewayConfigProvider::CODE, $path, $configPath)
                    : 'payment' . DS . $path . DS . $field->getId();
            }
        }

        return null;
    }
}
