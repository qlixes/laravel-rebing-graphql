<?php

namespace App\GraphQL\Queries;

use App\Models\Comment;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Closure;

class CommentsQuery extends Query
{
    protected $attributes = [
        "name"  => "comments",
    ];

    function type(): Type
    {
        return Type::listOf(GraphQL::type("Comment"));
    }

    function args(): array
    {
        return [
            "id"        => [
                "name"  => "id",
                "type"  => Type::int(),
            ],
            "content"   => [
                "type"  => Type::nonNull(Type::string()),
            ],
        ];
    }

    function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $comment = Comment::withoutTrashed();

        if (isset($args["id"])) {
            $comment = $comment->orWhere("id", $args["id"]);
        }

        if (isset($args["post_id"])) {
            $comment = $comment->orWhere("post_id", $args["post_id"]);
        }

        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $comment = $comment->select($select)->with($with);

        return $comment->get();
    }
}
