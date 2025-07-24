<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        "name"  => "User",
        "model" => User::class,
    ];

    function fields(): array
    {
        return [
            "id"        => [
                "type"  => Type::nonNull(Type::int()),
            ],
            "name"      => [
                "type"  => Type::nonNull(Type::string()),
            ],
            "email"     => [
                "type"  => Type::nonNull(Type::string()),
            ],
            "password"  => [
                "type"  => Type::nonNull(Type::string()),
            ],
            "posts"     => [
                "type"  => Type::listOf(GraphQL::type("Post")),
            ],
            "comments"  => [
                "type"  => Type::listOf(GraphQL::type("Comment")),
            ],
        ];
    }
}

