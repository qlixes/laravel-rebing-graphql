<?php

namespace App\GraphQL\Mutations;

use App\Models\Comment;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeleteCommentMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "deleteComment",
    ];

    function type(): Type
    {
        return GraphQL::type("Comment");
    }

    function args(): array
    {
        return [
            "id"        => [
                "type"  => Type::nonNull(Type::int()),
                "rules" => ["required", "numeric"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        $row = Comment::withoutTrashed()->find($args["id"]);

        if (!$row) {
            return null;
        }

        $row->delete();

        return $row;
    }
}
