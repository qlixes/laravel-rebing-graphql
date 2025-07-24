<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Traits\ArrayTrait;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateUserMutation extends Mutation
{
    use ArrayTrait;

    protected $attributes = [
        "name"  => "createUser",
    ];

    function type(): Type
    {
        return GraphQL::type("User");
    }

    function args(): array
    {
        return [
            "name"      => [
                "type"  => Type::nonNull(Type::string()),
                "rules" => ["required", "string"],
            ],
            "email"     => [
                "type"  => Type::nonNull(Type::string()),
                "rules" => ["required", "email", "unique:users,email"],
            ],
            "password"  => [
                "type"  => Type::nonNull(Type::string()),
                "rules" => ["required", "string"],
            ],
        ];
    }

    function resolve($root, $args)
    {
        $password = Hash::make($args["password"]);

        $args = array_merge($args, ["password"  => $password]);

        return User::create(
            $this->array_filter($args, ["name", "email", "password"])
        );
    }
}
