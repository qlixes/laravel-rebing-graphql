<?php

namespace App\GraphQL\Mutations;

use App\Models\Comment;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateCommentMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "updateComment",
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
            "content"  => [
                "type"  => Type::nonNull(Type::string()),
                "rules" => ["string"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        $row = Comment::withoutTrashed()->find($args["id"]);

        if (!$row) {
            return null;
        }

        $row->content = $args["content"];
        $row->save();

        return $row;
    }
}
