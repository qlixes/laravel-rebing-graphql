<?php

namespace App\GraphQL\Types;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PostType extends GraphQLType
{
    protected $attributes = [
        "name"  => "Post",
        "model" => Post::class,
    ];

    function fields(): array
    {
        return [
            "id"        => [
                "type"  => Type::nonNull(Type::int()),
            ],
            "title"      => [
                "type"  => Type::nonNull(Type::string()),
            ],
            "content"     => [
                "type"  => Type::nonNull(Type::string()),
            ],
            "user"  => [
                "type"  => GraphQL::type("User"),
            ],
            "comments"  => [
                "type"  => Type::listOf(GraphQL::type("Comment")),
            ],
        ];
    }
}
