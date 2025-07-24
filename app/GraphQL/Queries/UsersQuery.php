<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        "name"  => "users",
    ];

    function type(): Type
    {
        return Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type("User"))));
    }

    function args(): array
    {
        return [
            "id"    => [
                "name"  => "id",
                "type"  => Type::int(),
            ],
            "name"  => [
                "name"  => "name",
                "type"  => Type::string(),
            ],
            "email" => [
                "name"  => "email",
                "type"  => Type::string(),
            ],
        ];
    }

    function resolve($root, $args)
    {
        $user = User::withoutTrashed();

        if (isset($args["id"])) {
            $user = $user->orWhere("id", $args["id"]);
        }

        if (isset($args["name"])) {
            $user = $user->orWhere("name", $args["name"])->orWhere("name", "LIKE", $args["name"]);
        }

        if (isset($args["email"])) {
            $user = $user->orWhere("email", $args["email"])->orWhere("email", "LIKE", $args["email"]);
        }

        return $user->get();
    }
}
