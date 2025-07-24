<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeletePostMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "deletePost",
    ];

    function type(): Type
    {
        return GraphQL::type("Post");
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
        $row = Post::withoutTrashed()->find($args["id"]);

        if (!$row) {
            return null;
        }

        $row->delete();

        return $row;
    }
}
