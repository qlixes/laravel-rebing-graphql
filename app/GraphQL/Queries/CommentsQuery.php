<?php

namespace App\GraphQL\Queries;

use App\Models\Comment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

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
            "post_id"   => [
                "name"  => "id",
                "type"  => Type::int(),
            ],
        ];
    }

    function resolve($root, $args)
    {
        $comment = Comment::withoutTrashed();

        if (isset($args["id"])) {
            $comment = $comment->orWhere("id", $args["id"]);
        }

        if (isset($args["post_id"])) {
            $comment = $comment->orWhere("post_id", $args["post_id"]);
        }

        return $comment->get();
    }
}
