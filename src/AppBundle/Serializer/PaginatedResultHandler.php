<?php

namespace AppBundle\Serializer;


use AppBundle\Model\CompaniesPaginatedResult;
use AppBundle\Model\PaginatedResult;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

/**
 * Class PaginatedResultHandler
 *
 * @package AppBundle\Serializer
 */
class PaginatedResultHandler implements SubscribingHandlerInterface
{
    /**
     * @return array
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => PaginatedResult::class,
                'method' => 'serializeToJson',
            ],
        ];
    }

    /**
     * @param JsonSerializationVisitor $visitor
     * @param PaginatedResult $paginatedResult
     * @param array $type
     * @param Context $context
     *
     * @return array
     */
    public function serializeToJson(
        JsonSerializationVisitor $visitor,
        PaginatedResult $paginatedResult,
        array $type,
        Context $context
    )
    {
        $dataKey = $this->getDataKey($paginatedResult);

        $data = [
            $dataKey => $paginatedResult->collection,
            'limit' => $paginatedResult->limit,
            'offset' => $paginatedResult->offset,
        ];

        return $visitor->visitArray($data, $type, $context);
    }

    /**
     * Detect name for key with items list
     *
     * @param PaginatedResult $paginatedResult
     *
     * @return string
     */
    protected function getDataKey(PaginatedResult $paginatedResult)
    {
        switch (get_class($paginatedResult)) {
            case CompaniesPaginatedResult::class:
                return 'companies';
            default:
                return 'data';
        }
    }
}
