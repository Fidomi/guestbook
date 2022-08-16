<?php

namespace App\Serializer\Handler;

use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\SerializationContext as Context;
use App\Entity\Comment;

class CommentHandler implements SubscribingHandlerInterface
{

    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'App\Entity\Comment',
                'method' => 'serialize',
            ]
//            ,
//            [
//                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
//                'format' => 'json',
//                'type' => 'App\Entity\Comment',
//                'method' => 'deserialize',
//            ]
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Comment $comment, array $type, Context $context)
    {
        $userName = $comment->getUser()->getFirstname().' '.$comment->getUser()->getLastname();
        $data = [
            'text' => $comment->getText(),
            'author' => $userName,
            'conference' =>  $comment->getConference()->getSlug()
        ];

        return $visitor->visitArray($data, $type, $context);
    }

//    public function deserialize(JsonDeserializationVisitor $visitor, $data)
//    {
//    }
}