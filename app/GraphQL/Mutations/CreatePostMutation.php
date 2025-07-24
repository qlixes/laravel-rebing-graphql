<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Str;

class CreatePostMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "createPost",
    ];

    function type(): Type
    {
        return GraphQL::type("Post");
    }

    function args(): array
    {
        return [
            "title"     => [
                "type"  => Type::nonNull(Type::string()),
                "rules" => ["required", "string"],
            ],
            "content"   => [
                "type"  => Type::nonNull(Type::string()),
                "rules" => ["required", "string"],
            ],
            "user_id"   => [
                "type"  => Type::nonNull(Type::int()),
                "rules" => ["required", "numeric", "exists:users,id"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        $args = array_merge($args, [
            "slug"  => Str::slug($args["title"]),
        ]);

        return Post::create(
            $this->array_filter($args, ["user_id", "title", "content", "slug"])
        );
    }
}
