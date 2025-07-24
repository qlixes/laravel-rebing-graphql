<?php

namespace App\GraphQL\Mutations;

use App\Models\Comment;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateCommentMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "createComment",
    ];

    function type(): Type
    {
        return GraphQL::type("Comment");
    }

    function args(): array
    {
        return [
            "content"   => [
                "type"  => Type::nonNull(Type::string()),
                "rules" => ["required", "string"],
            ],
            "user_id"   => [
                "type"  => Type::nonNull(Type::int()),
                "rules" => ["required", "numeric", "exists:users,id"],
            ],
            "post_id"   => [
                "type"  => Type::nonNull(Type::int()),
                "rules" => ["required", "numeric", "exists:posts,id"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        return Comment::create(
            $this->array_filter($args, ["user_id", "post_id", "content"])
        );
    }
}
